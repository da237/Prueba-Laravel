<script setup>
import { onMounted, ref } from 'vue'
import { Head, useForm, router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import 'leaflet/dist/leaflet.css';
import L from 'leaflet'

const props = defineProps({ visits: Array })

const map = ref(null)
const markers = ref([])
const showModal = ref(false)
const editingVisit = ref(null)

const errores = ref({
    latitud: '',
    longitud: ''
})

const form = useForm({
    name: '',
    email: '',
    latitud: '',
    longitud: ''
})

const openModal = (visit = null) => {
    errores.value = { latitud: '', longitud: '' }

    if (visit) {
        editingVisit.value = visit
        form.name = visit.name
        form.email = visit.email
        form.latitud = visit.latitud
        form.longitud = visit.longitud
    } else {
        editingVisit.value = null

        // Solo resetea si no hay coordenadas capturadas
        if (!form.latitud || !form.longitud) {
            form.reset()
        } else {
            form.name = ''
            form.email = ''
        }
    }

    showModal.value = true
}


const closeModal = () => {
    showModal.value = false
    form.reset()
}

const validarCoordenadas = () => {
    errores.value.latitud = ''
    errores.value.longitud = ''

    const lat = parseFloat(form.latitud)
    const lng = parseFloat(form.longitud)

    let valido = true

    if (isNaN(lat) || lat < -90 || lat > 90) {
        errores.value.latitud = 'La latitud debe estar entre -90 y 90'
        valido = false
    }

    if (isNaN(lng) || lng < -180 || lng > 180) {
        errores.value.longitud = 'La longitud debe estar entre -180 y 180'
        valido = false
    }

    return valido
}

const submit = () => {
    if (!validarCoordenadas()) return

    if (editingVisit.value) {
        form.put(route('visits.update', editingVisit.value.id), {
            onSuccess: () => {
                closeModal()
                router.reload()
            }
        })
    } else {
        form.post(route('visits.store'), {
            onSuccess: () => {
                closeModal()
                router.reload()
            }
        })
    }
}

const initMap = () => {
    map.value = L.map('map').setView([5.0, -75.0], 5)

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map.value)

    props.visits.forEach((visit) => {
        if (visit.latitud && visit.longitud) {
            const marker = L.marker([visit.latitud, visit.longitud]).addTo(map.value)
            marker.bindPopup(`<strong>${visit.name}</strong><br>${visit.email}`)
            markers.value.push(marker)
        }
    })

    map.value.on('click', (e) => {
        const { lat, lng } = e.latlng

        form.latitud = lat.toFixed(6)
        form.longitud = lng.toFixed(6)

        if (markers.value.length > 0) {
            const last = markers.value.pop()
            map.value.removeLayer(last)
        }

        const marker = L.marker([lat, lng]).addTo(map.value)
        marker.bindPopup(`📍 Lat: ${lat.toFixed(6)}<br>Lng: ${lng.toFixed(6)}`).openPopup()
        markers.value.push(marker)
    })
}

onMounted(() => {
    initMap()
})

</script>

<template>
    <AuthenticatedLayout>

        <Head title="Visitas" />

        <div class="p-6 max-w-7xl mx-auto space-y-6">
            <h2 class="text-2xl font-bold">Mapa</h2>
            <div id="map" class="w-full rounded shadow mb-8"></div>

            <!-- Encabezado -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold">Listado de Visitas</h2>
                <button @click="openModal()" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Nueva Visita
                </button>
            </div>

            <!-- Tabla -->
            <table class="w-full text-left border shadow rounded bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3">Nombre</th>
                        <th class="p-3">Correo</th>
                        <th class="p-3">Latitud</th>
                        <th class="p-3">Longitud</th>
                        <th class="p-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="visit in props.visits" :key="visit.id" class="border-t">
                        <td class="p-3">{{ visit.name }}</td>
                        <td class="p-3">{{ visit.email }}</td>
                        <td class="p-3">{{ visit.latitud }}</td>
                        <td class="p-3">{{ visit.longitud }}</td>
                        <td class="p-3 space-x-2">
                            <button @click="openModal(visit)" class="text-blue-600 hover:underline">Editar</button>
                            <button
                                @click="router.delete(route('visits.destroy', visit.id), { onSuccess: () => router.reload() })"
                                class="text-red-600 hover:underline">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Modal -->
            <div v-if="showModal"
                class="fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center z-[9999]">
                <div class="bg-white p-6 rounded shadow-lg w-96 space-y-4">
                    <h3 class="text-lg font-semibold">{{ editingVisit ? 'Editar Visita' : 'Nueva Visita' }}</h3>

                    <div>
                        <label class="block text-sm font-medium">Nombre</label>
                        <input v-model="form.name" class="border w-full rounded px-3 py-2" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Email</label>
                        <input v-model="form.email" type="email" class="border w-full rounded px-3 py-2" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Latitud</label>
                        <input v-model.number="form.latitud" type="number" step="any"
                            class="border w-full rounded px-3 py-2" />
                        <p v-if="errores.latitud" class="text-red-500 text-sm">{{ errores.latitud }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Longitud</label>
                        <input v-model.number="form.longitud" type="number" step="any"
                            class="border w-full rounded px-3 py-2" />
                        <p v-if="errores.longitud" class="text-red-500 text-sm">{{ errores.longitud }}</p>
                    </div>


                    <div class="flex justify-end space-x-2">
                        <button @click="closeModal" class="bg-gray-400 text-white px-4 py-2 rounded">Cancelar</button>
                        <button @click="submit" class="bg-green-600 text-white px-4 py-2 rounded">
                            {{ editingVisit ? 'Actualizar' : 'Guardar' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
#map {
    height: 400px;
}
</style>
