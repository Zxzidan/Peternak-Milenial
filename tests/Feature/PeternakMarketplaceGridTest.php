<?php

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Region;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('peternak can store product with an image and region', function () {
    Storage::fake('public');

    $peternak = User::factory()->create(['role' => 'peternak']);
    $category = ProductCategory::firstOrCreate(['slug' => 'susu-olahan'], ['name' => 'Susu Olahan']);
    $region = Region::firstOrCreate(['code' => 'MLG'], ['name' => 'Kabupaten Malang']);

    $imageFile = UploadedFile::fake()->image('susu_murni.jpg', 600, 600);

    $response = $this->actingAs($peternak)->post(route('marketplace.products.store'), [
        'name' => 'Susu Kambing Etawa Segar',
        'product_category_id' => $category->id,
        'region_id' => $region->id,
        'price' => 25000,
        'stock' => 30,
        'unit' => 'Liter',
        'description' => 'Susu murni kambing etawa higienis dari peternakan Blitar.',
        'image' => $imageFile,
    ]);

    $response->assertRedirect(route('marketplace'));
    $response->assertSessionHas('success');

    $product = Product::where('name', 'Susu Kambing Etawa Segar')->first();
    expect($product)->not->toBeNull();
    expect($product->user_id)->toBe($peternak->id);
    expect($product->image_path)->not->toBeNull();
    Storage::disk('public')->assertExists($product->image_path);
});

test('peternak can update product information and replace image', function () {
    Storage::fake('public');

    $peternak = User::factory()->create(['role' => 'peternak']);
    $category1 = ProductCategory::firstOrCreate(['slug' => 'kategori-lama'], ['name' => 'Kategori Lama']);
    $category2 = ProductCategory::firstOrCreate(['slug' => 'kategori-baru'], ['name' => 'Kategori Baru']);
    $region = Region::firstOrCreate(['code' => 'BLT'], ['name' => 'Kabupaten Blitar']);

    // Seed initial product with initial image
    $oldImage = UploadedFile::fake()->image('foto_lama.jpg');
    $oldPath = $oldImage->store('products', 'public');

    $product = Product::create([
        'user_id' => $peternak->id,
        'product_category_id' => $category1->id,
        'region_id' => $region->id,
        'name' => 'Susu Kambing Mentah',
        'slug' => 'susu-kambing-mentah-123',
        'description' => 'Deskripsi lama',
        'price' => 20000,
        'stock' => 10,
        'unit' => 'Liter',
        'image_path' => $oldPath,
        'is_verified' => false,
        'status' => 'active',
    ]);

    Storage::disk('public')->assertExists($oldPath);

    // Update with new image and info
    $newImage = UploadedFile::fake()->image('foto_baru.jpg');

    $updateResponse = $this->actingAs($peternak)->put(route('marketplace.products.update', $product), [
        'name' => 'Susu Kambing Pasteurisasi Premium',
        'product_category_id' => $category2->id,
        'region_id' => $region->id,
        'price' => 28000,
        'stock' => 50,
        'unit' => 'Botol 1L',
        'description' => 'Deskripsi baru setelah pasteurisasi higienis.',
        'image' => $newImage,
    ]);

    $updateResponse->assertRedirect(route('marketplace'));
    $updateResponse->assertSessionHas('success');

    $product->refresh();
    expect($product->name)->toBe('Susu Kambing Pasteurisasi Premium');
    expect((float) $product->price)->toBe(28000.0);
    expect($product->stock)->toBe(50);
    expect($product->unit)->toBe('Botol 1L');
    expect($product->product_category_id)->toBe($category2->id);

    // Old image is deleted from storage, new image exists
    Storage::disk('public')->assertMissing($oldPath);
    Storage::disk('public')->assertExists($product->image_path);
});

test('peternak cannot update product belonging to another peternak', function () {
    $peternakOwner = User::factory()->create(['role' => 'peternak']);
    $otherPeternak = User::factory()->create(['role' => 'peternak']);
    $category = ProductCategory::firstOrCreate(['slug' => 'kategori-tes'], ['name' => 'Kategori Tes']);
    $region = Region::firstOrCreate(['code' => 'PAS'], ['name' => 'Kabupaten Pasuruan']);

    $product = Product::create([
        'user_id' => $peternakOwner->id,
        'product_category_id' => $category->id,
        'region_id' => $region->id,
        'name' => 'Produk Milik Owner',
        'slug' => 'produk-milik-owner-123',
        'description' => 'Deskripsi',
        'price' => 30000,
        'stock' => 15,
        'unit' => 'Kg',
        'is_verified' => false,
        'status' => 'active',
    ]);

    $response = $this->actingAs($otherPeternak)->put(route('marketplace.products.update', $product), [
        'name' => 'Pembajakan Produk',
        'product_category_id' => $category->id,
        'price' => 1000,
        'stock' => 1,
        'unit' => 'Kg',
    ]);

    $response->assertStatus(403);
});

test('peternak cannot buy products in marketplace as role is strictly for selling', function () {
    $peternak = User::factory()->create(['role' => 'peternak']);
    $category = ProductCategory::firstOrCreate(['slug' => 'kategori-pakan'], ['name' => 'Kategori Pakan']);
    $region = Region::firstOrCreate(['code' => 'BAT'], ['name' => 'Kota Batu']);

    $product = Product::create([
        'user_id' => $peternak->id,
        'product_category_id' => $category->id,
        'region_id' => $region->id,
        'name' => 'Silase Jagung Unggul',
        'slug' => 'silase-jagung-unggul-456',
        'description' => 'Silase berkualitas tinggi',
        'price' => 75000,
        'stock' => 20,
        'unit' => 'Sak',
        'is_verified' => true,
        'status' => 'active',
    ]);

    $response = $this->actingAs($peternak)->post(route('marketplace.products.buy', $product), [
        'quantity' => 2,
        'buyer_name' => 'Peternak Mencoba Beli',
        'buyer_phone' => '081234567890',
        'shipping_address' => 'Jl. Peternak No. 1, Batu',
    ]);

    $response->assertRedirect(route('marketplace'));
    $response->assertSessionHas('error');
});

test('peternak marketplace renders grid layout and excludes consumer catalog link', function () {
    $peternak = User::factory()->create(['role' => 'peternak']);
    $category = ProductCategory::firstOrCreate(['slug' => 'susu-kambing'], ['name' => 'Susu Kambing']);
    $region = Region::firstOrCreate(['code' => 'BLT2'], ['name' => 'Kabupaten Blitar']);

    $product = Product::create([
        'user_id' => $peternak->id,
        'product_category_id' => $category->id,
        'region_id' => $region->id,
        'name' => 'Susu Kambing Organik Super Kotak',
        'slug' => 'susu-kambing-organik-super-kotak-789',
        'description' => 'Susu kambing murni berkualitas prima.',
        'price' => 32000,
        'stock' => 45,
        'unit' => 'Liter',
        'is_verified' => false,
        'status' => 'active',
    ]);

    $response = $this->actingAs($peternak)->get(route('marketplace'));

    $response->assertOk();
    $response->assertSee('Kelola Produk Peternakan');
    $response->assertSee('Daftar Produk Peternakan Saya');
    $response->assertSee($product->name);
    $response->assertSee('Menunggu Verifikasi Admin');
    $response->assertSee('Edit Produk');
    $response->assertSee('Unggah Produk Baru');
    $response->assertDontSee('Katalog Belanja');
});

test('peternak pesanan page displays incoming orders from masyarakat instead of buyer shopping perspective', function () {
    $peternak = User::factory()->create(['role' => 'peternak']);
    $masyarakat = User::factory()->create(['name' => 'Pak Joko Santoso', 'role' => 'umum']);

    $category = ProductCategory::firstOrCreate(['slug' => 'telur-unggas'], ['name' => 'Telur & Unggas']);
    $region = Region::firstOrCreate(['code' => 'KDR'], ['name' => 'Kabupaten Kediri']);

    $product = Product::create([
        'user_id' => $peternak->id,
        'product_category_id' => $category->id,
        'region_id' => $region->id,
        'name' => 'Telur Ayam Omega-3 Segar',
        'slug' => 'telur-ayam-omega-3-segar-test',
        'description' => 'Telur ayam organik kaya omega-3.',
        'price' => 35000,
        'stock' => 50,
        'unit' => 'Tray (30 butir)',
        'is_verified' => true,
        'status' => 'active',
    ]);

    $order = Order::create([
        'order_code' => '#ORD-MASYARAKAT-999',
        'buyer_id' => $masyarakat->id,
        'total_amount' => 70000,
        'status' => 'pending',
        'shipping_address' => 'Jl. Veteran No. 45, Kediri',
        'buyer_phone' => '081234567899',
        'notes' => 'Metode: Transfer Bank • Catatan: Packing krat ekstra aman',
    ]);

    OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'seller_id' => $peternak->id,
        'quantity' => 2,
        'price_per_unit' => 35000,
        'subtotal' => 70000,
    ]);

    $response = $this->actingAs($peternak)->get(route('pesanan'));

    $response->assertOk();
    $response->assertSee('Pesanan Masuk dari Masyarakat');
    $response->assertSee('Kelola Produk Peternakan');
    $response->assertDontSee('Belanja Produk Ternak');
    $response->assertSee('Total Pesanan Masuk');
    $response->assertSee($order->order_code);
    $response->assertSee('Pak Joko Santoso');
    $response->assertSee('Masyarakat');
    $response->assertSee('Proses &amp; Kemas', false);
    $response->assertDontSee('Pesanan Diterima');
});

test('peternak can process and advance status of incoming orders from masyarakat', function () {
    $peternak = User::factory()->create(['role' => 'peternak']);
    $masyarakat = User::factory()->create(['name' => 'Bu Siti Aminah', 'role' => 'umum']);

    $category = ProductCategory::firstOrCreate(['slug' => 'daging-sapi'], ['name' => 'Daging Sapi']);
    $region = Region::firstOrCreate(['code' => 'MLG3'], ['name' => 'Kota Malang']);

    $product = Product::create([
        'user_id' => $peternak->id,
        'product_category_id' => $category->id,
        'region_id' => $region->id,
        'name' => 'Daging Sapi Sirloin Segar',
        'slug' => 'daging-sapi-sirloin-segar-test',
        'description' => 'Daging sapi higienis RPH resmi.',
        'price' => 130000,
        'stock' => 20,
        'unit' => 'Kg',
        'is_verified' => true,
        'status' => 'active',
    ]);

    $order = Order::create([
        'order_code' => '#ORD-PROCESS-888',
        'buyer_id' => $masyarakat->id,
        'total_amount' => 130000,
        'status' => 'pending',
        'shipping_address' => 'Jl. Ijen No. 10, Malang',
        'buyer_phone' => '081299900011',
    ]);

    OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'seller_id' => $peternak->id,
        'quantity' => 1,
        'price_per_unit' => 130000,
        'subtotal' => 130000,
    ]);

    // Peternak advances to processing
    $response1 = $this->actingAs($peternak)->patch(route('marketplace.orders.status', $order), [
        'status' => 'processing',
        'from' => 'pesanan',
    ]);
    $response1->assertRedirect(route('pesanan'));
    expect($order->fresh()->status)->toBe('processing');

    // Peternak advances to shipped
    $response2 = $this->actingAs($peternak)->patch(route('marketplace.orders.status', $order), [
        'status' => 'shipped',
        'from' => 'pesanan',
    ]);
    $response2->assertRedirect(route('pesanan'));
    expect($order->fresh()->status)->toBe('shipped');

    // Peternak advances to completed
    $response3 = $this->actingAs($peternak)->patch(route('marketplace.orders.status', $order), [
        'status' => 'completed',
        'from' => 'pesanan',
    ]);
    $response3->assertRedirect(route('pesanan'));
    expect($order->fresh()->status)->toBe('completed');
});
