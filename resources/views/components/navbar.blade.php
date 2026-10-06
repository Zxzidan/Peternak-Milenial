<!-- Top Navbar Component (Flowbite Fixed Top Navbar) -->
<nav class="fixed top-0 z-50 w-full bg-neutral-primary-soft bg-white border-b border-default border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <!-- Left: Sidebar Triggers & Brand Logo -->
            <div class="flex items-center justify-start rtl:justify-end">
                <!-- Mobile Sidebar Drawer Trigger -->
                <button
                    id="mobile-sidebar-toggle"
                    data-drawer-target="top-bar-sidebar"
                    data-drawer-toggle="top-bar-sidebar"
                    aria-controls="top-bar-sidebar"
                    type="button"
                    class="sm:hidden text-heading bg-transparent box-border border border-transparent hover:bg-neutral-secondary-medium hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-gray-400 dark:hover:text-white focus:ring-4 focus:ring-neutral-tertiary focus:ring-gray-200 dark:focus:ring-gray-700 font-medium leading-5 rounded-base rounded-lg text-sm p-2 focus:outline-none transition-colors"
                >
                    <span class="sr-only">Open sidebar</span>
                    <svg
                        class="w-6 h-6"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
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

                <!-- Desktop Sidebar Collapse Toggle -->
                <button
                    id="desktop-sidebar-toggle"
                    type="button"
                    class="hidden sm:inline-flex p-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:focus:ring-gray-700 transition-colors mr-1"
                    title="Buka / Tutup Sidebar"
                    aria-label="Toggle sidebar collapse"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h10.5m-10.5 5.25h16.5" />
                    </svg>
                </button>

                <!-- Brand Logo (Image contains official styled text) -->
                <a href="{{ url('/') }}" class="flex ms-1 sm:ms-2 md:me-16 items-center group" title="Peternak Milenial Jawa Timur">
                    <img
                        src="{{ asset('img/logoaplikasi2.png') }}"
                        alt="Peternak Milenial Logo"
                        class="h-8 sm:h-9 w-auto object-contain dark:brightness-110 group-hover:opacity-90 transition-opacity"
                    />
                    <span class="sr-only">Peternak Milenial</span>
                </a>

                <!-- Topbar Search Bar (Desktop) -->
                <form action="#" method="GET" class="hidden md:block md:pl-2">
                    <div class="relative w-60 lg:w-72">
                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none text-gray-400 dark:text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </div>
                        <input
                            type="text"
                            name="query"
                            id="topbar-search"
                            class="bg-gray-50 border border-gray-200 text-gray-900 text-xs rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-9 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                            placeholder="Cari harga, bimtek, layanan..."
                        />
                    </div>
                </form>
            </div>

            <!-- Right: Actions & User Dropdown -->
            <div class="flex items-center gap-1 sm:gap-2">
                <!-- Emergency Action Button -->
                <button
                    type="button"
                    data-modal-target="emergency-modal"
                    data-modal-toggle="emergency-modal"
                    class="inline-flex items-center text-white bg-red-600 hover:bg-red-700 focus:ring-2 focus:ring-red-300 font-medium rounded-lg text-xs px-2.5 sm:px-3 py-1.5 dark:bg-red-600 dark:hover:bg-red-700 transition"
                    title="Siaga Darurat Kesmavet 24/7"
                >
                    <svg class="w-3.5 h-3.5 sm:mr-1.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                    <span class="hidden sm:inline">Lapor Darurat</span>
                </button>

                <!-- Theme Switcher -->
                <button
                    id="theme-toggle"
                    type="button"
                    class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none rounded-lg text-sm p-2 transition-colors"
                    title="Ganti mode terang / gelap"
                    aria-label="Toggle theme"
                >
                    <svg id="theme-toggle-dark-icon" class="hidden w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                    </svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                    </svg>
                </button>

                <!-- Notifications Trigger -->
                <button
                    type="button"
                    data-dropdown-toggle="notification-dropdown"
                    class="p-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 relative transition-colors"
                    aria-label="Lihat notifikasi"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                    <div class="flex absolute top-2 right-2 w-2 h-2 bg-red-600 rounded-full"></div>
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
                <div class="flex items-center ms-2 sm:ms-3">
                    <div>
                        <button
                            type="button"
                            class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 transition"
                            aria-expanded="false"
                            data-dropdown-toggle="dropdown-user"
                            id="user-menu-button"
                        >
                            <span class="sr-only">Open user menu</span>
                            <img
                                class="w-8 h-8 rounded-full object-cover"
                                src="{{ asset('img/avatar-slamet.svg') }}"
                                alt="Foto Profil {{ auth()->user()->name ?? 'Slamet Rahardjo' }}"
                            />
                        </button>
                    </div>

                    <!-- Flowbite User Dropdown -->
                    <div
                        class="z-50 hidden bg-neutral-primary-medium bg-white dark:bg-gray-800 border border-default-medium border-gray-200 dark:border-gray-700 rounded-base rounded-xl shadow-lg w-48 sm:w-56"
                        id="dropdown-user"
                    >
                        <div class="px-4 py-3 border-b border-default-medium border-gray-200 dark:border-gray-700">
                            <p class="text-sm font-semibold text-heading dark:text-white truncate">
                                {{ auth()->user()->name ?? 'Slamet Rahardjo' }}
                            </p>
                            <p class="text-xs text-body dark:text-gray-400 truncate mt-0.5">
                                {{ auth()->user()->email ?? 'slamet@peternak.id' }}
                            </p>
                        </div>

                        <ul class="p-2 text-sm text-body dark:text-gray-300 font-medium space-y-1">
                            <li>
                                <a href="{{ url('/') }}" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-heading dark:hover:text-white rounded-lg transition-colors">
                                    <svg class="w-4 h-4 mr-2.5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>
                                    Profil Usaha
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('/pelatihan#sertifikat') }}" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-heading dark:hover:text-white rounded-lg transition-colors">
                                    <svg class="w-4 h-4 mr-2.5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                                    </svg>
                                    Sertifikat Digital
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('/marketplace#toko') }}" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-heading dark:hover:text-white rounded-lg transition-colors">
                                    <svg class="w-4 h-4 mr-2.5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.25a.75.75 0 01-.75-.75V3.75a.75.75 0 01.75-.75h14.25a.75.75 0 01.75.75v16.5a.75.75 0 01-.75.75h-3.75z" />
                                    </svg>
                                    Kelola Produk
                                </a>
                            </li>

                            <li class="pt-1 border-t border-gray-100 dark:border-gray-700">
                                <a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:bg-red-50 dark:hover:bg-red-950/30 text-red-600 dark:text-red-400 rounded-lg transition-colors">
                                    <svg class="w-4 h-4 mr-2.5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                    </svg>
                                    Keluar
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
