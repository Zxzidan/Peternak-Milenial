<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Peternak Milenial — Dinas Peternakan Jawa Timur')</title>
    <meta name="description" content="Platform digital terintegrasi Dinas Peternakan Provinsi Jawa Timur untuk pelatihan, pasar digital, pantauan harga, dan penanganan darurat ternak.">

    <!-- Typography: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700" rel="stylesheet" />

    <!-- Dark Mode Init Script (Prevents flash of unstyled theme) -->
    <script>
        (function() {
            var theme = localStorage.getItem('theme');
            if (theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 font-sans selection:bg-primary-500/20 selection:text-primary-800 dark:selection:text-primary-300">
    <div class="min-h-screen">
        <!-- Top Navbar Component -->
        <x-navbar />

        <!-- Sidebar Navigation Component -->
        <x-sidebar />

        <!-- Mobile Sidebar Backdrop Overlay -->
        <div id="sidebar-backdrop" class="fixed inset-0 z-30 bg-gray-900/50 backdrop-blur-xs hidden md:hidden transition-opacity duration-200" aria-hidden="true"></div>

        <!-- Main Content Area with Dynamic Desktop Margin -->
        <main id="main-content" class="px-4 sm:px-6 pt-24 pb-12 md:ml-64 min-h-screen transition-all duration-200">
            @yield('content')
        </main>
    </div>

    <!-- Emergency Report Modal Component -->
    <x-modal-emergency />
</body>
</html>
