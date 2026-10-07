<?php

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
});

test('masyarakat umum is redirected to marketplace upon login', function () {
    $masyarakat = User::where('role', 'umum')->first() ?? User::factory()->create([
        'role' => 'umum',
        'password' => bcrypt('password'),
    ]);

    $response = $this->post(route('login.submit'), [
        'email' => $masyarakat->email,
        'password' => 'password',
    ]);

    $response->assertRedirect(route('marketplace'));
});

test('masyarakat dashboard displays shopper hub and marketplace shortcuts', function () {
    $masyarakat = User::where('role', 'umum')->first() ?? User::factory()->create(['role' => 'umum']);

    $response = $this->actingAs($masyarakat)->get(route('dashboard'));

    $response->assertOk();
    $response->assertSee('Portal Belanja Ternak Jatim');
    $response->assertSee('Produk Tersedia');
    $response->assertSee('Pesanan Saya');
    $response->assertSee('Mulai Belanja Sekarang');
    $response->assertSee(route('marketplace'));
});

test('masyarakat can search and filter livestock products in marketplace catalog', function () {
    $masyarakat = User::where('role', 'umum')->first() ?? User::factory()->create(['role' => 'umum']);
    $catSusu = ProductCategory::where('slug', 'susu-olahan')->first();

    // Catalog view renders with Shopee elements
    $response = $this->actingAs($masyarakat)->get(route('marketplace'));
    $response->assertOk();
    $response->assertSee('Pasar Digital Peternak Milenial Jatim');
    $response->assertSee('Bebas Ongkir');
    $response->assertSee('Beli Sekarang');

    // Filter by category
    if ($catSusu) {
        $filterResponse = $this->actingAs($masyarakat)->get(route('marketplace', ['kategori' => $catSusu->slug]));
        $filterResponse->assertOk();
    }

    // Search query
    $searchResponse = $this->actingAs($masyarakat)->get(route('marketplace', ['q' => 'Susu']));
    $searchResponse->assertOk();
});

test('masyarakat can buy product and create order with payment method and shipping address', function () {
    $masyarakat = User::where('role', 'umum')->first() ?? User::factory()->create(['role' => 'umum']);
    $product = Product::where('status', 'active')->where('is_verified', true)->first();
    $initialStock = $product->stock;

    $response = $this->actingAs($masyarakat)->post(route('marketplace.products.buy', $product), [
        'quantity' => 2,
        'buyer_name' => $masyarakat->name,
        'buyer_phone' => '081299988877',
        'shipping_address' => 'Jl. Ketintang Baru No. 12, Surabaya',
        'payment_method' => 'QRIS Instan',
        'notes' => 'Tolong kirimkan pagi hari dalam kemasan dingin.',
    ]);

    $response->assertRedirect(route('marketplace'));
    $response->assertSessionHas('success');

    // Check stock was decremented
    expect($product->fresh()->stock)->toBe($initialStock - 2);

    // Check order in database
    $order = Order::where('buyer_id', $masyarakat->id)->latest('id')->first();
    expect($order)->not->toBeNull();
    expect($order->status)->toBe('processing');
    expect((float) $order->total_amount)->toBe((float) ($product->price * 2));
    expect($order->notes)->toContain('QRIS Instan');
    expect($order->notes)->toContain('kemasan dingin');

    // Check order item
    expect(OrderItem::where('order_id', $order->id)->count())->toBe(1);
});

test('masyarakat buyer can track and complete their own orders on pesanan page', function () {
    $masyarakat = User::where('role', 'umum')->first() ?? User::factory()->create(['role' => 'umum']);
    $product = Product::where('status', 'active')->where('is_verified', true)->first();

    $order = Order::create([
        'order_code' => '#ORD-TRACK-001',
        'buyer_id' => $masyarakat->id,
        'total_amount' => $product->price,
        'status' => 'processing',
        'shipping_address' => 'Jl. Gubeng Pojok, Surabaya',
        'buyer_phone' => '08123456789',
        'notes' => 'Pesanan aktif',
    ]);

    OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'seller_id' => $product->user_id,
        'quantity' => 1,
        'price_per_unit' => $product->price,
        'subtotal' => $product->price,
    ]);

    // Orders are NOT shown on marketplace page
    $marketplaceResponse = $this->actingAs($masyarakat)->get(route('marketplace'));
    $marketplaceResponse->assertOk();
    $marketplaceResponse->assertDontSee($order->order_code);

    // Orders ARE shown on dedicated /pesanan page
    $response = $this->actingAs($masyarakat)->get(route('pesanan'));
    $response->assertOk();
    $response->assertSee($order->order_code);
    $response->assertSee('Pesanan Diterima');

    // Buyer completes order (barang diterima)
    $updateResponse = $this->actingAs($masyarakat)->patch(route('marketplace.orders.status', $order), [
        'status' => 'completed',
        'from' => 'pesanan',
    ]);

    $updateResponse->assertRedirect(route('pesanan'));
    expect($order->fresh()->status)->toBe('completed');
});

test('masyarakat buyer cannot tamper with orders belonging to other buyers', function () {
    $buyerA = User::factory()->create(['role' => 'umum']);
    $buyerB = User::factory()->create(['role' => 'umum']);
    $product = Product::where('status', 'active')->where('is_verified', true)->first();

    $orderOfA = Order::create([
        'order_code' => '#ORD-BUYERA-99',
        'buyer_id' => $buyerA->id,
        'total_amount' => $product->price,
        'status' => 'processing',
        'shipping_address' => 'Alamat A',
        'buyer_phone' => '0811111111',
    ]);

    // Buyer B attempts to modify Buyer A's order -> 403 Forbidden
    $response = $this->actingAs($buyerB)->patch(route('marketplace.orders.status', $orderOfA), [
        'status' => 'cancelled',
    ]);

    $response->assertStatus(403);
    expect($orderOfA->fresh()->status)->toBe('processing');
});

test('pesanan route displays dedicated orders management page for buyer', function () {
    $masyarakat = User::where('role', 'umum')->first() ?? User::factory()->create(['role' => 'umum']);
    $response = $this->actingAs($masyarakat)->get(route('pesanan'));
    $response->assertOk();
    $response->assertSee('Pesanan Saya');
    $response->assertSee('Belanja Produk Ternak');
});

test('pesanan saya displays compact order cards and full detail drawer data', function () {
    $masyarakat = User::where('role', 'umum')->first() ?? User::factory()->create(['role' => 'umum']);
    $product = Product::where('status', 'active')->where('is_verified', true)->first();

    $order = Order::create([
        'order_code' => '#ORD-DETAIL-TEST-777',
        'buyer_id' => $masyarakat->id,
        'total_amount' => $product->price * 2,
        'status' => 'shipped',
        'shipping_address' => 'Jl. Ketintang Baru No. 10, Surabaya',
        'buyer_phone' => '081299988877',
        'notes' => 'Metode: QRIS Instan • Catatan: Tolong cantumkan label fragile',
    ]);

    OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'seller_id' => $product->user_id,
        'quantity' => 2,
        'price_per_unit' => $product->price,
        'subtotal' => $product->price * 2,
    ]);

    // Must be on dedicated /pesanan page
    $response = $this->actingAs($masyarakat)->get(route('pesanan'));
    $response->assertOk();

    // Compact Card asserts
    $response->assertSee($order->order_code);
    $response->assertSee('Dalam Pengiriman');
    $response->assertSee('Lihat Detail');

    // Detail Drawer source asserts
    $response->assertSee('Detail Pesanan');
    $response->assertSee('Rincian Pembayaran');
    $response->assertSee('Informasi Penerima &amp; Alamat', false);
    $response->assertSee('Jl. Ketintang Baru No. 10, Surabaya');
    $response->assertSee('QRIS Instan');
    $response->assertSee('Tolong cantumkan label fragile');
    $response->assertSee('Cetak Bukti Transaksi');
});

test('order show route allows authorized buyer and forbids other users', function () {
    $buyer = User::factory()->create(['role' => 'umum']);
    $stranger = User::factory()->create(['role' => 'umum']);
    $product = Product::where('status', 'active')->where('is_verified', true)->first();

    $order = Order::create([
        'order_code' => '#ORD-SEC-001',
        'buyer_id' => $buyer->id,
        'total_amount' => $product->price,
        'status' => 'processing',
        'shipping_address' => 'Jl. Pahlawan No. 1',
        'buyer_phone' => '081234567890',
    ]);

    OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'seller_id' => $product->user_id,
        'quantity' => 1,
        'price_per_unit' => $product->price,
        'subtotal' => $product->price,
    ]);

    // Authorized buyer can fetch JSON
    $authResponse = $this->actingAs($buyer)->getJson(route('marketplace.orders.show', $order));
    $authResponse->assertOk();
    $authResponse->assertJsonPath('order.order_code', '#ORD-SEC-001');

    // Unauthorized stranger gets 403 Forbidden
    $unauthResponse = $this->actingAs($stranger)->getJson(route('marketplace.orders.show', $order));
    $unauthResponse->assertStatus(403);
});
