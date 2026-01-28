<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Centro de Ayuda') }}</title>

        <!-- SEO Meta Tags -->
        <meta name="description" content="Centro de Ayuda - Plataforma sin fines de lucro para centralizar información durante emergencias y facilitar la coordinación de ayuda humanitaria. Información sobre zonas afectadas, donaciones, puntos de recepción y cómo ayudar.">
        <meta name="keywords" content="ayuda humanitaria, emergencias, donaciones, voluntariado, zonas afectadas, centro de ayuda, información emergencia">
        <meta name="author" content="Centro de Ayuda">
        <meta name="robots" content="index, follow">
        <meta name="language" content="Spanish">
        <meta name="revisit-after" content="7 days">
        
        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ config('app.url') }}">
        <meta property="og:title" content="{{ config('app.name', 'Centro de Ayuda') }}">
        <meta property="og:description" content="Plataforma sin fines de lucro para centralizar información durante emergencias y facilitar la coordinación de ayuda humanitaria.">
        <meta property="og:site_name" content="{{ config('app.name', 'Centro de Ayuda') }}">
        <meta property="og:locale" content="es_ES">
        
        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:url" content="{{ config('app.url') }}">
        <meta name="twitter:title" content="{{ config('app.name', 'Centro de Ayuda') }}">
        <meta name="twitter:description" content="Plataforma sin fines de lucro para centralizar información durante emergencias y facilitar la coordinación de ayuda humanitaria.">
        
        <!-- Canonical URL -->
        <link rel="canonical" href="{{ config('app.url') }}">

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <link rel="alternate icon" href="{{ asset('favicon.ico') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
