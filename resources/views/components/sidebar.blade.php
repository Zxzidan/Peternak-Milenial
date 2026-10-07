<!-- Sidebar Navigation Component (Flowbite Fixed Sidebar with Integrated Brand Header) -->
<aside
    id="top-bar-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen transition-all duration-300 -translate-x-full sm:translate-x-0 bg-white border-e border-gray-200 dark:bg-gray-800 dark:border-gray-700 flex flex-col"
    aria-label="Sidebar"
>
    <!-- Brand Header inside Sidebar (Logo & Mobile Dismiss) -->
    <div class="sidebar-brand-container h-14 flex items-center justify-between px-3.5 sm:px-4 border-b border-gray-200 dark:border-gray-700 shrink-0 bg-white dark:bg-gray-800">
        <a href="{{ auth()->check() ? route('dashboard') : route('landing') }}" class="flex items-center gap-2 group overflow-hidden" title="Peternak Milenial Jawa Timur">
            <img
                src="{{ asset('img/logoaplikasi2.png') }}"
                alt="Peternak Milenial Logo"
                class="h-8 w-auto max-w-[170px] object-contain sidebar-brand-full group-hover:opacity-90 transition-opacity"
            />
            <img
                src="{{ asset('img/logoaplikasi2.png') }}"
                alt="Peternak Milenial"
                class="h-7.5 w-7.5 object-cover object-left hidden sidebar-brand-collapsed rounded"
            />
            <span class="sr-only">Peternak Milenial</span>
        </a>

        <!-- Mobile Drawer Close Button (Visible only on mobile) -->
        <button
            type="button"
            data-drawer-hide="top-bar-sidebar"
            aria-controls="top-bar-sidebar"
            class="sm:hidden text-gray-400 hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white rounded-lg p-1.5 inline-flex items-center transition-colors"
            aria-label="Tutup navigasi"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Scrollable Sidebar Content Area -->
    <div class="flex-1 px-3 py-3 overflow-y-auto bg-white dark:bg-gray-800 custom-scrollbar flex flex-col justify-between">
        <div class="space-y-3.5">
            <!-- Navigation Menu Items -->
            @if(auth()->check() && auth()->user()->isUmum())
            <!-- Menu Khusus Masyarakat: Fokus Marketplace & Pesanan (Shopee-Style) -->
            <ul class="space-y-1 font-medium">
                <li>
                    <a
                        href="{{ route('marketplace') }}"
                        class="sidebar-link flex items-center justify-between px-2.5 py-2 rounded-lg text-[13px] font-medium border transition-all group {{ request()->is('marketplace*') && !request()->has('pesanan') ? 'bg-orange-50 text-orange-800 border-orange-200/90 font-semibold shadow-2xs' : 'border-transparent text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}"
                        title="Marketplace Ternak"
                    >
                        <div class="flex items-center min-w-0">
                            <svg class="sidebar-icon shrink-0 w-4.5 h-4.5 {{ request()->is('marketplace*') && !request()->has('pesanan') ? 'text-orange-600' : 'text-gray-400 group-hover:text-orange-600' }}" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>
                            <span class="sidebar-label flex-1 ms-2.5 whitespace-nowrap">
                                Marketplace Ternak
                            </span>
                        </div>
                        <span class="sidebar-badge px-1.5 py-0.5 text-[10px] font-bold text-orange-700 bg-orange-100/90 rounded-md leading-none shrink-0">
                            Belanja
                        </span>
                    </a>
                </li>

                <li>
                    <a
                        href="{{ route('pesanan') }}"
                        class="sidebar-link flex items-center justify-between px-2.5 py-2 rounded-lg text-[13px] font-medium border transition-all group {{ request()->is('pesanan*') ? 'bg-orange-50 text-orange-800 border-orange-200/90 font-semibold shadow-2xs' : 'border-transparent text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}"
                        title="Pesanan Saya"
                    >
                        <div class="flex items-center min-w-0">
                            <svg class="sidebar-icon shrink-0 w-4.5 h-4.5 {{ request()->is('pesanan*') ? 'text-orange-600' : 'text-gray-400 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                            </svg>
                            <span class="sidebar-label flex-1 ms-2.5 whitespace-nowrap">
                                Pesanan Saya
                            </span>
                        </div>
                        <span class="sidebar-badge px-1.5 py-0.5 text-[10px] font-bold {{ request()->is('pesanan*') ? 'text-orange-700 bg-orange-100/90' : 'text-blue-700 bg-blue-100/90' }} rounded-md leading-none shrink-0">
                            Lacak
                        </span>
                    </a>
                </li>

                <li>
                    <a
                        href="{{ url('/harga-komoditas') }}"
                        class="sidebar-link flex items-center px-2.5 py-2 rounded-lg text-[13px] font-medium border transition-all group {{ request()->is('harga-komoditas*') ? 'bg-primary-50 text-primary-800 border-primary-200/80 font-semibold shadow-2xs' : 'border-transparent text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}"
                        title="Pantau Harga Pasar"
                    >
                        <svg class="sidebar-icon shrink-0 w-4.5 h-4.5 {{ request()->is('harga-komoditas*') ? 'text-primary-700' : 'text-gray-400 group-hover:text-primary-700' }}" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.25 2.25L15 9" />
                        </svg>
                        <span class="sidebar-label flex-1 ms-2.5 whitespace-nowrap">
                            Harga Pasar Harian
                        </span>
                    </a>
                </li>

                <li>
                    <a
                        href="{{ url('/pameran') }}"
                        class="sidebar-link flex items-center px-2.5 py-2 rounded-lg text-[13px] font-medium border transition-all group {{ request()->is('pameran*') ? 'bg-primary-50 text-primary-800 border-primary-200/80 font-semibold shadow-2xs' : 'border-transparent text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}"
                        title="Pameran & Agenda"
                    >
                        <svg class="sidebar-icon shrink-0 w-4.5 h-4.5 {{ request()->is('pameran*') ? 'text-primary-700' : 'text-gray-400 group-hover:text-primary-700' }}" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                        <span class="sidebar-label flex-1 ms-2.5 whitespace-nowrap">
                            Pameran Ternak Jatim
                        </span>
                    </a>
                </li>
            </ul>
            @else
            <ul class="space-y-1 font-medium">
                <!-- 1. Dashboard -->
                <li>
                    <a
                        href="{{ route('dashboard') }}"
                        class="sidebar-link flex items-center px-2.5 py-2 rounded-lg text-[13px] font-medium border transition-all group {{ request()->is('dashboard*') ? 'bg-primary-50 text-primary-700 border-primary-200/80 font-semibold dark:bg-primary-950/60 dark:text-primary-300 dark:border-primary-800/60 shadow-2xs' : 'border-transparent text-gray-700 dark:text-gray-300 hover:bg-gray-100 hover:text-primary-700 dark:hover:bg-gray-700/60 dark:hover:text-white' }}"
                        title="Dashboard"
                    >
                        <svg class="sidebar-icon shrink-0 w-4.5 h-4.5 {{ request()->is('dashboard*') ? 'text-primary-700 dark:text-primary-400' : 'text-gray-500 dark:text-gray-400 group-hover:text-primary-700 dark:group-hover:text-white' }}" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25-2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                        </svg>
                        <span class="sidebar-label flex-1 ms-2.5 whitespace-nowrap">
                            Dashboard
                        </span>
                    </a>
                </li>

                <!-- 2. Siaga Darurat (Hanya Admin & Peternak) -->
                @if(!auth()->check() || auth()->user()->hasRole('admin', 'peternak'))
                <li>
                    <a
                        href="{{ url('/darurat') }}"
                        class="sidebar-link flex items-center justify-between px-2.5 py-2 rounded-lg text-[13px] font-medium border transition-all group {{ request()->is('darurat*') ? 'bg-red-50 text-red-700 border-red-200/80 font-semibold dark:bg-red-950/60 dark:text-red-300 dark:border-red-800/60 shadow-2xs' : 'border-transparent text-red-600 hover:bg-red-50 hover:text-red-700 dark:text-red-400 dark:hover:bg-red-950/30' }}"
                        title="Siaga Darurat"
                    >
                        <div class="flex items-center min-w-0">
                            <svg class="sidebar-icon shrink-0 w-4.5 h-4.5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                            <span class="sidebar-label flex-1 ms-2.5 whitespace-nowrap">
                                Siaga Darurat
                            </span>
                        </div>
                        <span class="sidebar-badge px-1.5 py-0.5 text-[10px] font-bold text-red-700 bg-red-100 rounded-md dark:bg-red-900/60 dark:text-red-300 leading-none shrink-0">
                            24/7
                        </span>
                    </a>
                </li>
                @endif

                <!-- 3. Pelatihan & Bimtek (Dropdown Collapse - Hanya Admin & Peternak) -->
                @if(!auth()->check() || auth()->user()->hasRole('admin', 'peternak'))
                <li>
                    <button
                        type="button"
                        class="sidebar-link flex items-center w-full px-2.5 py-2 rounded-lg text-[13px] font-medium border transition-all group {{ request()->is('pelatihan*') ? 'bg-gray-100 border-gray-200/80 font-semibold text-gray-900 dark:bg-gray-700/60 dark:text-white dark:border-gray-600' : 'border-transparent text-gray-700 hover:bg-gray-100 hover:text-primary-700 dark:text-gray-300 dark:hover:bg-gray-700/60 dark:hover:text-white' }}"
                        aria-controls="dropdown-pelatihan"
                        data-collapse-toggle="dropdown-pelatihan"
                        title="Pelatihan & Bimtek"
                    >
                        <svg class="sidebar-icon shrink-0 w-4.5 h-4.5 text-gray-500 dark:text-gray-400 group-hover:text-primary-700 dark:group-hover:text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342" />
                        </svg>
                        <span class="sidebar-label flex-1 ms-2.5 text-left whitespace-nowrap">
                            Pelatihan & Bimtek
                        </span>
                        <svg class="sidebar-dropdown-icon w-3.5 h-3.5 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                    <ul id="dropdown-pelatihan" class="{{ request()->is('pelatihan*') ? '' : 'hidden' }} py-1 space-y-0.5">
                        <li>
                            <a href="{{ url('/pelatihan') }}" class="flex items-center w-full py-1.5 pl-8 pr-2.5 text-xs text-gray-600 dark:text-gray-400 hover:text-primary-700 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700/60 rounded-lg transition-colors {{ request()->fullUrlIs(url('/pelatihan')) ? 'text-primary-700 font-medium' : '' }}">
                                Jadwal Bimtek
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/pelatihan#modul') }}" class="flex items-center w-full py-1.5 pl-8 pr-2.5 text-xs text-gray-600 dark:text-gray-400 hover:text-primary-700 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700/60 rounded-lg transition-colors">
                                Modul & Video
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/pelatihan#sertifikat') }}" class="flex items-center w-full py-1.5 pl-8 pr-2.5 text-xs text-gray-600 dark:text-gray-400 hover:text-primary-700 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700/60 rounded-lg transition-colors">
                                Sertifikat Digital
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                <!-- 4. Marketplace (Dropdown Collapse) -->
                <li>
                    <button
                        type="button"
                        class="sidebar-link flex items-center w-full px-2.5 py-2 rounded-lg text-[13px] font-medium border transition-all group {{ request()->is('marketplace*') ? 'bg-gray-100 border-gray-200/80 font-semibold text-gray-900 dark:bg-gray-700/60 dark:text-white dark:border-gray-600' : 'border-transparent text-gray-700 hover:bg-gray-100 hover:text-primary-700 dark:text-gray-300 dark:hover:bg-gray-700/60 dark:hover:text-white' }}"
                        aria-controls="dropdown-marketplace"
                        data-collapse-toggle="dropdown-marketplace"
                        title="Marketplace"
                    >
                        <svg class="sidebar-icon shrink-0 w-4.5 h-4.5 text-gray-500 dark:text-gray-400 group-hover:text-primary-700 dark:group-hover:text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        <span class="sidebar-label flex-1 ms-2.5 text-left whitespace-nowrap">
                            Marketplace
                        </span>
                        <svg class="sidebar-dropdown-icon w-3.5 h-3.5 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                    <ul id="dropdown-marketplace" class="{{ request()->is('marketplace*') ? '' : 'hidden' }} py-1 space-y-0.5">
                        <li>
                            <a href="{{ url('/marketplace') }}" class="flex items-center w-full py-1.5 pl-8 pr-2.5 text-xs text-gray-600 dark:text-gray-400 hover:text-primary-700 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700/60 rounded-lg transition-colors">
                                Katalog Produk
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/marketplace#toko') }}" class="flex items-center w-full py-1.5 pl-8 pr-2.5 text-xs text-gray-600 dark:text-gray-400 hover:text-primary-700 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700/60 rounded-lg transition-colors">
                                Kelola Produk
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pesanan') }}" class="flex items-center w-full py-1.5 pl-8 pr-2.5 text-xs {{ request()->is('pesanan*') ? 'text-orange-600 font-semibold' : 'text-gray-600 dark:text-gray-400 hover:text-primary-700 dark:hover:text-white' }} hover:bg-gray-100 dark:hover:bg-gray-700/60 rounded-lg transition-colors">
                                {{ auth()->check() && auth()->user()->isAdmin() ? 'Semua Pesanan' : 'Riwayat Pesanan' }}
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- 5. Harga Komoditas (Dropdown Collapse) -->
                <li>
                    <button
                        type="button"
                        class="sidebar-link flex items-center w-full px-2.5 py-2 rounded-lg text-[13px] font-medium border transition-all group {{ request()->is('harga-komoditas*') ? 'bg-gray-100 border-gray-200/80 font-semibold text-gray-900 dark:bg-gray-700/60 dark:text-white dark:border-gray-600' : 'border-transparent text-gray-700 hover:bg-gray-100 hover:text-primary-700 dark:text-gray-300 dark:hover:bg-gray-700/60 dark:hover:text-white' }}"
                        aria-controls="dropdown-harga"
                        data-collapse-toggle="dropdown-harga"
                        title="Harga Komoditas"
                    >
                        <svg class="sidebar-icon shrink-0 w-4.5 h-4.5 text-gray-500 dark:text-gray-400 group-hover:text-primary-700 dark:group-hover:text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.25 2.25L15 9" />
                        </svg>
                        <span class="sidebar-label flex-1 ms-2.5 text-left whitespace-nowrap">
                            Harga Komoditas
                        </span>
                        <svg class="sidebar-dropdown-icon w-3.5 h-3.5 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                    <ul id="dropdown-harga" class="{{ request()->is('harga-komoditas*') ? '' : 'hidden' }} py-1 space-y-0.5">
                        <li>
                            <a href="{{ url('/harga-komoditas') }}" class="flex items-center w-full py-1.5 pl-8 pr-2.5 text-xs text-gray-600 dark:text-gray-400 hover:text-primary-700 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700/60 rounded-lg transition-colors">
                                Tren Harga
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/harga-komoditas#peta') }}" class="flex items-center w-full py-1.5 pl-8 pr-2.5 text-xs text-gray-600 dark:text-gray-400 hover:text-primary-700 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700/60 rounded-lg transition-colors">
                                Peta Sentra
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/harga-komoditas#unggulan') }}" class="flex items-center w-full py-1.5 pl-8 pr-2.5 text-xs text-gray-600 dark:text-gray-400 hover:text-primary-700 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700/60 rounded-lg transition-colors">
                                Komoditas Unggulan
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- 6. Kesehatan Hewan (Dropdown Collapse - Hanya Admin & Peternak) -->
                @if(!auth()->check() || auth()->user()->hasRole('admin', 'peternak'))
                <li>
                    <button
                        type="button"
                        class="sidebar-link flex items-center w-full px-2.5 py-2 rounded-lg text-[13px] font-medium border transition-all group {{ request()->is('konsultasi*') ? 'bg-gray-100 border-gray-200/80 font-semibold text-gray-900 dark:bg-gray-700/60 dark:text-white dark:border-gray-600' : 'border-transparent text-gray-700 hover:bg-gray-100 hover:text-primary-700 dark:text-gray-300 dark:hover:bg-gray-700/60 dark:hover:text-white' }}"
                        aria-controls="dropdown-kesehatan"
                        data-collapse-toggle="dropdown-kesehatan"
                        title="Kesehatan Hewan"
                    >
                        <svg class="sidebar-icon shrink-0 w-4.5 h-4.5 text-gray-500 dark:text-gray-400 group-hover:text-primary-700 dark:group-hover:text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span class="sidebar-label flex-1 ms-2.5 text-left whitespace-nowrap">
                            Kesehatan Hewan
                        </span>
                        <svg class="sidebar-dropdown-icon w-3.5 h-3.5 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                    <ul id="dropdown-kesehatan" class="{{ request()->is('konsultasi*') ? '' : 'hidden' }} py-1 space-y-0.5">
                        <li>
                            <a href="{{ url('/konsultasi') }}" class="flex items-center w-full py-1.5 pl-8 pr-2.5 text-xs text-gray-600 dark:text-gray-400 hover:text-primary-700 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700/60 rounded-lg transition-colors">
                                Dokter Hewan
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/konsultasi#lapor-penyakit') }}" class="flex items-center w-full py-1.5 pl-8 pr-2.5 text-xs text-gray-600 dark:text-gray-400 hover:text-primary-700 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700/60 rounded-lg transition-colors">
                                Lapor Penyakit
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/konsultasi#rekam-medis') }}" class="flex items-center w-full py-1.5 pl-8 pr-2.5 text-xs text-gray-600 dark:text-gray-400 hover:text-primary-700 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700/60 rounded-lg transition-colors">
                                Rekam Medis (E-Tag)
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                <!-- 7. Pameran & Agenda -->
                <li>
                    <a
                        href="{{ url('/pameran') }}"
                        class="sidebar-link flex items-center px-2.5 py-2 rounded-lg text-[13px] font-medium border transition-all group {{ request()->is('pameran*') ? 'bg-primary-50 text-primary-700 border-primary-200/80 font-semibold dark:bg-primary-950/60 dark:text-primary-300 dark:border-primary-800/60 shadow-2xs' : 'border-transparent text-gray-700 dark:text-gray-300 hover:bg-gray-100 hover:text-primary-700 dark:hover:bg-gray-700/60 dark:hover:text-white' }}"
                        title="Pameran & Agenda"
                    >
                        <svg class="sidebar-icon shrink-0 w-4.5 h-4.5 {{ request()->is('pameran*') ? 'text-primary-700 dark:text-primary-400' : 'text-gray-500 dark:text-gray-400 group-hover:text-primary-700 dark:group-hover:text-white' }}" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                        <span class="sidebar-label flex-1 ms-2.5 whitespace-nowrap">
                            Pameran & Agenda
                        </span>
                    </a>
                </li>
            </ul>
            @endif

            <!-- Secondary Links Section -->
            <div class="sidebar-extra pt-2.5 mt-2.5 border-t border-gray-100 dark:border-gray-700/60">
                <span class="sidebar-section-title px-2.5 text-[10px] font-bold text-gray-400 dark:text-gray-400 uppercase tracking-wider block mb-1">
                    Informasi & Layanan
                </span>
                <ul class="space-y-0.5 text-xs font-medium">
                    <li>
                        <a href="{{ url('/darurat#panduan') }}" class="sidebar-link flex items-center px-2.5 py-1.5 text-gray-600 dark:text-gray-400 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white transition-colors" title="Panduan Bencana">
                            <svg class="sidebar-icon w-3.5 h-3.5 mr-2 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            <span class="sidebar-label">Panduan Bencana</span>
                        </a>
                    </li>
                    <li>
                        <a href="https://disnak.jatimprov.go.id" target="_blank" rel="noopener noreferrer" class="sidebar-link flex items-center px-2.5 py-1.5 text-gray-600 dark:text-gray-400 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white transition-colors" title="Portal Disnak Jatim">
                            <svg class="sidebar-icon w-3.5 h-3.5 mr-2 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                            </svg>
                            <span class="sidebar-label">Portal Disnak Jatim</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Call Center Siaga (Compact, Proportionate & Cohesive) -->
        <div class="sidebar-call-center pt-2.5 mt-2.5 border-t border-gray-100 dark:border-gray-700/60">
            <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-gray-700/40 border border-slate-200/80 dark:border-gray-700">
                <div class="flex items-center gap-1.5 mb-0.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-gray-400">
                        Call Center Siaga 24/7
                    </span>
                </div>
                <a href="tel:08001347625" class="font-bold text-slate-900 dark:text-gray-200 hover:text-primary-700 dark:hover:text-primary-400 block transition-colors text-xs tracking-tight pl-3">
                    0800-1-DISNAK
                </a>
            </div>
        </div>
    </div>
</aside>
