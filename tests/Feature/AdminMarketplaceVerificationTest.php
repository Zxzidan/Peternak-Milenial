<?php

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Region;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
});

test('admin is focused exclusively on product verification in marketplace', function () {
    $admin = User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->get(route('marketplace'));
    $response->assertOk();

    // Must see Admin verification headlines and badges
    $response->assertSee('Verifikasi Produk Peternak');
    $response->assertSee('Bidang Pascapanen &amp; Pemasaran', false);
    $response->assertSee('Daftar Verifikasi Produk Peternak');
    $response->assertSee('Menunggu Verifikasi');
    $response->assertSee('Total Produk Peternak');

    // Admin MUST NOT see customer shopping catalog and order buttons
    $response->assertDontSee('Katalog Belanja');
    $response->assertDontSee('Pesanan Saya');
    $response->assertDontSee('Riwayat Pesanan');
    $response->assertDontSee('Bebas Ongkir Subsidi Jatim');
});

test('admin accessing pesanan route is redirected to marketplace verification', function () {
    $admin = User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->get(route('pesanan'));
    $response->assertRedirect(route('marketplace'));
});

test('admin can filter pending and verified products and search in verification table', function () {
    $admin = User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin']);
    $peternak = User::where('role', 'peternak')->first() ?? User::factory()->create(['role' => 'peternak']);
    $category = ProductCategory::first() ?? ProductCategory::create(['name' => 'Susu', 'slug' => 'susu']);
    $region = Region::first() ?? Region::create(['name' => 'Kabupaten Malang', 'province' => 'Jawa Timur']);

    $unverified = Product::create([
        'user_id' => $peternak->id,
        'product_category_id' => $category->id,
        'region_id' => $region->id,
        'name' => 'Produk Pending Khusus Uji',
        'slug' => 'produk-pending-khusus-uji-'.time(),
        'description' => 'Produk uji coba belum diverifikasi',
        'price' => 15000,
        'stock' => 10,
        'unit' => 'Liter',
        'is_verified' => false,
        'status' => 'active',
    ]);

    $verified = Product::create([
        'user_id' => $peternak->id,
        'product_category_id' => $category->id,
        'region_id' => $region->id,
        'name' => 'Produk Lolos Verifikasi Uji',
        'slug' => 'produk-lolos-verifikasi-uji-'.time(),
        'description' => 'Produk uji coba sudah diverifikasi',
        'price' => 20000,
        'stock' => 5,
        'unit' => 'Liter',
        'is_verified' => true,
        'status' => 'active',
    ]);

    // Filter pending
    $pendingResp = $this->actingAs($admin)->get(route('marketplace', ['verifikasi' => 'pending']));
    $pendingResp->assertOk();
    $pendingResp->assertSee('Produk Pending Khusus Uji');
    $pendingResp->assertDontSee('Produk Lolos Verifikasi Uji');

    // Filter verified
    $verifiedResp = $this->actingAs($admin)->get(route('marketplace', ['verifikasi' => 'verified']));
    $verifiedResp->assertOk();
    $verifiedResp->assertSee('Produk Lolos Verifikasi Uji');
    $verifiedResp->assertDontSee('Produk Pending Khusus Uji');

    // Search query
    $searchResp = $this->actingAs($admin)->get(route('marketplace', ['q' => 'Pending Khusus']));
    $searchResp->assertOk();
    $searchResp->assertSee('Produk Pending Khusus Uji');
    $searchResp->assertDontSee('Produk Lolos Verifikasi Uji');
});

test('admin cannot upload products to sell in marketplace', function () {
    $admin = User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin']);
    $category = ProductCategory::first();

    $response = $this->actingAs($admin)->post(route('marketplace.products.store'), [
        'name' => 'Admin Product Illegal',
        'product_category_id' => $category?->id ?? 1,
        'price' => 50000,
        'stock' => 10,
        'unit' => 'Kg',
    ]);

    $response->assertStatus(403);
});
