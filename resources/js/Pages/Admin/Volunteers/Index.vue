<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref } from 'vue';

defineProps({
    volunteers: {
        type: Array,
        required: true,
    },
});

const deleteVolunteer = (id) => {
    if (confirm('¿Estás seguro de que deseas eliminar este voluntario?')) {
        router.delete(route('admin.volunteers.destroy', id));
    }
};

const getStatusBadge = (status) => {
    const badges = {
        pending: { class: 'bg-yellow-100 text-yellow-800', text: 'Pendiente' },
        contacted: { class: 'bg-blue-100 text-blue-800', text: 'Contactado' },
        active: { class: 'bg-green-100 text-green-800', text: 'Activo' },
        completed: { class: 'bg-gray-100 text-gray-800', text: 'Completado' },
    };
    return badges[status] || { class: 'bg-gray-100 text-gray-800', text: status || 'Pendiente' };
};

const getHelpTypeBadge = (helpType) => {
    const badges = {
        volunteering: { class: 'bg-blue-100 text-blue-800', text: 'Voluntariado' },
        donation: { class: 'bg-green-100 text-green-800', text: 'Donación' },
        transport: { class: 'bg-purple-100 text-purple-800', text: 'Transporte' },
        other: { class: 'bg-gray-100 text-gray-800', text: 'Otro' },
    };
    return badges[helpType] || { class: 'bg-gray-100 text-gray-800', text: helpType || 'Otro' };
};

const getWhatsAppUrl = (phone) => {
    if (!phone) return '#';
    const cleanPhone = phone.replace(/\D/g, '');
    return `https://wa.me/${cleanPhone}`;
};
</script>

<template>
    <Head title="Voluntarios - Administración" />

    <AdminLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Voluntarios</h1>
                <p class="mt-2 text-gray-600">
                    Gestiona los registros de personas que quieren ayudar
                </p>
            </div>

            <!-- Volunteers List -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                <div v-if="volunteers.length === 0" class="p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay voluntarios registrados</h3>
                    <p class="mt-1 text-sm text-gray-500">Los registros aparecerán aquí cuando alguien complete el formulario "Quiero Ayudar".</p>
                </div>

                <div v-else class="divide-y divide-gray-200">
                    <div
                        v-for="volunteer in volunteers"
                        :key="volunteer.id"
                        class="p-6 hover:bg-gray-50 transition-colors"
                    >
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-3">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ volunteer.name }}</h3>
                                    <span
                                        class="px-2.5 py-1 rounded-md text-xs font-medium"
                                        :class="getStatusBadge(volunteer.status).class"
                                    >
                                        {{ getStatusBadge(volunteer.status).text }}
                                    </span>
                                    <span
                                        class="px-2.5 py-1 rounded-md text-xs font-medium"
                                        :class="getHelpTypeBadge(volunteer.help_type).class"
                                    >
                                        {{ getHelpTypeBadge(volunteer.help_type).text }}
                                    </span>
                                </div>
                                
                                <div class="space-y-2 text-sm text-gray-600">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <span>{{ volunteer.phone }}</span>
                                        <a
                                            v-if="volunteer.phone"
                                            :href="getWhatsAppUrl(volunteer.phone)"
                                            target="_blank"
                                            class="ml-3 inline-flex items-center px-2 py-1 bg-green-50 text-green-700 rounded text-xs font-medium hover:bg-green-100 transition-colors"
                                        >
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                            </svg>
                                            WhatsApp
                                        </a>
                                    </div>
                                    <div v-if="volunteer.email" class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <a :href="`mailto:${volunteer.email}`" class="text-blue-600 hover:text-blue-800">
                                            {{ volunteer.email }}
                                        </a>
                                    </div>
                                    <div v-if="volunteer.notes" class="mt-3 pt-3 border-t border-gray-200">
                                        <p class="text-sm text-gray-700">
                                            <span class="font-medium">Notas:</span> {{ volunteer.notes }}
                                        </p>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-2">
                                        Registrado: {{ new Date(volunteer.created_at).toLocaleString('es-ES') }}
                                    </div>
                                </div>
                            </div>
                            <div class="ml-4 flex items-center space-x-2">
                                <Link
                                    :href="route('admin.volunteers.edit', volunteer.id)"
                                    class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium hover:bg-blue-100 transition-colors"
                                >
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Editar
                                </Link>
                                <button
                                    @click="deleteVolunteer(volunteer.id)"
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
