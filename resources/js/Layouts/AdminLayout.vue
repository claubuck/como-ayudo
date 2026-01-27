<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const showingNavigationDropdown = ref(false);
const showingMobileMenu = ref(false);
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <!-- Navigation -->
        <nav class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <Link :href="route('admin.dashboard')" class="flex items-center space-x-2">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <span class="text-xl font-bold text-gray-900">Admin</span>
                            </Link>
                        </div>

                        <!-- Desktop Navigation Links -->
                        <div class="hidden space-x-1 sm:-my-px sm:ml-10 sm:flex">
                            <Link
                                :href="route('admin.dashboard')"
                                :class="[
                                    route().current('admin.dashboard')
                                        ? 'bg-blue-50 text-blue-700 border-blue-500'
                                        : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50 border-transparent',
                                    'inline-flex items-center px-4 py-2 border-b-2 text-sm font-medium transition-all rounded-t-lg',
                                ]"
                            >
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Dashboard
                            </Link>
                            <Link
                                :href="route('admin.zones.index')"
                                :class="[
                                    route().current('admin.zones.*')
                                        ? 'bg-blue-50 text-blue-700 border-blue-500'
                                        : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50 border-transparent',
                                    'inline-flex items-center px-4 py-2 border-b-2 text-sm font-medium transition-all rounded-t-lg',
                                ]"
                            >
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Zonas
                            </Link>
                            <Link
                                :href="route('admin.donations.index')"
                                :class="[
                                    route().current('admin.donations.*')
                                        ? 'bg-blue-50 text-blue-700 border-blue-500'
                                        : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50 border-transparent',
                                    'inline-flex items-center px-4 py-2 border-b-2 text-sm font-medium transition-all rounded-t-lg',
                                ]"
                            >
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                Donaciones
                            </Link>
                            <Link
                                :href="route('admin.donation-points.index')"
                                :class="[
                                    route().current('admin.donation-points.*')
                                        ? 'bg-blue-50 text-blue-700 border-blue-500'
                                        : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50 border-transparent',
                                    'inline-flex items-center px-4 py-2 border-b-2 text-sm font-medium transition-all rounded-t-lg',
                                ]"
                            >
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Puntos
                            </Link>
                            <Link
                                :href="route('admin.volunteers.index')"
                                :class="[
                                    route().current('admin.volunteers.*')
                                        ? 'bg-blue-50 text-blue-700 border-blue-500'
                                        : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50 border-transparent',
                                    'inline-flex items-center px-4 py-2 border-b-2 text-sm font-medium transition-all rounded-t-lg',
                                ]"
                            >
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                Voluntarios
                            </Link>
                            <Link
                                :href="route('admin.coordinators.index')"
                                :class="[
                                    route().current('admin.coordinators.*')
                                        ? 'bg-blue-50 text-blue-700 border-blue-500'
                                        : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50 border-transparent',
                                    'inline-flex items-center px-4 py-2 border-b-2 text-sm font-medium transition-all rounded-t-lg',
                                ]"
                            >
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Coordinadores
                            </Link>
                        </div>
                    </div>

                    <!-- Right Side -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                        <Link
                            :href="route('home')"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all"
                        >
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Ver Sitio
                        </Link>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="sm:hidden flex items-center">
                        <button
                            @click="showingMobileMenu = !showingMobileMenu"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500"
                        >
                            <svg v-if="!showingMobileMenu" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg v-else class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu -->
            <div v-show="showingMobileMenu" class="sm:hidden border-t border-gray-200 bg-white">
                <div class="pt-2 pb-3 space-y-1">
                    <Link
                        :href="route('admin.dashboard')"
                        :class="[
                            route().current('admin.dashboard')
                                ? 'bg-blue-50 border-blue-500 text-blue-700'
                                : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300',
                            'block pl-3 pr-4 py-2 border-l-4 text-base font-medium',
                        ]"
                    >
                        Dashboard
                    </Link>
                    <Link
                        :href="route('admin.zones.index')"
                        :class="[
                            route().current('admin.zones.*')
                                ? 'bg-blue-50 border-blue-500 text-blue-700'
                                : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300',
                            'block pl-3 pr-4 py-2 border-l-4 text-base font-medium',
                        ]"
                    >
                        Zonas
                    </Link>
                    <Link
                        :href="route('admin.donations.index')"
                        :class="[
                            route().current('admin.donations.*')
                                ? 'bg-blue-50 border-blue-500 text-blue-700'
                                : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300',
                            'block pl-3 pr-4 py-2 border-l-4 text-base font-medium',
                        ]"
                    >
                        Donaciones
                    </Link>
                    <Link
                        :href="route('admin.donation-points.index')"
                        :class="[
                            route().current('admin.donation-points.*')
                                ? 'bg-blue-50 border-blue-500 text-blue-700'
                                : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300',
                            'block pl-3 pr-4 py-2 border-l-4 text-base font-medium',
                        ]"
                    >
                        Puntos de Recepción
                    </Link>
                    <Link
                        :href="route('admin.volunteers.index')"
                        :class="[
                            route().current('admin.volunteers.*')
                                ? 'bg-blue-50 border-blue-500 text-blue-700'
                                : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300',
                            'block pl-3 pr-4 py-2 border-l-4 text-base font-medium',
                        ]"
                    >
                        Voluntarios
                    </Link>
                    <Link
                        :href="route('admin.coordinators.index')"
                        :class="[
                            route().current('admin.coordinators.*')
                                ? 'bg-blue-50 border-blue-500 text-blue-700'
                                : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300',
                            'block pl-3 pr-4 py-2 border-l-4 text-base font-medium',
                        ]"
                    >
                        Coordinadores
                    </Link>
                    <Link
                        :href="route('home')"
                        class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300"
                    >
                        Ver Sitio Público
                    </Link>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="py-8">
            <slot />
        </main>
    </div>
</template>
