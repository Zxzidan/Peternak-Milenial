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

test('redesigned dashboard includes plus jakarta sans and interactive controls', function () {
    $response = $this->get(route('dashboard'));

    $response->assertStatus(200);
    $response->assertSee('Plus Jakarta Sans');
    $response->assertSee('id="theme-toggle"', false);
    $response->assertSee('id="desktop-sidebar-toggle"', false);
    $response->assertSee('id="mobile-sidebar-toggle"', false);
    $response->assertSee('id="drawer-navigation"', false);
    $response->assertSee('id="main-content"', false);
    $response->assertSee('pt-24');
    $response->assertSee('pt-16');
    $response->assertSee('h-16');
    $response->assertSee('id="sidebar-backdrop"', false);
    $response->assertSee('id="emergency-modal"', false);
});
