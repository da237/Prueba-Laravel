<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage, router } from '@inertiajs/vue3';

const { props } = usePage();
const visits = props.visits;

const handleDelete = (id) => {
    if (confirm('¿Seguro que deseas eliminar?')) {
        router.delete(`/visits/${id}`);
    }
};
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

                <div v-if="$page.props.flash && $page.props.flash.success" class="alert alert-success">
                    {{ $page.props.flash.success }}
                </div>

                <Link href="/visits/create" class="btn btn-primary mb-4">
                Nueva Visita
                </Link>

                <div class="overflow-auto bg-white shadow-sm sm:rounded-lg">
                    <table class="table table-bordered w-full">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Latitud</th>
                                <th>Longitud</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="visit in visits.data" :key="visit.id">
                                <td>{{ visit.name }}</td>
                                <td>{{ visit.email }}</td>
                                <td>{{ visit.latitud }}</td>
                                <td>{{ visit.longitud }}</td>
                                <td>
                                    <Link :href="`/visits/${visit.id}/edit`" class="btn btn-warning btn-sm mr-2">Editar
                                    </Link>

                                    <button class="btn btn-danger btn-sm"
                                        @click="handleDelete(visit.id)">Eliminar</button>

                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Paginación -->
                    <div class="mt-4">
                        <Link v-for="link in visits.links" :key="link.label" :href="link.url || '#'" v-html="link.label"
                            class="mx-1" :class="{ 'text-gray-500': !link.url, 'font-bold': link.active }" />
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
