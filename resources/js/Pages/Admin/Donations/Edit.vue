<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    donation: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    name: props.donation.name,
    description: props.donation.description || '',
    quantity_needed: props.donation.quantity_needed ?? 0,
    quantity_received: props.donation.quantity_received ?? 0,
    unit: props.donation.unit || 'unidades',
    priority: props.donation.priority || 'medium',
    active: props.donation.active ?? true,
    order: props.donation.order ?? 0,
});

const submit = () => {
    form.put(route('admin.donations.update', props.donation.id));
};
</script>

<template>
    <Head title="Editar Necesidad de Donación - Administración" />

    <AdminLayout>
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <Link
                    :href="route('admin.donations.index')"
                    class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-4"
                >
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Volver a Necesidades
                </Link>
                <h1 class="text-3xl font-bold text-gray-900">Editar Necesidad de Donación</h1>
                <p class="mt-2 text-gray-600">
                    Modifica la información de la necesidad de donación
                </p>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                <form @submit.prevent="submit" class="p-6 space-y-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nombre / Descripción breve *
                        </label>
                        <input
                            id="name"
                            v-model="form.name"
                            type="text"
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            :class="{ 'border-red-300 focus:ring-red-500': form.errors.name }"
                            placeholder="Ej: Agua mineral, Colchones, etc."
                        />
                        <p v-if="form.errors.name" class="mt-1.5 text-sm text-red-600">
                            {{ form.errors.name }}
                        </p>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                            Descripción detallada (opcional)
                        </label>
                        <textarea
                            id="description"
                            v-model="form.description"
                            rows="3"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            :class="{ 'border-red-300 focus:ring-red-500': form.errors.description }"
                            placeholder="Detalles adicionales sobre la necesidad..."
                        ></textarea>
                        <p v-if="form.errors.description" class="mt-1.5 text-sm text-red-600">
                            {{ form.errors.description }}
                        </p>
                    </div>

                    <!-- Quantity needed & received & unit -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label for="quantity_needed" class="block text-sm font-semibold text-gray-700 mb-2">
                                Cantidad necesaria *
                            </label>
                            <input
                                id="quantity_needed"
                                v-model.number="form.quantity_needed"
                                type="number"
                                min="0"
                                required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                :class="{ 'border-red-300 focus:ring-red-500': form.errors.quantity_needed }"
                            />
                            <p v-if="form.errors.quantity_needed" class="mt-1.5 text-sm text-red-600">
                                {{ form.errors.quantity_needed }}
                            </p>
                        </div>
                        <div>
                            <label for="quantity_received" class="block text-sm font-semibold text-gray-700 mb-2">
                                Cantidad recibida
                            </label>
                            <input
                                id="quantity_received"
                                v-model.number="form.quantity_received"
                                type="number"
                                min="0"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                :class="{ 'border-red-300 focus:ring-red-500': form.errors.quantity_received }"
                            />
                            <p v-if="form.errors.quantity_received" class="mt-1.5 text-sm text-red-600">
                                {{ form.errors.quantity_received }}
                            </p>
                        </div>
                        <div>
                            <label for="unit" class="block text-sm font-semibold text-gray-700 mb-2">
                                Unidad *
                            </label>
                            <input
                                id="unit"
                                v-model="form.unit"
                                type="text"
                                required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                :class="{ 'border-red-300 focus:ring-red-500': form.errors.unit }"
                                placeholder="unidades, cajas, litros..."
                            />
                            <p v-if="form.errors.unit" class="mt-1.5 text-sm text-red-600">
                                {{ form.errors.unit }}
                            </p>
                        </div>
                    </div>

                    <!-- Priority & Order -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="priority" class="block text-sm font-semibold text-gray-700 mb-2">
                                Prioridad *
                            </label>
                            <select
                                id="priority"
                                v-model="form.priority"
                                required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                :class="{ 'border-red-300 focus:ring-red-500': form.errors.priority }"
                            >
                                <option value="high">Alta</option>
                                <option value="medium">Media</option>
                                <option value="low">Baja</option>
                            </select>
                            <p v-if="form.errors.priority" class="mt-1.5 text-sm text-red-600">
                                {{ form.errors.priority }}
                            </p>
                        </div>
                        <div>
                            <label for="order" class="block text-sm font-semibold text-gray-700 mb-2">
                                Orden
                            </label>
                            <input
                                id="order"
                                v-model.number="form.order"
                                type="number"
                                min="0"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                :class="{ 'border-red-300 focus:ring-red-500': form.errors.order }"
                            />
                            <p v-if="form.errors.order" class="mt-1.5 text-sm text-red-600">
                                {{ form.errors.order }}
                            </p>
                        </div>
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
                            Necesidad activa (visible en la plataforma)
                        </label>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                        <Link
                            :href="route('admin.donations.index')"
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
                            <span v-else>Actualizar Necesidad</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
