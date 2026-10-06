<!-- Top Navbar Component -->
<nav class="bg-white border-b border-gray-200 px-4 h-16 dark:bg-gray-800 dark:border-gray-700 fixed left-0 right-0 top-0 z-50 flex items-center">
    <div class="flex justify-between items-center w-full">
        <!-- Left: Toggles & Brand -->
        <div class="flex items-center gap-2">
            <!-- Mobile Sidebar Toggle -->
            <button
                id="mobile-sidebar-toggle"
                type="button"
                class="inline-flex md:hidden p-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:focus:ring-gray-700"
                aria-label="Toggle menu"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>

            <!-- Desktop Sidebar Collapse Toggle -->
            <button
                id="desktop-sidebar-toggle"
                type="button"
                class="hidden md:inline-flex p-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:focus:ring-gray-700"
                title="Sembunyikan / Tampilkan Sidebar"
                aria-label="Toggle sidebar collapse"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h10.5m-10.5 5.25h16.5" />
                </svg>
            </button>

            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 ml-1 mr-4 focus:outline-none group">
                <img
                    src="{{ asset('img/logoaplikasi2.png') }}"
                    alt="Peternak Milenial — Dinas Peternakan Provinsi Jawa Timur"
                    class="h-9 sm:h-10 w-auto object-contain dark:brightness-110 group-hover:opacity-95 transition-opacity"
                />
            </a>

            <!-- Topbar Search -->
            <form action="#" method="GET" class="hidden md:block md:pl-2">
                <div class="relative w-64 lg:w-80">
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

        <!-- Right: Actions -->
        <div class="flex items-center gap-1 sm:gap-2">
            <!-- Emergency Action Button -->
            <button
                type="button"
                data-modal-target="emergency-modal"
                data-modal-toggle="emergency-modal"
                class="inline-flex items-center text-white bg-red-600 hover:bg-red-700 focus:ring-2 focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-red-600 dark:hover:bg-red-700 transition"
            >
                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
                Lapor Darurat
            </button>

            <!-- Theme Switcher -->
            <button
                id="theme-toggle"
                type="button"
                class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none rounded-lg text-sm p-2"
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
                class="p-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 relative"
                aria-label="Lihat notifikasi"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
                <div class="flex absolute top-2 right-2 w-2 h-2 bg-red-600 rounded-full"></div>
            </button>

            <!-- Notifications Menu -->
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

            <!-- Apps Quick Links -->
            <button
                type="button"
                data-dropdown-toggle="apps-dropdown"
                class="p-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700"
                aria-label="Menu Layanan"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                </svg>
            </button>

            <!-- Apps Dropdown -->
            <div
                class="hidden z-50 my-4 max-w-xs text-sm list-none bg-white rounded-xl shadow-lg dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-2"
                id="apps-dropdown"
            >
                <div class="grid grid-cols-3 gap-1">
                    <a href="{{ url('/pelatihan') }}" class="p-2 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <div class="text-xs font-medium text-gray-800 dark:text-gray-200">Pelatihan</div>
                    </a>
                    <a href="{{ url('/marketplace') }}" class="p-2 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <div class="text-xs font-medium text-gray-800 dark:text-gray-200">Marketplace</div>
                    </a>
                    <a href="{{ url('/harga-komoditas') }}" class="p-2 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <div class="text-xs font-medium text-gray-800 dark:text-gray-200">Harga</div>
                    </a>
                    <a href="{{ url('/darurat') }}" class="p-2 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <div class="text-xs font-medium text-gray-800 dark:text-gray-200">Darurat</div>
                    </a>
                    <a href="{{ url('/konsultasi') }}" class="p-2 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <div class="text-xs font-medium text-gray-800 dark:text-gray-200">Konsultasi</div>
                    </a>
                    <a href="{{ url('/pameran') }}" class="p-2 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <div class="text-xs font-medium text-gray-800 dark:text-gray-200">Pameran</div>
                    </a>
                </div>
            </div>

            <!-- Profile Avatar -->
            <button
                type="button"
                class="flex text-sm rounded-full focus:ring-2 focus:ring-primary-500"
                id="user-menu-button"
                data-dropdown-toggle="dropdown"
                aria-label="Menu akun"
            >
                <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold flex items-center justify-center text-xs">
                    SR
                </div>
            </button>

            <!-- Profile Dropdown -->
            <div
                class="hidden z-50 my-4 w-56 text-sm list-none bg-white rounded-xl divide-y divide-gray-100 shadow-lg dark:bg-gray-800 dark:divide-gray-700 border border-gray-200 dark:border-gray-700"
                id="dropdown"
            >
                <div class="py-2.5 px-4">
                    <span class="block text-xs font-bold text-gray-900 dark:text-white">Slamet Rahardjo</span>
                    <span class="block text-[11px] text-gray-500 dark:text-gray-400">Peternak Sapi · Pasuruan</span>
                </div>
                <ul class="py-1 text-xs text-gray-700 dark:text-gray-300">
                    <li><a href="#" class="block py-1.5 px-4 hover:bg-gray-100 dark:hover:bg-gray-700">Profil Usaha</a></li>
                    <li><a href="{{ url('/pelatihan#sertifikat') }}" class="block py-1.5 px-4 hover:bg-gray-100 dark:hover:bg-gray-700">Sertifikat</a></li>
                </ul>
                <div class="py-1">
                    <a href="#" class="block py-1.5 px-4 text-xs text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700">Keluar</a>
                </div>
            </div>
        </div>
    </div>
</nav>
