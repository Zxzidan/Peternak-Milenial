<!-- Top Navbar Component (Flowbite Fixed Top Navbar) -->
<nav id="top-navbar" class="fixed top-0 z-30 left-0 sm:left-64 right-0 h-14 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 transition-all duration-300">
    <div class="px-3 sm:px-4 lg:px-6 h-full">
        <div class="flex items-center justify-between h-full">
            <!-- Left: Sidebar Triggers & Search -->
            <div class="flex items-center justify-start rtl:justify-end gap-1.5 sm:gap-2">
                <!-- Mobile Sidebar Drawer Trigger -->
                <button
                    id="mobile-sidebar-toggle"
                    data-drawer-target="top-bar-sidebar"
                    data-drawer-toggle="top-bar-sidebar"
                    aria-controls="top-bar-sidebar"
                    type="button"
                    class="sm:hidden text-gray-600 hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-gray-400 dark:hover:text-white font-medium rounded-lg text-sm p-1.5 focus:outline-none transition-colors"
                    aria-label="Buka navigasi sidebar"
                >
                    <span class="sr-only">Open sidebar</span>
                    <svg
                        class="w-5 h-5"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-width="2"
                            d="M5 7h14M5 12h14M5 17h10"
                        />
                    </svg>
                </button>

                <!-- Mobile Brand Logo (Visible only on mobile topbar when drawer is closed) -->
                <a href="{{ auth()->check() ? route('dashboard') : route('landing') }}" class="sm:hidden flex items-center ms-1 group" title="Peternak Milenial Jawa Timur">
                    <img
                        src="{{ asset('img/Peternak Milenial.png') }}"
                        alt="Peternak Milenial Logo"
                        class="h-7 w-auto object-contain dark:brightness-110 group-hover:opacity-90 transition-opacity"
                    />
                    <span class="sr-only">Peternak Milenial</span>
                </a>

                <!-- Desktop Sidebar Collapse Toggle -->
                <button
                    id="desktop-sidebar-toggle"
                    type="button"
                    class="hidden sm:inline-flex p-1.5 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:focus:ring-gray-700 transition-colors mr-1"
                    title="Buka / Tutup Sidebar"
                    aria-label="Toggle sidebar collapse"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h10.5m-10.5 5.25h16.5" />
                    </svg>
                </button>

                <!-- Topbar Search Bar (Desktop) -->
                <form action="{{ route('search') }}" method="GET" class="hidden md:block md:pl-1">
                    <div class="relative w-56 lg:w-72">
                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none text-gray-400 dark:text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </div>
                        <input
                            type="text"
                            name="query"
                            id="topbar-search"
                            class="bg-gray-50 border border-gray-200 text-gray-900 text-xs rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-9 py-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                            placeholder="Cari harga, bimtek, layanan..."
                        />
                    </div>
                </form>
            </div>

            <!-- Right: Actions & User Dropdown -->
            <div class="flex items-center gap-1.5 sm:gap-2">
                <!-- Emergency Action Button -->
                @if(auth()->check() && auth()->user()->isAdmin())
                <a
                    href="{{ route('darurat') }}"
                    class="inline-flex items-center text-red-700 bg-red-50 hover:bg-red-100 border border-red-200 font-semibold rounded-lg text-xs px-2.5 sm:px-3 py-1.5 transition"
                    title="Pantau & Verifikasi Laporan Darurat Kesmavet"
                >
                    <svg class="w-3.5 h-3.5 sm:mr-1.5 shrink-0 text-red-600" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                    <span class="hidden sm:inline">Pantau Darurat</span>
                </a>
                @elseif(auth()->check() && auth()->user()->isPeternak())
                <a
                    href="{{ route('pesanan') }}"
                    class="inline-flex items-center gap-1.5 text-xs font-semibold {{ request()->is('pesanan*') ? 'text-white bg-primary-700 shadow-xs' : 'text-primary-800 bg-primary-50 hover:bg-primary-100 border border-primary-200' }} px-3 py-1.5 rounded-lg transition shadow-2xs"
                    title="Pesanan Masuk dari Masyarakat"
                >
                    <svg class="w-3.5 h-3.5 {{ request()->is('pesanan*') ? 'text-white' : 'text-primary-700' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                    <span class="hidden sm:inline">Pesanan Masuk</span>
                </a>
                @elseif(auth()->check() && auth()->user()->isUmum())
                <a
                    href="{{ route('pesanan') }}"
                    class="inline-flex items-center gap-1.5 text-xs font-semibold {{ request()->is('pesanan*') ? 'text-white bg-orange-600 shadow-xs' : 'text-orange-700 bg-orange-50 hover:bg-orange-100 border border-orange-200' }} px-3 py-1.5 rounded-lg transition shadow-2xs"
                    title="Pantau Pesanan Saya"
                >
                    <svg class="w-3.5 h-3.5 {{ request()->is('pesanan*') ? 'text-white' : 'text-orange-600' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    <span class="hidden sm:inline">Pesanan Saya</span>
                </a>
                @elseif(!auth()->check() || !auth()->user()->isUmum())
                <button
                    type="button"
                    data-modal-target="emergency-modal"
                    data-modal-toggle="emergency-modal"
                    class="inline-flex items-center text-white bg-red-600 hover:bg-red-700 focus:ring-2 focus:ring-red-300 font-medium rounded-lg text-xs px-2.5 sm:px-3 py-1.5 transition"
                    title="Siaga Darurat Kesmavet 24/7"
                >
                    <svg class="w-3.5 h-3.5 sm:mr-1.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                    <span class="hidden sm:inline">Lapor Darurat</span>
                </button>
                @endif

                <!-- Notifications Trigger -->
                <button
                    type="button"
                    data-dropdown-toggle="notification-dropdown"
                    class="p-1.5 sm:p-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 relative transition-colors"
                    aria-label="Lihat notifikasi"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                    <div class="flex absolute top-1.5 right-1.5 w-2 h-2 bg-red-600 rounded-full"></div>
                </button>

                <!-- Notifications Dropdown Menu -->
                <div
                    class="hidden z-50 my-4 max-w-sm text-sm list-none bg-white rounded-xl divide-y divide-gray-100 shadow-lg dark:divide-gray-700 dark:bg-gray-800 border border-gray-200 dark:border-gray-700"
                    id="notification-dropdown"
                >
                    <div class="flex justify-between items-center py-2.5 px-4 bg-gray-50 dark:bg-gray-800/80">
                        <span class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Notifikasi</span>
                        <span class="text-xs text-primary-700 dark:text-primary-400 cursor-pointer hover:underline">Tandai dibaca</span>
                    </div>
                    <div class="max-h-72 overflow-y-auto divide-y divide-gray-100 dark:divide-gray-700">
                        <a href="{{ url('/darurat') }}" class="flex py-3 px-4 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <div class="w-full">
                                <div class="text-xs font-semibold text-gray-900 dark:text-white">Laporan Darurat #EM-081</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Petugas menuju kandang Pasuruan</div>
                                <div class="text-[10px] text-gray-400 mt-1">12 mnt lalu</div>
                            </div>
                        </a>
                        <a href="{{ url('/harga-komoditas') }}" class="flex py-3 px-4 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <div class="w-full">
                                <div class="text-xs font-semibold text-gray-900 dark:text-white">Harga Susu Naik</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Rp 7.450/liter di KUD Pasuruan (+Rp 250)</div>
                                <div class="text-[10px] text-gray-400 mt-1">1 jam lalu</div>
                            </div>
                        </a>
                    </div>
                    <a href="{{ url('/darurat') }}" class="block py-2 text-center text-xs font-medium text-primary-700 dark:text-primary-400 hover:bg-gray-50 dark:hover:bg-gray-700">
                        Lihat Semua
                    </a>
                </div>

                <!-- User Profile & Dropdown -->
                <div class="flex items-center ms-1 sm:ms-2">
                    @guest
                        <a
                            href="{{ route('login') }}"
                            class="mr-2 inline-flex items-center text-xs px-2.5 py-1.5 rounded-lg font-medium text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition"
                        >
                            Masuk
                        </a>
                    @endguest

                    <div>
                        <button
                            type="button"
                            class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 transition"
                            aria-expanded="false"
                            data-dropdown-toggle="dropdown-user"
                            id="user-menu-button"
                        >
                            <span class="sr-only">Open user menu</span>
                            @auth
                                <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-xs ring-2 ring-blue-400/40">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                </div>
                            @else
                                <div class="w-8 h-8 rounded-full bg-gray-700 text-gray-300 flex items-center justify-center font-bold text-xs">
                                    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>
                                </div>
                            @endauth
                        </button>
                    </div>

                    <!-- Flowbite User Dropdown -->
                    <div
                        class="z-50 hidden bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg w-48 sm:w-56"
                        id="dropdown-user"
                    >
                        @auth
                            <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                    {{ auth()->user()->name }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate mt-0.5">
                                    {{ auth()->user()->email }}
                                </p>
                                <span class="inline-block mt-1 text-[10px] font-semibold uppercase px-1.5 py-0.5 rounded bg-blue-100 text-blue-700 dark:bg-blue-900/60 dark:text-blue-300">
                                    {{ auth()->user()->role_label }}
                                </span>
                            </div>

                            <ul class="p-2 text-sm text-gray-700 dark:text-gray-300 font-medium space-y-1">
                                @if(auth()->user()->isPeternak())
                                <li>
                                    <a href="{{ route('dashboard') }}" class="inline-flex items-center w-full p-2 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white rounded-lg transition-colors">
                                        <svg class="w-4 h-4 mr-2.5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                        </svg>
                                        Profil Peternak
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/pelatihan#sertifikat') }}" class="inline-flex items-center w-full p-2 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white rounded-lg transition-colors">
                                        <svg class="w-4 h-4 mr-2.5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.746 3.746 0 013.296 1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043A3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                                        </svg>
                                        Sertifikat Digital
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/marketplace#toko') }}" class="inline-flex items-center w-full p-2 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white rounded-lg transition-colors">
                                        <svg class="w-4 h-4 mr-2.5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.25a.75.75 0 01-.75-.75V3.75a.75.75 0 01.75-.75h14.25a.75.75 0 01.75.75v16.5a.75.75 0 01-.75.75h-3.75z" />
                                        </svg>
                                        Kelola Produk Saya
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('pesanan') }}" class="inline-flex items-center w-full p-2 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white rounded-lg transition-colors">
                                        <svg class="w-4 h-4 mr-2.5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                        </svg>
                                        Pesanan Masuk (Masyarakat)
                                    </a>
                                </li>
                                @elseif(auth()->user()->isUmum())
                                <li>
                                    <a href="{{ url('/marketplace') }}" class="inline-flex items-center w-full p-2 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white rounded-lg transition-colors">
                                        <svg class="w-4 h-4 mr-2.5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                        </svg>
                                        Katalog Belanja
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('pesanan') }}" class="inline-flex items-center w-full p-2 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white rounded-lg transition-colors">
                                        <svg class="w-4 h-4 mr-2.5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Pesanan Saya
                                    </a>
                                </li>
                                @else
                                <li>
                                    <a href="{{ route('dashboard') }}" class="inline-flex items-center w-full p-2 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white rounded-lg transition-colors">
                                        <svg class="w-4 h-4 mr-2.5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25-2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                                        </svg>
                                        Panel Pengawasan Dinas
                                    </a>
                                </li>
                                @endif

                                <li>
                                    <a href="{{ route('landing') }}" class="inline-flex items-center w-full p-2 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white rounded-lg transition-colors">
                                        <svg class="w-4 h-4 mr-2.5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                        </svg>
                                        Halaman Depan Portal
                                    </a>
                                </li>

                                <li class="pt-1 border-t border-gray-100 dark:border-gray-700">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button
                                            type="submit"
                                            class="inline-flex items-center w-full p-2 hover:bg-red-50 dark:hover:bg-red-950/30 text-red-600 dark:text-red-400 rounded-lg transition-colors text-left"
                                        >
                                            <svg class="w-4 h-4 mr-2.5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                            </svg>
                                            Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        @else
                            <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                    Tamu
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate mt-0.5">
                                    Belum masuk ke akun
                                </p>
                            </div>
                            <ul class="p-2 text-sm text-gray-700 dark:text-gray-300 font-medium space-y-1">
                                <li>
                                    <a href="{{ route('login') }}" class="inline-flex items-center w-full p-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg transition-colors font-semibold">
                                        <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                        </svg>
                                        Masuk Akun
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('landing') }}" class="inline-flex items-center w-full p-2 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white rounded-lg transition-colors">
                                        <svg class="w-4 h-4 mr-2.5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                        </svg>
                                        Halaman Depan Portal
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('register') }}" class="inline-flex items-center w-full p-2 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white rounded-lg transition-colors">
                                        <svg class="w-4 h-4 mr-2.5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.765z" />
                                        </svg>
                                        Daftar Akun Baru
                                    </a>
                                </li>
                            </ul>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
