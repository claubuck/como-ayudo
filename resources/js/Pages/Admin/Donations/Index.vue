<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps({
    donations: {
        type: Array,
        required: true,
    },
});

const deleteDonation = (id) => {
    if (confirm('¿Estás seguro de que deseas eliminar esta necesidad de donación?')) {
        router.delete(route('admin.donations.destroy', id));
    }
};

const getPriorityBadge = (priority) => {
    const badges = {
        high: { class: 'bg-red-100 text-red-800', text: 'Alta' },
        medium: { class: 'bg-amber-100 text-amber-800', text: 'Media' },
        low: { class: 'bg-blue-100 text-blue-800', text: 'Baja' },
    };
    return badges[priority] || { class: 'bg-gray-100 text-gray-800', text: priority };
};
</script>

<template>
    <Head title="Necesidades de Donación - Administración" />

    <AdminLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Necesidades de Donación</h1>
                    <p class="mt-2 text-gray-600">
                        Gestiona las necesidades de donación y su estado
                    </p>
                </div>
                <Link
                    :href="route('admin.donations.create')"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors shadow-sm"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Nueva Necesidad
                </Link>
            </div>

            <!-- Donations List -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                <div v-if="donations.length === 0" class="p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay necesidades registradas</h3>
                    <p class="mt-1 text-sm text-gray-500">Comienza agregando una necesidad de donación.</p>
                    <div class="mt-6">
                        <Link
                            :href="route('admin.donations.create')"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Nueva Necesidad
                        </Link>
                    </div>
                </div>

                <div v-else class="divide-y divide-gray-200">
                    <div
                        v-for="donation in donations"
                        :key="donation.id"
                        class="p-6 hover:bg-gray-50 transition-colors"
                    >
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center flex-wrap gap-2">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ donation.name }}</h3>
                                    <span
                                        class="px-2.5 py-1 rounded-md text-xs font-medium"
                                        :class="getPriorityBadge(donation.priority).class"
                                    >
                                        {{ getPriorityBadge(donation.priority).text }}
                                    </span>
                                    <span
                                        v-if="donation.is_fulfilled"
                                        class="px-2.5 py-1 bg-green-100 text-green-800 rounded-md text-xs font-medium"
                                    >
                                        Cubierta
                                    </span>
                                    <span
                                        v-else-if="donation.active"
                                        class="px-2.5 py-1 bg-blue-100 text-blue-800 rounded-md text-xs font-medium"
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
                                <p v-if="donation.description" class="mt-2 text-sm text-gray-600">
                                    {{ donation.description }}
                                </p>
                                <div class="mt-3 flex flex-wrap items-center gap-x-6 gap-y-1 text-sm text-gray-500">
                                    <span>
                                        {{ donation.quantity_received }} / {{ donation.quantity_needed }} {{ donation.unit }}
                                    </span>
                                    <span v-if="!donation.is_fulfilled" class="flex items-center">
                                        <span class="inline-block w-24 h-2 bg-gray-200 rounded-full overflow-hidden mr-2">
                                            <span
                                                class="block h-full bg-green-500 rounded-full transition-all"
                                                :style="{ width: donation.progress_percentage + '%' }"
                                            />
                                        </span>
                                        {{ donation.progress_percentage }}%
                                    </span>
                                    <span>Orden: {{ donation.order }}</span>
                                </div>
                            </div>
                            <div class="ml-4 flex items-center space-x-2 shrink-0">
                                <Link
                                    :href="route('admin.donations.edit', donation.id)"
                                    class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium hover:bg-blue-100 transition-colors"
                                >
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Editar
                                </Link>
                                <button
                                    @click="deleteDonation(donation.id)"
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
