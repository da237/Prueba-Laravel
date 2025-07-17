<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue'

// Con este hook se resive el paramtero que viene desde el controlador
const page = usePage()
const visits = ref(page.props.visits)

const OnDeleteSuccess = (e) => {
    visits.value = e.props.visits
}
 
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Visitas
                </h2>

                <Link :href="route('visits.create')" class="btn btn-primary">
                    Crear Nueva Visita
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div className="relative overflow-x-auto">
                        <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-black-400">
                                <tr>
                                    <th scope="col" className="px-6 py-3">
                                        Nombre
                                    </th>
                                    <th scope="col" className="px-6 py-3">
                                        Correo
                                    </th>
                                    <th scope="col" className="px-6 py-3">
                                        Latitud
                                    </th>
                                    <th scope="col" className="px-6 py-3">
                                        Longitud
                                    </th>
                                    <th scope="col" className="px-6 py-3">
                                        Aciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="visit in visits?.data" className="bg-white border-b dark:bg-gray-800 dark:border">
                                    <th scope="row" className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ visit.name }}
                                    </th>
                                    <th scope="row" className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ visit.email }}
                                    </th>
                                    <th scope="row" className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ visit.latitud }}
                                    </th>
                                    <th scope="row" className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ visit.longitud }}
                                    </th>
                                    <th scope="row" className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        <div class="space-x-4">
                                            <Link :href="route('visits.edit',visit)">
                                                Editar
                                            </Link>
                                            <Link @success="OnDeleteSuccess" :href="route('visits.destroy',visit)" method="delete" as="button">
                                                Eliminar
                                            </Link>
                                        </div>
                                    </th>

                                </tr>
                            </tbody>

                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
