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
    @stack('styles')
</head>
<body class="antialiased bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 font-sans selection:bg-primary-500/20 selection:text-primary-800 dark:selection:text-primary-300">
    <div class="min-h-screen">
        <!-- Top Navbar Component (Fixed Top Navbar) -->
        <x-navbar />

        <!-- Sidebar Navigation Component (Fixed Sidebar) -->
        <x-sidebar />

        <!-- Mobile Sidebar Backdrop Overlay -->
        <div id="sidebar-backdrop" class="fixed inset-0 z-30 bg-gray-900/50 backdrop-blur-xs hidden transition-opacity" data-drawer-hide="top-bar-sidebar" aria-hidden="true"></div>

        <!-- Main Content Area (Flowbite Responsive Main Content) -->
        <main id="main-content" class="p-4 sm:ml-64 mt-14 min-h-screen">
            <div class="p-2 sm:p-4">
                @if (session('success'))
                    <div id="alert-success" class="flex items-center p-4 mb-4 text-xs sm:text-sm text-emerald-800 rounded-xl bg-emerald-50 border border-emerald-200 dark:bg-emerald-950/50 dark:text-emerald-300 dark:border-emerald-800 shadow-xs" role="alert">
                        <svg class="shrink-0 inline w-4 h-4 me-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="sr-only">Sukses</span>
                        <div class="font-medium flex-1">
                            {{ session('success') }}
                        </div>
                        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-emerald-50 text-emerald-500 rounded-lg focus:ring-2 focus:ring-emerald-400 p-1.5 hover:bg-emerald-100 inline-flex items-center justify-center h-7 w-7 dark:bg-transparent dark:text-emerald-300 dark:hover:bg-emerald-900/50" onclick="this.closest('#alert-success').remove()" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div id="alert-error" class="flex items-center p-4 mb-4 text-xs sm:text-sm text-red-800 rounded-xl bg-red-50 border border-red-200 dark:bg-red-950/50 dark:text-red-300 dark:border-red-800 shadow-xs" role="alert">
                        <svg class="shrink-0 inline w-4 h-4 me-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        <span class="sr-only">Error</span>
                        <div class="font-medium flex-1">
                            {{ session('error') }}
                        </div>
                        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-100 inline-flex items-center justify-center h-7 w-7 dark:bg-transparent dark:text-red-300 dark:hover:bg-red-900/50" onclick="this.closest('#alert-error').remove()" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div id="alert-validation" class="p-4 mb-4 text-xs sm:text-sm text-red-800 rounded-xl bg-red-50 border border-red-200 dark:bg-red-950/50 dark:text-red-300 dark:border-red-800 shadow-xs" role="alert">
                        <div class="flex items-center mb-2 font-semibold">
                            <svg class="shrink-0 inline w-4 h-4 me-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                            Terdapat kesalahan pada input form:
                            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-100 inline-flex items-center justify-center h-7 w-7 dark:bg-transparent dark:text-red-300 dark:hover:bg-red-900/50" onclick="this.closest('#alert-validation').remove()" aria-label="Close">
                                <span class="sr-only">Close</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                        <ul class="list-disc list-inside space-y-1 text-xs">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <!-- Emergency Report Modal Component -->
    <x-modal-emergency />

    <!-- ApexCharts Library -->
    <script src="{{ asset('js/apexcharts.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
