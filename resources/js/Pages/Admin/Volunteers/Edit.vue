<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    volunteer: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    status: props.volunteer.status || 'pending',
    notes: props.volunteer.notes || '',
});

const submit = () => {
    form.put(route('admin.volunteers.update', props.volunteer.id));
};
</script>

<template>
    <Head title="Editar Voluntario - Administración" />

    <AdminLayout>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Editar Voluntario</h1>
                        <p class="mt-2 text-gray-600">
                            Actualiza el estado y notas del voluntario
                        </p>
                    </div>
                    <Link
                        :href="route('admin.volunteers.index')"
                        class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors"
                    >
                        ← Volver
                    </Link>
                </div>
            </div>

            <!-- Volunteer Info -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Información del Voluntario</h2>
                <div class="space-y-3">
                    <div>
                        <span class="text-sm font-medium text-gray-500">Nombre:</span>
                        <span class="ml-2 text-gray-900">{{ volunteer.name }}</span>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-500">Teléfono:</span>
                        <span class="ml-2 text-gray-900">{{ volunteer.phone }}</span>
                    </div>
                    <div v-if="volunteer.email">
                        <span class="text-sm font-medium text-gray-500">Email:</span>
                        <span class="ml-2 text-gray-900">{{ volunteer.email }}</span>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-500">Tipo de ayuda:</span>
                        <span class="ml-2 text-gray-900">
                            {{ volunteer.help_type === 'volunteering' ? 'Voluntariado' : 
                              volunteer.help_type === 'donation' ? 'Donación' : 
                              volunteer.help_type === 'transport' ? 'Transporte' : 'Otro' }}
                        </span>
                    </div>
                    <div v-if="volunteer.notes">
                        <span class="text-sm font-medium text-gray-500">Notas originales:</span>
                        <p class="ml-2 text-gray-900 mt-1">{{ volunteer.notes }}</p>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-500">Registrado:</span>
                        <span class="ml-2 text-gray-900">{{ new Date(volunteer.created_at).toLocaleString('es-ES') }}</span>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                <form @submit.prevent="submit">
                    <div class="p-6 space-y-6">
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                                Estado *
                            </label>
                            <select
                                id="status"
                                v-model="form.status"
                                required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-white"
                                :class="{ 'border-red-300 focus:ring-red-500': form.errors.status }"
                            >
                                <option value="pending">Pendiente</option>
                                <option value="contacted">Contactado</option>
                                <option value="active">Activo</option>
                                <option value="completed">Completado</option>
                            </select>
                            <p v-if="form.errors.status" class="mt-1.5 text-sm text-red-600">
                                {{ form.errors.status }}
                            </p>
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">
                                Notas Administrativas
                            </label>
                            <textarea
                                id="notes"
                                v-model="form.notes"
                                rows="4"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                                :class="{ 'border-red-300 focus:ring-red-500': form.errors.notes }"
                                placeholder="Agrega notas administrativas sobre este voluntario..."
                            ></textarea>
                            <p v-if="form.errors.notes" class="mt-1.5 text-sm text-red-600">
                                {{ form.errors.notes }}
                            </p>
                            <p class="mt-1.5 text-xs text-gray-500">
                                Estas notas son solo para uso administrativo y no se mostrarán al voluntario.
                            </p>
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-end space-x-3">
                        <Link
                            :href="route('admin.volunteers.index')"
                            class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition-colors"
                        >
                            Cancelar
                        </Link>
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed shadow-sm"
                        >
                            {{ form.processing ? 'Guardando...' : 'Guardar Cambios' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
