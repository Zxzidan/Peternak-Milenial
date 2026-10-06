<?php

test('dashboard page renders successfully', function () {
    $response = $this->get(route('dashboard'));

    $response->assertStatus(200);
    $response->assertSee('Peternak');
    $response->assertSee('Dinas Peternakan Provinsi Jawa Timur');
});

test('pelatihan page renders successfully', function () {
    $response = $this->get(route('pelatihan'));

    $response->assertStatus(200);
    $response->assertSee('Pelatihan', false);
    $response->assertSee('Bimbingan Teknis', false);
});

test('marketplace page renders successfully', function () {
    $response = $this->get(route('marketplace'));

    $response->assertStatus(200);
    $response->assertSee('Marketplace Peternak Milenial');
});

test('harga komoditas page renders successfully', function () {
    $response = $this->get(route('harga-komoditas'));

    $response->assertStatus(200);
    $response->assertSee('Harga Komoditas', false);
    $response->assertSee('Sentra Produksi', false);
});

test('layanan darurat page renders successfully', function () {
    $response = $this->get(route('darurat'));

    $response->assertStatus(200);
    $response->assertSee('Pelaporan Darurat', false);
    $response->assertSee('Kesejahteraan Hewan', false);
});

test('konsultasi dokter page renders successfully', function () {
    $response = $this->get(route('konsultasi'));

    $response->assertStatus(200);
    $response->assertSee('Konsultasi', false);
    $response->assertSee('Kesehatan Hewan', false);
});

test('pameran page renders successfully', function () {
    $response = $this->get(route('pameran'));

    $response->assertStatus(200);
    $response->assertSee('Pameran', false);
    $response->assertSee('Kalender Terpadu', false);
});

test('flowbite dashboard includes plus jakarta sans and layout controls', function () {
    $response = $this->get(route('dashboard'));

    $response->assertStatus(200);
    $response->assertSee('Plus Jakarta Sans');
    $response->assertSee('id="theme-toggle"', false);
    $response->assertSee('data-drawer-target="top-bar-sidebar"', false);
    $response->assertSee('data-drawer-toggle="top-bar-sidebar"', false);
    $response->assertSee('id="top-bar-sidebar"', false);
    $response->assertSee('id="main-content"', false);
    $response->assertSee('sm:ml-64');
    $response->assertSee('mt-14');
    $response->assertSee('id="dropdown-user"', false);
    $response->assertSee('id="sidebar-backdrop"', false);
    $response->assertSee('id="emergency-modal"', false);
});

test('dashboard has collapsible sidebar controls, kpi cards, charts, and interactive table', function () {
    $response = $this->get(route('dashboard'));

    $response->assertStatus(200);
    $response->assertSee('Dashboard');
    $response->assertSee('Dashboard Pertumbuhan Ternak');
    $response->assertSee('id="desktop-sidebar-toggle"', false);
    $response->assertSee('Pertumbuhan Produksi Susu');
    $response->assertSee('Pertumbuhan Populasi Ternak');
    $response->assertSee('Laju Pertambahan Bobot Harian');
    $response->assertSee('Pertumbuhan Omzet Peternakan');
    $response->assertSee('id="chart-perkembangan-peternak"', false);
    $response->assertSee('id="chart-distribusi-status"', false);
    $response->assertSee('id="chart-kategori-program"', false);
    $response->assertSee('id="default-table"', false);
    $response->assertSee('id="tabel-data-peternak"', false);
});
