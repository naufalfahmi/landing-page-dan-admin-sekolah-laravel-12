<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @php
            $siteTitle = \App\Models\Setting::getValue('site_title', config('app.name', 'Laravel'));
            $siteLogo = \App\Models\Setting::getValue('site_logo');
            $siteIcon = \App\Models\Setting::getValue('site_icon');
            $favicon = \App\Models\Setting::getValue('favicon');
            $metaKeywords = \App\Models\Setting::getValue('meta_keywords');
            $metaDescription = \App\Models\Setting::getValue('meta_description');
            $googleAnalytics = \App\Models\Setting::getValue('google_analytics');
            $shouldIndex = request()->routeIs('home');
        @endphp
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="{{ $shouldIndex ? 'index,follow' : 'noindex,follow' }}">
        <link rel="canonical" href="{{ url()->current() }}">

        <title>@yield('title', $siteTitle)</title>

        @if(!empty($metaDescription))
            <meta name="description" content="{{ $metaDescription }}">
        @endif
        @if(!empty($metaKeywords))
            <meta name="keywords" content="{{ $metaKeywords }}">
        @endif

        @if(!empty($favicon))
            <link rel="icon" type="image/x-icon" href="{{ $favicon }}">
            <link rel="shortcut icon" type="image/x-icon" href="{{ $favicon }}">
        @endif
        @if(!empty($siteIcon))
            <link rel="apple-touch-icon" sizes="180x180" href="{{ $siteIcon }}">
            <link rel="icon" type="image/png" sizes="32x32" href="{{ $siteIcon }}">
            <link rel="icon" type="image/png" sizes="16x16" href="{{ $siteIcon }}">
        @endif

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Bootstrap CDN as fallback -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        
        <!-- Font Awesome for icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
        
        <!-- GLightbox CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox@3.2.0/dist/css/glightbox.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- GLightbox JS -->
        <script src="https://cdn.jsdelivr.net/npm/glightbox@3.2.0/dist/js/glightbox.min.js"></script>
        
        <!-- Additional CSS for specific pages -->
        @stack('styles')
        
        <!-- Google Analytics -->
        @if(!empty($googleAnalytics))
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $googleAnalytics }}"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', '{{ $googleAnalytics }}');
        </script>
        @endif
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('components.top-bar')
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>
        @include('layouts.footer')
    </body>
</html>
