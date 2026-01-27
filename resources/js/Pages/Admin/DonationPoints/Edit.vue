<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    donationPoint: {
        type: Object,
        required: true,
    },
    zones: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    zone_id: props.donationPoint.zone_id || null,
    name: props.donationPoint.name,
    address: props.donationPoint.address,
    schedule: props.donationPoint.schedule,
    phone: props.donationPoint.phone || '',
    whatsapp: props.donationPoint.whatsapp || '',
    notes: props.donationPoint.notes || '',
    active: props.donationPoint.active,
    order: props.donationPoint.order,
});

const submit = () => {
    form.put(route('admin.donation-points.update', props.donationPoint.id));
};
</script>

<template>
    <Head title="Editar Punto de Recepción - Administración" />

    <AdminLayout>
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <Link
                    :href="route('admin.donation-points.index')"
                    class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-4"
                >
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Volver a Puntos de Recepción
                </Link>
                <h1 class="text-3xl font-bold text-gray-900">Editar Punto de Recepción</h1>
                <p class="mt-2 text-gray-600">
                    Modifica la información del punto de recepción
                </p>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                <form @submit.prevent="submit" class="p-6 space-y-6">
                    <!-- Zone -->
                    <div>
                        <label for="zone_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Zona Afectada
                        </label>
                        <select
                            id="zone_id"
                            v-model="form.zone_id"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                            :class="{ 'border-red-300 focus:ring-red-500': form.errors.zone_id }"
                        >
                            <option :value="null">Sin zona específica</option>
                            <option
                                v-for="zone in zones"
                                :key="zone.id"
                                :value="zone.id"
                            >
                                {{ zone.name }}
                            </option>
                        </select>
                        <p v-if="form.errors.zone_id" class="mt-1.5 text-sm text-red-600">
                            {{ form.errors.zone_id }}
                        </p>
                    </div>

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nombre del Punto *
                        </label>
                        <input
                            id="name"
                            v-model="form.name"
                            type="text"
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                            :class="{ 'border-red-300 focus:ring-red-500': form.errors.name }"
                            placeholder="Ej: Centro de Recepción Municipal"
                        />
                        <p v-if="form.errors.name" class="mt-1.5 text-sm text-red-600">
                            {{ form.errors.name }}
                        </p>
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
                            Dirección *
                        </label>
                        <input
                            id="address"
                            v-model="form.address"
                            type="text"
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                            :class="{ 'border-red-300 focus:ring-red-500': form.errors.address }"
                            placeholder="Ej: Av. Principal 123, Centro"
                        />
                        <p v-if="form.errors.address" class="mt-1.5 text-sm text-red-600">
                            {{ form.errors.address }}
                        </p>
                    </div>

                    <!-- Schedule -->
                    <div>
                        <label for="schedule" class="block text-sm font-semibold text-gray-700 mb-2">
                            Horarios *
                        </label>
                        <input
                            id="schedule"
                            v-model="form.schedule"
                            type="text"
                            required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                            :class="{ 'border-red-300 focus:ring-red-500': form.errors.schedule }"
                            placeholder="Ej: Lunes a Domingo: 8:00 - 20:00"
                        />
                        <p v-if="form.errors.schedule" class="mt-1.5 text-sm text-red-600">
                            {{ form.errors.schedule }}
                        </p>
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                            Teléfono
                        </label>
                        <input
                            id="phone"
                            v-model="form.phone"
                            type="tel"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                            :class="{ 'border-red-300 focus:ring-red-500': form.errors.phone }"
                            placeholder="Ej: +5491234567890"
                        />
                        <p v-if="form.errors.phone" class="mt-1.5 text-sm text-red-600">
                            {{ form.errors.phone }}
                        </p>
                    </div>

                    <!-- WhatsApp -->
                    <div>
                        <label for="whatsapp" class="block text-sm font-semibold text-gray-700 mb-2">
                            WhatsApp
                        </label>
                        <input
                            id="whatsapp"
                            v-model="form.whatsapp"
                            type="tel"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                            :class="{ 'border-red-300 focus:ring-red-500': form.errors.whatsapp }"
                            placeholder="Ej: +5491234567890"
                        />
                        <p v-if="form.errors.whatsapp" class="mt-1.5 text-sm text-red-600">
                            {{ form.errors.whatsapp }}
                        </p>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">
                            Notas
                        </label>
                        <textarea
                            id="notes"
                            v-model="form.notes"
                            rows="3"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                            :class="{ 'border-red-300 focus:ring-red-500': form.errors.notes }"
                            placeholder="Información adicional sobre el punto de recepción..."
                        ></textarea>
                        <p v-if="form.errors.notes" class="mt-1.5 text-sm text-red-600">
                            {{ form.errors.notes }}
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
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
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
                            class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500"
                        />
                        <label for="active" class="ml-2 text-sm font-medium text-gray-700">
                            Punto activo
                        </label>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                        <Link
                            :href="route('admin.donation-points.index')"
                            class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg font-medium hover:bg-gray-200 transition-colors"
                        >
                            Cancelar
                        </Link>
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="px-4 py-2 bg-purple-600 text-white rounded-lg font-medium hover:bg-purple-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span v-if="form.processing">Guardando...</span>
                            <span v-else>Actualizar Punto</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
