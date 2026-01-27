<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps({
    donationPoints: {
        type: Array,
        required: true,
    },
});

const deletePoint = (id) => {
    if (confirm('¿Estás seguro de que deseas eliminar este punto de recepción?')) {
        router.delete(route('admin.donation-points.destroy', id));
    }
};
</script>

<template>
    <Head title="Puntos de Recepción - Administración" />

    <AdminLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Puntos de Recepción</h1>
                    <p class="mt-2 text-gray-600">
                        Gestiona los puntos donde se reciben donaciones
                    </p>
                </div>
                <Link
                    :href="route('admin.donation-points.create')"
                    class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg font-medium hover:bg-purple-700 transition-colors shadow-sm"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Nuevo Punto
                </Link>
            </div>

            <!-- Points List -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                <!-- Action Bar (when there are points) -->
                <div v-if="donationPoints.length > 0" class="p-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                    <p class="text-sm text-gray-600">
                        Total: <span class="font-semibold text-gray-900">{{ donationPoints.length }}</span> punto(s) de recepción
                    </p>
                    <Link
                        :href="route('admin.donation-points.create')"
                        class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-medium hover:bg-purple-700 transition-colors shadow-sm"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Crear Nuevo Punto
                    </Link>
                </div>

                <div v-if="donationPoints.length === 0" class="p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay puntos de recepción</h3>
                    <p class="mt-1 text-sm text-gray-500">Comienza creando un nuevo punto de recepción.</p>
                    <div class="mt-6">
                        <Link
                            :href="route('admin.donation-points.create')"
                            class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg font-medium hover:bg-purple-700 transition-colors"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Nuevo Punto
                        </Link>
                    </div>
                </div>

                <div v-else class="divide-y divide-gray-200">
                    <div
                        v-for="point in donationPoints"
                        :key="point.id"
                        class="p-6 hover:bg-gray-50 transition-colors"
                    >
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ point.name }}</h3>
                                    <span
                                        v-if="point.active"
                                        class="px-2.5 py-1 bg-green-100 text-green-800 rounded-md text-xs font-medium"
                                    >
                                        Activo
                                    </span>
                                    <span
                                        v-else
                                        class="px-2.5 py-1 bg-gray-100 text-gray-800 rounded-md text-xs font-medium"
                                    >
                                        Inactivo
                                    </span>
                                    <span
                                        v-if="point.zone"
                                        class="px-2.5 py-1 bg-blue-100 text-blue-800 rounded-md text-xs font-medium"
                                    >
                                        {{ point.zone.name }}
                                    </span>
                                </div>
                                <div class="mt-3 space-y-1.5 text-sm text-gray-600">
                                    <p class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ point.address }}
                                    </p>
                                    <p class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ point.schedule }}
                                    </p>
                                    <div v-if="point.phone || point.whatsapp" class="flex items-center space-x-4 mt-2">
                                        <span v-if="point.phone" class="text-sm text-gray-500">
                                            📞 {{ point.phone }}
                                        </span>
                                        <span v-if="point.whatsapp" class="text-sm text-gray-500">
                                            💬 {{ point.whatsapp }}
                                        </span>
                                    </div>
                                    <p v-if="point.notes" class="mt-2 text-xs text-gray-500 italic">
                                        {{ point.notes }}
                                    </p>
                                </div>
                            </div>
                            <div class="ml-4 flex items-center space-x-2">
                                <Link
                                    :href="route('admin.donation-points.edit', point.id)"
                                    class="inline-flex items-center px-3 py-1.5 bg-purple-50 text-purple-700 rounded-lg text-sm font-medium hover:bg-purple-100 transition-colors"
                                >
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Editar
                                </Link>
                                <button
                                    @click="deletePoint(point.id)"
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
