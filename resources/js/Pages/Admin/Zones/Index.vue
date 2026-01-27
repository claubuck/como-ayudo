<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref } from 'vue';

defineProps({
    zones: {
        type: Array,
        required: true,
    },
});

const deleteZone = (id) => {
    if (confirm('¿Estás seguro de que deseas eliminar esta zona?')) {
        router.delete(route('admin.zones.destroy', id));
    }
};

const getStatusBadge = (status) => {
    const badges = {
        critical: { class: 'bg-red-100 text-red-800', text: 'Crítica' },
        moderate: { class: 'bg-yellow-100 text-yellow-800', text: 'Moderada' },
        recovering: { class: 'bg-green-100 text-green-800', text: 'En Recuperación' },
    };
    return badges[status] || { class: 'bg-gray-100 text-gray-800', text: status };
};
</script>

<template>
    <Head title="Zonas Afectadas - Administración" />

    <AdminLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Zonas Afectadas</h1>
                    <p class="mt-2 text-gray-600">
                        Gestiona las zonas afectadas por la emergencia
                    </p>
                </div>
                <Link
                    :href="route('admin.zones.create')"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors shadow-sm"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Nueva Zona
                </Link>
            </div>

            <!-- Zones List -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                <div v-if="zones.length === 0" class="p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay zonas</h3>
                    <p class="mt-1 text-sm text-gray-500">Comienza creando una nueva zona afectada.</p>
                    <div class="mt-6">
                        <Link
                            :href="route('admin.zones.create')"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Nueva Zona
                        </Link>
                    </div>
                </div>

                <div v-else class="divide-y divide-gray-200">
                    <div
                        v-for="zone in zones"
                        :key="zone.id"
                        class="p-6 hover:bg-gray-50 transition-colors"
                    >
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ zone.name }}</h3>
                                    <span
                                        class="px-2.5 py-1 rounded-md text-xs font-medium"
                                        :class="getStatusBadge(zone.status).class"
                                    >
                                        {{ getStatusBadge(zone.status).text }}
                                    </span>
                                    <span
                                        v-if="zone.active"
                                        class="px-2.5 py-1 bg-green-100 text-green-800 rounded-md text-xs font-medium"
                                    >
                                        Activa
                                    </span>
                                    <span
                                        v-else
                                        class="px-2.5 py-1 bg-gray-100 text-gray-800 rounded-md text-xs font-medium"
                                    >
                                        Inactiva
                                    </span>
                                </div>
                                <p v-if="zone.description" class="mt-2 text-sm text-gray-600">
                                    {{ zone.description }}
                                </p>
                                <div class="mt-3 flex items-center space-x-4 text-sm text-gray-500">
                                    <span>Orden: {{ zone.order }}</span>
                                </div>
                            </div>
                            <div class="ml-4 flex items-center space-x-2">
                                <Link
                                    :href="route('admin.zones.edit', zone.id)"
                                    class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium hover:bg-blue-100 transition-colors"
                                >
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Editar
                                </Link>
                                <button
                                    @click="deleteZone(zone.id)"
                                    class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-700 rounded-lg text-sm font-medium hover:bg-red-100 transition-colors"
                                >
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Eliminar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
