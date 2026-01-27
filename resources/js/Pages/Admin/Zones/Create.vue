<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const form = useForm({
    name: '',
    description: '',
    status: 'moderate',
    active: true,
    order: 0,
});

const submit = () => {
    form.post(route('admin.zones.store'));
};
</script>

<template>
    <Head title="Nueva Zona - Administración" />

    <AdminLayout>
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <Link
                    :href="route('admin.zones.index')"
                    class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-4"
                >
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Volver a Zonas
                </Link>
                <h1 class="text-3xl font-bold text-gray-900">Nueva Zona Afectada</h1>
                <p class="mt-2 text-gray-600">
                    Agrega una nueva zona afectada por la emergencia
                </p>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                <form @submit.prevent="submit" class="p-6 space-y-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nombre de la Zona *
                        </label>
                        <input
                            id="name"
                            v-model="form.name"
                            type="text"
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            :class="{ 'border-red-300 focus:ring-red-500': form.errors.name }"
                            placeholder="Ej: Barrio Centro"
                        />
                        <p v-if="form.errors.name" class="mt-1.5 text-sm text-red-600">
                            {{ form.errors.name }}
                        </p>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                            Descripción
                        </label>
                        <textarea
                            id="description"
                            v-model="form.description"
                            rows="4"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            :class="{ 'border-red-300 focus:ring-red-500': form.errors.description }"
                            placeholder="Describe la situación de la zona..."
                        ></textarea>
                        <p v-if="form.errors.description" class="mt-1.5 text-sm text-red-600">
                            {{ form.errors.description }}
                        </p>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                            Estado *
                        </label>
                        <select
                            id="status"
                            v-model="form.status"
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            :class="{ 'border-red-300 focus:ring-red-500': form.errors.status }"
                        >
                            <option value="critical">Crítica</option>
                            <option value="moderate">Moderada</option>
                            <option value="recovering">En Recuperación</option>
                        </select>
                        <p v-if="form.errors.status" class="mt-1.5 text-sm text-red-600">
                            {{ form.errors.status }}
                        </p>
                    </div>

                    <!-- Order -->
                    <div>
                        <label for="order" class="block text-sm font-semibold text-gray-700 mb-2">
                            Orden
                        </label>
                        <input
                            id="order"
                            v-model="form.order"
                            type="number"
                            min="0"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            :class="{ 'border-red-300 focus:ring-red-500': form.errors.order }"
                        />
                        <p v-if="form.errors.order" class="mt-1.5 text-sm text-red-600">
                            {{ form.errors.order }}
                        </p>
                    </div>

                    <!-- Active -->
                    <div class="flex items-center">
                        <input
                            id="active"
                            v-model="form.active"
                            type="checkbox"
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                        />
                        <label for="active" class="ml-2 text-sm font-medium text-gray-700">
                            Zona activa
                        </label>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                        <Link
                            :href="route('admin.zones.index')"
                            class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg font-medium hover:bg-gray-200 transition-colors"
                        >
                            Cancelar
                        </Link>
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span v-if="form.processing">Guardando...</span>
                            <span v-else>Crear Zona</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
