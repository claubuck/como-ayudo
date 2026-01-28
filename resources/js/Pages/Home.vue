<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, computed, nextTick } from 'vue';

const props = defineProps({
    zones: {
        type: Array,
        default: () => [],
    },
    donations: {
        type: Array,
        default: () => [],
    },
});

const showVolunteerForm = ref(false);
const activeTab = ref('zones');
const nameInputRef = ref(null);

const volunteerForm = useForm({
    name: '',
    phone: '',
    email: '',
    help_type: 'volunteering',
    notes: '',
});

const submitVolunteer = () => {
    volunteerForm.post(route('volunteers.store'), {
        preserveScroll: true,
        onSuccess: () => {
            volunteerForm.reset();
            showVolunteerForm.value = false;
        },
    });
};

const getWhatsAppUrl = (phone) => {
    if (!phone) return '#';
    const cleanPhone = phone.replace(/\D/g, '');
    return `https://wa.me/${cleanPhone}`;
};

const getStatusBadge = (status) => {
    const badges = {
        critical: { class: 'bg-red-100 text-red-800', text: 'Crítica' },
        moderate: { class: 'bg-amber-100 text-amber-800', text: 'Moderada' },
        recovering: { class: 'bg-emerald-100 text-emerald-800', text: 'Recuperación' },
    };
    return badges[status] || badges.moderate;
};

const getPriorityBadge = (priority) => {
    const badges = {
        high: { class: 'bg-red-100 text-red-800', text: 'Alta' },
        medium: { class: 'bg-amber-100 text-amber-800', text: 'Media' },
        low: { class: 'bg-blue-100 text-blue-800', text: 'Baja' },
    };
    return badges[priority] || badges.medium;
};

const urgentDonations = computed(() => {
    return props.donations?.filter(d => d.priority === 'high' && !d.is_fulfilled) || [];
});

const scrollToTabs = () => {
    setTimeout(() => {
        const tabsContainer = document.querySelector('.tabs-container');
        if (tabsContainer) {
            const offset = 80; // Offset para el header sticky
            const elementPosition = tabsContainer.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - offset;
            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        }
    }, 150);
};

const showZones = () => {
    activeTab.value = 'zones';
    scrollToTabs();
    console.log('Zonas:', props.zones); // Debug temporal
    if (props.zones && props.zones.length > 0) {
        console.log('Primera zona donation_points:', props.zones[0]?.donation_points);
    }
};

const showDonations = () => {
    activeTab.value = 'donations';
    scrollToTabs();
};

const showPoints = () => {
    activeTab.value = 'points';
    scrollToTabs();
};

const showVolunteerFormAction = async () => {
    showVolunteerForm.value = true;
    activeTab.value = 'help';
    scrollToTabs();
    
    // Esperar a que el DOM se actualice y luego hacer focus al primer campo
    await nextTick();
    setTimeout(() => {
        if (nameInputRef.value) {
            nameInputRef.value.focus();
        }
    }, 300);
};

const totalDonationPoints = computed(() => {
    if (!props.zones || !Array.isArray(props.zones)) {
        return 0;
    }
    return props.zones.reduce((total, zone) => {
        if (!zone || !zone.donation_points) {
            return total;
        }
        return total + (Array.isArray(zone.donation_points) ? zone.donation_points.length : 0);
    }, 0);
});

const shareUrl = 'https://www.comoayudo.com';
const shareText = 'Plataforma sin fines de lucro que centraliza información sobre zonas afectadas, donaciones, puntos de recepción y cómo ayudar durante emergencias.';

const shareOnFacebook = () => {
    const url = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareUrl)}`;
    window.open(url, '_blank', 'width=600,height=400');
};

const shareOnTwitter = () => {
    const url = `https://twitter.com/intent/tweet?url=${encodeURIComponent(shareUrl)}&text=${encodeURIComponent(shareText)}`;
    window.open(url, '_blank', 'width=600,height=400');
};

const shareOnWhatsApp = () => {
    const url = `https://wa.me/?text=${encodeURIComponent(shareText + ' ' + shareUrl)}`;
    window.open(url, '_blank');
};

const shareOnLinkedIn = () => {
    const url = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(shareUrl)}`;
    window.open(url, '_blank', 'width=600,height=400');
};

const copyToClipboard = async () => {
    try {
        await navigator.clipboard.writeText(shareUrl);
        alert('¡Link copiado al portapapeles! Compártelo donde quieras.');
    } catch (err) {
        console.error('Error al copiar:', err);
    }
};
</script>

<template>
    <Head>
        <title>Centro de Ayuda - Información Centralizada para Emergencias</title>
        <meta name="description" content="Plataforma sin fines de lucro que centraliza información sobre zonas afectadas, donaciones, puntos de recepción y cómo ayudar durante emergencias. Únete como voluntario o dona para ayudar a quienes más lo necesitan." />
        <meta name="keywords" content="ayuda humanitaria, emergencias, donaciones, voluntariado, zonas afectadas, centro de ayuda, información emergencia, cómo ayudar" />
        <meta name="robots" content="index, follow" />
        <meta name="author" content="Centro de Ayuda" />
        
        <!-- Open Graph -->
        <meta property="og:title" content="Centro de Ayuda - Información Centralizada para Emergencias" />
        <meta property="og:description" content="Plataforma sin fines de lucro que centraliza información sobre zonas afectadas, donaciones, puntos de recepción y cómo ayudar durante emergencias." />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://www.comoayudo.com" />
        <meta property="og:site_name" content="Centro de Ayuda" />
        <meta property="og:locale" content="es_ES" />
        
        <!-- Twitter Card -->
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="Centro de Ayuda - Información Centralizada para Emergencias" />
        <meta name="twitter:description" content="Plataforma sin fines de lucro que centraliza información sobre zonas afectadas, donaciones, puntos de recepción y cómo ayudar durante emergencias." />
        
        <!-- Canonical -->
        <link rel="canonical" href="https://www.comoayudo.com" />
        
        <!-- Structured Data (JSON-LD) -->
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "NGO",
            "name": "Centro de Ayuda",
            "description": "Plataforma sin fines de lucro que centraliza información sobre zonas afectadas, donaciones, puntos de recepción y cómo ayudar durante emergencias",
            "url": "https://www.comoayudo.com",
            "logo": "https://www.comoayudo.com/favicon.svg",
            "contactPoint": {
                "@type": "ContactPoint",
                "contactType": "Desarrollador",
                "email": "desarrollador@comoayudo.com"
            },
            "sameAs": [],
            "nonprofitStatus": "NonprofitType",
            "foundingDate": "2026",
            "areaServed": {
                "@type": "Country",
                "name": "España"
            }
        }
        </script>
    </Head>

    <div class="min-h-screen bg-slate-50">
        <!-- Header -->
        <header class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center space-x-6">
                        <div class="flex-shrink-0">
                            <h1 class="text-xl font-bold text-slate-900">Centro de Ayuda</h1>
                        </div>
                        <div class="hidden md:flex items-center space-x-1 text-sm text-slate-600">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ zones?.length || 0 }} Zonas
                            </span>
                            <span class="text-slate-300">•</span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                {{ donations?.length || 0 }} Necesidades
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button
                            @click="activeTab = 'donations'"
                            class="hidden sm:inline-flex items-center px-3 py-2 text-sm font-medium text-slate-700 hover:text-slate-900 hover:bg-slate-50 rounded-lg transition-colors"
                        >
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            Ver Necesidades
                        </button>
                        <button
                            @click="showVolunteerFormAction"
                            class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors shadow-sm"
                        >
                            Quiero Ayudar
                        </button>
                        <Link
                            v-if="$page.props.auth?.user"
                            :href="route('admin.dashboard')"
                            class="hidden sm:inline-flex items-center px-3 py-2 text-sm font-medium text-slate-700 hover:text-slate-900 hover:bg-slate-50 rounded-lg transition-colors border border-slate-200"
                        >
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Admin
                        </Link>
                    </div>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
                <div class="text-center max-w-3xl mx-auto">
                    <h2 class="text-4xl sm:text-5xl font-bold mb-4">
                        Información Centralizada
                    </h2>
                    <p class="text-xl text-blue-100 mb-8">
                        Toda la información sobre la emergencia y cómo ayudar en un solo lugar
                    </p>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 pb-16">
            <!-- Stats Cards -->
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8">
                <button
                    @click="showZones"
                    class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 text-center hover:shadow-md hover:border-blue-300 transition-all cursor-pointer group"
                >
                    <div class="text-3xl font-bold text-slate-900 mb-1 group-hover:text-blue-600 transition-colors">
                        {{ zones?.length || 0 }}
                    </div>
                    <div class="text-sm text-slate-600 group-hover:text-slate-900 transition-colors">Zonas Afectadas</div>
                    <div class="mt-2 text-xs text-blue-600 opacity-0 group-hover:opacity-100 transition-opacity">
                        Ver detalles →
                    </div>
                </button>
                <button
                    @click="showDonations"
                    class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 text-center hover:shadow-md hover:border-blue-300 transition-all cursor-pointer group"
                >
                    <div class="text-3xl font-bold text-slate-900 mb-1 group-hover:text-blue-600 transition-colors">
                        {{ donations?.length || 0 }}
                    </div>
                    <div class="text-sm text-slate-600 group-hover:text-slate-900 transition-colors">Necesidades</div>
                    <div class="mt-2 text-xs text-blue-600 opacity-0 group-hover:opacity-100 transition-opacity">
                        Ver detalles →
                    </div>
                </button>
                <button
                    @click="showPoints"
                    class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 text-center hover:shadow-md hover:border-blue-300 transition-all cursor-pointer group"
                >
                    <div class="text-3xl font-bold text-slate-900 mb-1 group-hover:text-blue-600 transition-colors">
                        {{ totalDonationPoints }}
                    </div>
                    <div class="text-sm text-slate-600 group-hover:text-slate-900 transition-colors">Puntos de Recepción</div>
                    <div class="mt-2 text-xs text-blue-600 opacity-0 group-hover:opacity-100 transition-opacity">
                        Ver detalles →
                    </div>
                </button>
            </div>

            <!-- Alert -->
            <div v-if="urgentDonations.length > 0" class="mb-8 bg-red-50 border border-red-200 rounded-xl p-4">
                <div class="flex items-start">
                    <svg class="h-5 w-5 text-red-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <div>
                        <h3 class="text-sm font-semibold text-red-900 mb-1">Necesidades Urgentes</h3>
                        <p class="text-sm text-red-700">
                            Hay {{ urgentDonations.length }} donación(es) con prioridad alta que requieren atención inmediata.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="tabs-container bg-white rounded-xl shadow-sm border border-slate-200 mb-6">
                <div class="border-b border-slate-200">
                    <nav class="flex overflow-x-auto -mb-px">
                        <button
                            @click="activeTab = 'overview'"
                            :class="[
                                activeTab === 'overview'
                                    ? 'border-blue-600 text-blue-600'
                                    : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300',
                                'whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors',
                            ]"
                        >
                            Resumen
                        </button>
                        <button
                            @click="activeTab = 'zones'"
                            :class="[
                                activeTab === 'zones'
                                    ? 'border-blue-600 text-blue-600'
                                    : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300',
                                'whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors',
                            ]"
                        >
                            Zonas Afectadas
                        </button>
                        <button
                            @click="activeTab = 'donations'"
                            :class="[
                                activeTab === 'donations'
                                    ? 'border-blue-600 text-blue-600'
                                    : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300',
                                'whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors',
                            ]"
                        >
                            Donaciones
                        </button>
                        <button
                            @click="activeTab = 'points'"
                            :class="[
                                activeTab === 'points'
                                    ? 'border-blue-600 text-blue-600'
                                    : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300',
                                'whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors',
                            ]"
                        >
                            Puntos de Recepción
                        </button>
                        <button
                            @click="activeTab = 'help'"
                            :class="[
                                activeTab === 'help'
                                    ? 'border-blue-600 text-blue-600'
                                    : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300',
                                'whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors',
                            ]"
                        >
                            Quiero Ayudar
                        </button>
                    </nav>
                </div>

                <div class="p-6">
                    <!-- Overview Tab -->
                    <div v-show="activeTab === 'overview'" class="space-y-8">
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900 mb-4">Situación Actual</h2>
                            <div class="bg-slate-50 rounded-lg p-6 border border-slate-200">
                                <p class="text-slate-700 leading-relaxed">
                                    La zona está afectada por inundaciones. Esta plataforma centraliza
                                    toda la información para coordinar la ayuda de manera eficiente y
                                    asegurar que llegue a quienes más lo necesitan.
                                </p>
                            </div>
                        </div>

                    </div>

                    <!-- Zones Tab -->
                    <div v-show="activeTab === 'zones'" class="space-y-6">
                        <div v-if="!zones || zones.length === 0" class="text-center py-12 text-slate-500">
                            No hay zonas registradas.
                        </div>
                        <template v-else>
                            <template v-for="zone in zones" :key="zone?.id">
                                <div
                                    v-if="zone"
                                    class="bg-white rounded-lg border border-slate-200 p-6"
                                >
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-slate-900 mb-1">{{ zone?.name || '' }}</h3>
                                    <p v-if="zone?.description" class="text-sm text-slate-600 leading-relaxed">
                                        {{ zone.description }}
                                    </p>
                                </div>
                                <span
                                    v-if="zone?.status"
                                    class="px-2.5 py-1 rounded-md text-xs font-medium ml-4 flex-shrink-0"
                                    :class="getStatusBadge(zone.status).class"
                                >
                                    {{ getStatusBadge(zone.status).text }}
                                </span>
                            </div>
                            
                            <!-- Puntos de Recepción de esta Zona -->
                            <div v-if="zone && zone.donation_points && zone.donation_points.length > 0" class="mt-6 pt-6 border-t border-slate-200">
                                <h4 class="text-sm font-semibold text-slate-900 mb-3">Puntos de Recepción en esta zona:</h4>
                                <div class="space-y-3">
                                    <template v-for="point in zone.donation_points" :key="point?.id">
                                        <div
                                            v-if="point"
                                            class="bg-slate-50 rounded-lg p-4 border border-slate-200"
                                        >
                                        <h5 class="font-medium text-slate-900 mb-2">{{ point.name }}</h5>
                                        <div class="space-y-1.5 text-sm">
                                            <p class="text-slate-600">
                                                <span class="font-medium">📍 Dirección:</span> {{ point.address }}
                                            </p>
                                            <p class="text-slate-600">
                                                <span class="font-medium">🕐 Horarios:</span> {{ point.schedule }}
                                            </p>
                                            <p v-if="point.notes" class="text-slate-500 text-xs mt-2">
                                                {{ point.notes }}
                                            </p>
                                        </div>
                                        <div class="flex flex-wrap gap-2 mt-3">
                                            <a
                                                v-if="point.whatsapp"
                                                :href="getWhatsAppUrl(point.whatsapp)"
                                                target="_blank"
                                                class="inline-flex items-center px-3 py-1.5 bg-green-50 text-green-700 rounded-lg text-xs font-medium hover:bg-green-100 transition-colors border border-green-200"
                                            >
                                                <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                                </svg>
                                                WhatsApp
                                            </a>
                                            <a
                                                v-if="point.phone"
                                                :href="`tel:${point.phone}`"
                                                class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-xs font-medium hover:bg-blue-100 transition-colors border border-blue-200"
                                            >
                                                📞 Llamar
                                            </a>
                                        </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            <div v-else class="mt-4 pt-4 border-t border-slate-200">
                                <p class="text-sm text-slate-500 italic">No hay puntos de recepción registrados para esta zona.</p>
                            </div>
                                </div>
                            </template>
                        </template>
                    </div>

                    <!-- Donations Tab -->
                    <div v-show="activeTab === 'donations'" id="donations" class="space-y-4">
                        <div v-if="!donations || donations.length === 0" class="text-center py-12 text-slate-500">
                            No hay donaciones registradas en este momento.
                        </div>
                        <div
                            v-for="donation in donations"
                            :key="donation.id"
                            class="bg-white rounded-lg border border-slate-200 p-6"
                        >
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <h3 class="text-lg font-semibold text-slate-900">{{ donation.name }}</h3>
                                        <span
                                            class="px-2.5 py-1 rounded-md text-xs font-medium"
                                            :class="getPriorityBadge(donation.priority).class"
                                        >
                                            {{ getPriorityBadge(donation.priority).text }}
                                        </span>
                                        <span
                                            v-if="donation.is_fulfilled"
                                            class="px-2.5 py-1 bg-emerald-100 text-emerald-800 rounded-md text-xs font-medium"
                                        >
                                            ✓ Cubierto
                                        </span>
                                    </div>
                                    <p v-if="donation.description" class="text-sm text-slate-600 mb-3">
                                        {{ donation.description }}
                                    </p>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-slate-600">
                                        {{ donation.quantity_received }} / {{ donation.quantity_needed }} {{ donation.unit }}
                                    </span>
                                    <span class="font-semibold text-slate-900">{{ donation.progress_percentage }}%</span>
                                </div>
                                <div class="w-full bg-slate-200 rounded-full h-2 overflow-hidden">
                                    <div
                                        class="h-full rounded-full transition-all duration-300"
                                        :class="donation.is_fulfilled ? 'bg-emerald-500' : 'bg-blue-500'"
                                        :style="`width: ${Math.min(100, donation.progress_percentage)}%`"
                                    ></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Points Tab -->
                    <div v-show="activeTab === 'points'" class="space-y-6">
                        <div v-if="!zones || zones.length === 0" class="text-center py-12 text-slate-500">
                            No hay zonas registradas.
                        </div>
                        <template v-else>
                            <template v-for="zone in zones" :key="zone?.id">
                                <div
                                    v-if="zone && zone.donation_points && zone.donation_points.length > 0"
                                    class="bg-white rounded-lg border border-slate-200 p-6"
                                >
                                    <div class="flex items-center justify-between mb-4 pb-4 border-b border-slate-200">
                                        <h3 class="text-lg font-semibold text-slate-900">{{ zone.name }}</h3>
                                        <span
                                            class="px-2.5 py-1 rounded-md text-xs font-medium"
                                            :class="getStatusBadge(zone.status).class"
                                        >
                                            {{ getStatusBadge(zone.status).text }}
                                        </span>
                                    </div>
                                    <div class="space-y-4">
                                        <div
                                            v-for="point in zone.donation_points"
                                            :key="point?.id"
                                            class="bg-slate-50 rounded-lg p-4 border border-slate-200"
                                        >
                                            <h4 class="font-medium text-slate-900 mb-3">{{ point.name }}</h4>
                                            <div class="space-y-2 text-sm">
                                                <div class="flex items-start">
                                                    <span class="text-slate-400 mr-3 mt-0.5">📍</span>
                                                    <div>
                                                        <p class="font-medium text-slate-500 mb-0.5">Dirección</p>
                                                        <p class="text-slate-900">{{ point.address }}</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-start">
                                                    <span class="text-slate-400 mr-3 mt-0.5">🕐</span>
                                                    <div>
                                                        <p class="font-medium text-slate-500 mb-0.5">Horarios</p>
                                                        <p class="text-slate-900">{{ point.schedule }}</p>
                                                    </div>
                                                </div>
                                                <p v-if="point.notes" class="text-slate-600 mt-2 pl-8 text-xs">
                                                    {{ point.notes }}
                                                </p>
                                            </div>
                                            <div class="flex flex-wrap gap-2 mt-4">
                                                <a
                                                    v-if="point.whatsapp"
                                                    :href="getWhatsAppUrl(point.whatsapp)"
                                                    target="_blank"
                                                    class="inline-flex items-center px-3 py-1.5 bg-green-50 text-green-700 rounded-lg text-xs font-medium hover:bg-green-100 transition-colors border border-green-200"
                                                >
                                                    <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                                    </svg>
                                                    WhatsApp
                                                </a>
                                                <a
                                                    v-if="point.phone"
                                                    :href="`tel:${point.phone}`"
                                                    class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-xs font-medium hover:bg-blue-100 transition-colors border border-blue-200"
                                                >
                                                    📞 Llamar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <div v-if="zones && zones.every(z => !z || !z.donation_points || z.donation_points.length === 0)" class="text-center py-12 text-slate-500">
                                No hay puntos de recepción registrados.
                            </div>
                        </template>
                    </div>

                    <!-- Help Tab -->
                    <div v-show="activeTab === 'help'">
                        <div v-if="!showVolunteerForm" class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-slate-900 mb-2">¡Tu ayuda es importante!</h3>
                            <p class="text-slate-600 mb-6 max-w-md mx-auto">
                                Completa el formulario y nos pondremos en contacto contigo para coordinar tu ayuda.
                            </p>
                            <button
                                @click="showVolunteerFormAction"
                                class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors shadow-sm"
                            >
                                Completar Formulario
                            </button>
                        </div>

                        <form
                            v-else
                            @submit.prevent="submitVolunteer"
                            class="max-w-2xl mx-auto space-y-5"
                        >
                            <div>
                                <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Nombre completo *
                                </label>
                                <input
                                    ref="nameInputRef"
                                    id="name"
                                    v-model="volunteerForm.name"
                                    type="text"
                                    required
                                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                    :class="{ 'border-red-300 focus:ring-red-500': volunteerForm.errors.name }"
                                    placeholder="Ingresa tu nombre completo"
                                />
                                <p v-if="volunteerForm.errors.name" class="mt-1.5 text-sm text-red-600">
                                    {{ volunteerForm.errors.name }}
                                </p>
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Teléfono *
                                </label>
                                <input
                                    id="phone"
                                    v-model="volunteerForm.phone"
                                    type="tel"
                                    required
                                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                    :class="{ 'border-red-300 focus:ring-red-500': volunteerForm.errors.phone }"
                                    placeholder="Ej: +54 9 11 1234-5678"
                                />
                                <p v-if="volunteerForm.errors.phone" class="mt-1.5 text-sm text-red-600">
                                    {{ volunteerForm.errors.phone }}
                                </p>
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Email (opcional)
                                </label>
                                <input
                                    id="email"
                                    v-model="volunteerForm.email"
                                    type="email"
                                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                    placeholder="tu@email.com"
                                />
                            </div>

                            <div>
                                <label for="help_type" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Tipo de ayuda *
                                </label>
                                <select
                                    id="help_type"
                                    v-model="volunteerForm.help_type"
                                    required
                                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-white"
                                >
                                    <option value="volunteering">Voluntariado</option>
                                    <option value="donation">Donaciones</option>
                                    <option value="transport">Transporte</option>
                                    <option value="other">Otro</option>
                                </select>
                            </div>

                            <div>
                                <label for="notes" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Notas adicionales (opcional)
                                </label>
                                <textarea
                                    id="notes"
                                    v-model="volunteerForm.notes"
                                    rows="4"
                                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                                    placeholder="Cuéntanos cómo puedes ayudar o cualquier información adicional..."
                                ></textarea>
                            </div>

                            <div class="flex gap-3 pt-2">
                                <button
                                    type="submit"
                                    :disabled="volunteerForm.processing"
                                    class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed shadow-sm"
                                >
                                    {{ volunteerForm.processing ? 'Enviando...' : 'Enviar Solicitud' }}
                                </button>
                                <button
                                    type="button"
                                    @click="showVolunteerForm = false; volunteerForm.reset()"
                                    class="px-6 py-3 bg-slate-100 text-slate-700 rounded-lg font-semibold hover:bg-slate-200 transition-colors"
                                >
                                    Cancelar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-slate-900 text-slate-300 mt-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                    <!-- About Section -->
                    <div>
                        <h3 class="text-white font-semibold text-lg mb-4">Sobre la Plataforma</h3>
                        <p class="text-sm text-slate-400 leading-relaxed mb-4">
                            Como Ayudo es una plataforma sin fines de lucro creada para centralizar información durante emergencias y facilitar la coordinación de ayuda humanitaria.
                        </p>
                        <div class="flex items-center space-x-3">
                            <span class="text-xs text-slate-500">Compartir:</span>
                            <button
                                @click="shareOnFacebook"
                                class="text-slate-400 hover:text-blue-400 transition-colors"
                                title="Compartir en Facebook"
                            >
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </button>
                            <button
                                @click="shareOnTwitter"
                                class="text-slate-400 hover:text-blue-400 transition-colors"
                                title="Compartir en Twitter/X"
                            >
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                            </button>
                            <button
                                @click="shareOnWhatsApp"
                                class="text-slate-400 hover:text-green-400 transition-colors"
                                title="Compartir en WhatsApp"
                            >
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                </svg>
                            </button>
                            <button
                                @click="copyToClipboard"
                                class="text-slate-400 hover:text-slate-300 transition-colors"
                                title="Copiar link"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Contact Section -->
                    <div>
                        <h3 class="text-white font-semibold text-lg mb-4">Contacto</h3>
                        <div class="space-y-2 text-sm">
                            <p class="text-slate-400">
                                Para más información sobre esta plataforma o para reportar problemas técnicos, puedes contactar al desarrollador.
                            </p>
                            <div class="pt-2">
                                <a 
                                    href="mailto:camposclaudio@live.com" 
                                    class="text-blue-400 hover:text-blue-300 transition-colors inline-flex items-center"
                                >
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    camposclaudio@live.com
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Legal Section -->
                    <div>
                        <h3 class="text-white font-semibold text-lg mb-4">Información Legal</h3>
                        <div class="space-y-2 text-sm text-slate-400">
                            <p>
                                <span class="inline-flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    Plataforma sin fines de lucro
                                </span>
                            </p>
                            <p class="pt-2">
                                Esta plataforma es de uso gratuito y está diseñada exclusivamente para facilitar la ayuda humanitaria durante emergencias.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Bottom Bar -->
                <div class="border-t border-slate-800 pt-8">
                    <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                        <div class="text-sm text-slate-400">
                            <p>&copy; {{ new Date().getFullYear() }} Centro de Ayuda. Todos los derechos reservados.</p>
                            <p class="mt-1 text-xs">Plataforma desarrollada con fines humanitarios.</p>
                        </div>
                        <div class="flex items-center space-x-6 text-sm">
                            <span class="text-slate-500">Hecho con</span>
                            <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-slate-500">para ayudar</span>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>
