<!-- Sidebar Navigation Component -->
<aside
    id="drawer-navigation"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-16 transition-all duration-200 -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    aria-label="Sidebar"
>
    <!-- Wrapper with vertical scroll for menu area -->
    <div class="h-full flex flex-col justify-between overflow-hidden">
        <!-- Scrollable Navigation Items -->
        <div class="flex-1 overflow-y-auto custom-scrollbar px-3 py-3">
            <!-- Mobile Close Button Header -->
            <div class="flex items-center justify-between pb-2 mb-2 border-b border-gray-100 dark:border-gray-700 md:hidden">
                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Menu Navigasi</span>
                <button
                    id="mobile-sidebar-close"
                    type="button"
                    class="p-1.5 text-gray-500 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700"
                    aria-label="Tutup sidebar"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Main Menu Links -->
            <ul class="space-y-1 text-sm font-medium">
                <!-- 1. Ringkasan (Dashboard) -->
                <li>
                    <a
                        href="{{ url('/') }}"
                        class="sidebar-link flex items-center p-2 rounded-lg transition {{ request()->is('/') ? 'bg-primary-50 text-primary-700 font-semibold dark:bg-primary-950/60 dark:text-primary-300' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700/60' }}"
                        title="Ringkasan"
                    >
                        <svg class="sidebar-icon w-5 h-5 shrink-0 {{ request()->is('/') ? 'text-primary-700 dark:text-primary-400' : 'text-gray-500 dark:text-gray-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25-2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25-2.25V18A2.25 2.25 0 0118 20.25h-2.25a2.25 2.25 0 01-13.5 18v-2.25z" />
                        </svg>
                        <span class="sidebar-label ml-3">Ringkasan</span>
                    </a>
                </li>

                <!-- 2. Siaga Darurat -->
                <li>
                    <a
                        href="{{ url('/darurat') }}"
                        class="sidebar-link flex items-center justify-between p-2 rounded-lg transition {{ request()->is('darurat*') ? 'bg-red-50 text-red-700 font-semibold dark:bg-red-950/60 dark:text-red-300' : 'text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/30' }}"
                        title="Siaga Darurat"
                    >
                        <div class="flex items-center">
                            <svg class="sidebar-icon w-5 h-5 shrink-0 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                            <span class="sidebar-label ml-3 font-medium">Siaga Darurat</span>
                        </div>
                        <span class="sidebar-badge px-1.5 py-0.2 text-[10px] font-semibold text-red-700 bg-red-100 rounded dark:bg-red-900/60 dark:text-red-300">
                            24/7
                        </span>
                    </a>
                </li>

                <!-- 3. Pelatihan & Bimtek (Dropdown) -->
                <li>
                    <button
                        type="button"
                        class="sidebar-link flex items-center p-2 w-full rounded-lg text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700/60 transition {{ request()->is('pelatihan*') ? 'bg-gray-100 dark:bg-gray-700/60 font-semibold text-gray-900 dark:text-white' : '' }}"
                        aria-controls="dropdown-pelatihan"
                        data-collapse-toggle="dropdown-pelatihan"
                        title="Pelatihan & Bimtek"
                    >
                        <svg class="sidebar-icon w-5 h-5 shrink-0 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342" />
                        </svg>
                        <span class="sidebar-label flex-1 ml-3 text-left">Pelatihan & Bimtek</span>
                        <svg class="sidebar-dropdown-icon w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                    <ul id="dropdown-pelatihan" class="{{ request()->is('pelatihan*') ? '' : 'hidden' }} py-1 space-y-1">
                        <li>
                            <a href="{{ url('/pelatihan') }}" class="flex items-center p-1.5 pl-10 text-xs text-gray-600 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                Jadwal Bimtek
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/pelatihan#modul') }}" class="flex items-center p-1.5 pl-10 text-xs text-gray-600 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                Modul & Video
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/pelatihan#sertifikat') }}" class="flex items-center p-1.5 pl-10 text-xs text-gray-600 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                Sertifikat Digital
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- 4. Marketplace (Dropdown) -->
                <li>
                    <button
                        type="button"
                        class="sidebar-link flex items-center p-2 w-full rounded-lg text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700/60 transition {{ request()->is('marketplace*') ? 'bg-gray-100 dark:bg-gray-700/60 font-semibold text-gray-900 dark:text-white' : '' }}"
                        aria-controls="dropdown-marketplace"
                        data-collapse-toggle="dropdown-marketplace"
                        title="Marketplace"
                    >
                        <svg class="sidebar-icon w-5 h-5 shrink-0 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        <span class="sidebar-label flex-1 ml-3 text-left">Marketplace</span>
                        <svg class="sidebar-dropdown-icon w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                    <ul id="dropdown-marketplace" class="{{ request()->is('marketplace*') ? '' : 'hidden' }} py-1 space-y-1">
                        <li>
                            <a href="{{ url('/marketplace') }}" class="flex items-center p-1.5 pl-10 text-xs text-gray-600 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                Katalog Produk
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/marketplace#toko') }}" class="flex items-center p-1.5 pl-10 text-xs text-gray-600 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                Kelola Produk
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/marketplace#pesanan') }}" class="flex items-center p-1.5 pl-10 text-xs text-gray-600 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                Riwayat Pesanan
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- 5. Harga Komoditas (Dropdown) -->
                <li>
                    <button
                        type="button"
                        class="sidebar-link flex items-center p-2 w-full rounded-lg text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700/60 transition {{ request()->is('harga-komoditas*') ? 'bg-gray-100 dark:bg-gray-700/60 font-semibold text-gray-900 dark:text-white' : '' }}"
                        aria-controls="dropdown-harga"
                        data-collapse-toggle="dropdown-harga"
                        title="Harga Komoditas"
                    >
                        <svg class="sidebar-icon w-5 h-5 shrink-0 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.25 2.25L15 9" />
                        </svg>
                        <span class="sidebar-label flex-1 ml-3 text-left">Harga Komoditas</span>
                        <svg class="sidebar-dropdown-icon w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                    <ul id="dropdown-harga" class="{{ request()->is('harga-komoditas*') ? '' : 'hidden' }} py-1 space-y-1">
                        <li>
                            <a href="{{ url('/harga-komoditas') }}" class="flex items-center p-1.5 pl-10 text-xs text-gray-600 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                Tren Harga
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/harga-komoditas#peta') }}" class="flex items-center p-1.5 pl-10 text-xs text-gray-600 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                Peta Sentra
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/harga-komoditas#unggulan') }}" class="flex items-center p-1.5 pl-10 text-xs text-gray-600 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                Komoditas Unggulan
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- 6. Kesehatan Hewan (Dropdown) -->
                <li>
                    <button
                        type="button"
                        class="sidebar-link flex items-center p-2 w-full rounded-lg text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700/60 transition {{ request()->is('konsultasi*') ? 'bg-gray-100 dark:bg-gray-700/60 font-semibold text-gray-900 dark:text-white' : '' }}"
                        aria-controls="dropdown-kesehatan"
                        data-collapse-toggle="dropdown-kesehatan"
                        title="Kesehatan Hewan"
                    >
                        <svg class="sidebar-icon w-5 h-5 shrink-0 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span class="sidebar-label flex-1 ml-3 text-left">Kesehatan Hewan</span>
                        <svg class="sidebar-dropdown-icon w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                    <ul id="dropdown-kesehatan" class="{{ request()->is('konsultasi*') ? '' : 'hidden' }} py-1 space-y-1">
                        <li>
                            <a href="{{ url('/konsultasi') }}" class="flex items-center p-1.5 pl-10 text-xs text-gray-600 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                Dokter Hewan
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/konsultasi#lapor-penyakit') }}" class="flex items-center p-1.5 pl-10 text-xs text-gray-600 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                Lapor Penyakit
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/konsultasi#rekam-medis') }}" class="flex items-center p-1.5 pl-10 text-xs text-gray-600 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                Rekam Medis (E-Tag)
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- 7. Pameran & Agenda -->
                <li>
                    <a
                        href="{{ url('/pameran') }}"
                        class="sidebar-link flex items-center p-2 rounded-lg transition {{ request()->is('pameran*') ? 'bg-primary-50 text-primary-700 font-semibold dark:bg-primary-950/60 dark:text-primary-300' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700/60' }}"
                        title="Pameran & Agenda"
                    >
                        <svg class="sidebar-icon w-5 h-5 shrink-0 {{ request()->is('pameran*') ? 'text-primary-700 dark:text-primary-400' : 'text-gray-500 dark:text-gray-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                        <span class="sidebar-label ml-3">Pameran & Agenda</span>
                    </a>
                </li>
            </ul>

            <!-- Secondary Links Section -->
            <div class="sidebar-extra pt-3 mt-3 border-t border-gray-100 dark:border-gray-700/60">
                <span class="px-2 text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1">
                    Informasi
                </span>
                <ul class="space-y-1 text-xs">
                    <li>
                        <a href="{{ url('/darurat#panduan') }}" class="flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                            <svg class="w-4 h-4 mr-2.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            Panduan Bencana
                        </a>
                    </li>
                    <li>
                        <a href="https://disnak.jatimprov.go.id" target="_blank" rel="noopener noreferrer" class="flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                            <svg class="w-4 h-4 mr-2.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                            </svg>
                            Portal Disnak Jatim
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Pinned Bottom Section (Call Center) -->
        <div class="sidebar-extra p-3 border-t border-gray-100 dark:border-gray-700/60 bg-gray-50/50 dark:bg-gray-800/50">
            <div class="p-2.5 rounded-lg bg-white dark:bg-gray-700/40 border border-gray-200 dark:border-gray-700 text-xs">
                <span class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-400 block mb-0.5">Call Center</span>
                <a href="tel:08001347625" class="font-bold text-gray-800 dark:text-gray-200 hover:text-primary-600 dark:hover:text-primary-400 block">
                    0800-1-DISNAK
                </a>
            </div>
        </div>
    </div>
</aside>
