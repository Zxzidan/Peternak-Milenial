<?php

use App\Models\Consultation;
use App\Models\EmergencyReport;
use App\Models\Livestock;
use App\Models\PeternakProfile;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Region;
use App\Models\TrainingRegistration;
use App\Models\User;

test('new peternak registration strictly creates only user account without any fake or dummy data', function () {
    $email = 'peternak.baru.'.time().'@gmail.com';

    $response = $this->post(route('register.submit'), [
        'name' => 'Peternak Muda Lamongan',
        'email' => $email,
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => 'peternak',
        'phone' => '081298765432',
        'terms' => 'on',
    ]);

    $response->assertRedirect(route('dashboard'));

    $user = User::where('email', $email)->first();
    expect($user)->not->toBeNull();
    expect($user->name)->toBe('Peternak Muda Lamongan');
    expect($user->role)->toBe('peternak');

    // Strict validation: NO automatic fake farm, livestock, products, reports, consultations, etc.
    expect(PeternakProfile::where('user_id', $user->id)->count())->toBe(0);
    expect(Livestock::where('user_id', $user->id)->count())->toBe(0);
    expect(Product::where('user_id', $user->id)->count())->toBe(0);
    expect(EmergencyReport::where('user_id', $user->id)->count())->toBe(0);
    expect(Consultation::where('user_id', $user->id)->count())->toBe(0);
    expect(TrainingRegistration::where('user_id', $user->id)->count())->toBe(0);
});

test('marketplace public catalog strictly excludes unverified products from general users', function () {
    $peternak = User::where('role', 'peternak')->first() ?? User::factory()->create(['role' => 'peternak']);
    $category = ProductCategory::firstOrCreate(['slug' => 'susu-olahan'], ['name' => 'Susu & Olahan']);
    $region = Region::firstOrCreate(['code' => 'PAS'], ['name' => 'Kabupaten Pasuruan']);

    $unverifiedProduct = Product::create([
        'user_id' => $peternak->id,
        'product_category_id' => $category->id,
        'region_id' => $region->id,
        'name' => 'Susu Kambing Unverified Test '.time(),
        'slug' => 'susu-kambing-unverified-'.time(),
        'description' => 'Produk baru yang belum diverifikasi dinas',
        'price' => 35000,
        'stock' => 50,
        'unit' => 'Botol (500ml)',
        'is_verified' => false,
        'status' => 'active',
    ]);

    // As general visitor (guest or umum), unverified product MUST NOT appear in catalog
    $guestResponse = $this->get(route('marketplace'));
    $guestResponse->assertOk();
    $guestResponse->assertDontSee($unverifiedProduct->name);

    $umum = User::where('role', 'umum')->first() ?? User::factory()->create(['role' => 'umum']);
    $umumResponse = $this->actingAs($umum)->get(route('marketplace'));
    $umumResponse->assertOk();
    $umumResponse->assertDontSee($unverifiedProduct->name);

    // As the peternak owner, the product appears in their own management list with 'Menunggu Verifikasi Admin'
    $peternakResponse = $this->actingAs($peternak)->get(route('marketplace'));
    $peternakResponse->assertOk();
    $peternakResponse->assertSee($unverifiedProduct->name);
    $peternakResponse->assertSee('Menunggu Verifikasi Admin');

    // As Admin, can see the product and verify it
    $admin = User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin']);
    $adminResponse = $this->actingAs($admin)->get(route('marketplace'));
    $adminResponse->assertOk();
    $adminResponse->assertSee($unverifiedProduct->name);
    $adminResponse->assertSee('Setujui &amp; Publikasi', false);

    // After admin verifies, product becomes public
    $this->actingAs($admin)->patch(route('marketplace.products.verify', $unverifiedProduct));
    expect($unverifiedProduct->fresh()->is_verified)->toBeTrue();

    // Now umum can see the verified product
    $umumResponseAfter = $this->actingAs($umum)->get(route('marketplace'));
    $umumResponseAfter->assertSee($unverifiedProduct->name);
});

test('new peternak sees clean empty states for consultation and certificates without fake data', function () {
    $newPeternak = User::factory()->create([
        'role' => 'peternak',
        'name' => 'Peternak Tanpa Data',
        'email' => 'tanpadata.'.time().'@test.com',
    ]);

    // Consultation empty state
    $consultationResponse = $this->actingAs($newPeternak)->get(route('konsultasi'));
    $consultationResponse->assertOk();
    $consultationResponse->assertSee('Belum ada sesi konsultasi aktif');
    $consultationResponse->assertSee('Belum ada data rekam medis kesehatan ternak');

    // Pelatihan empty state for certificates
    $trainingResponse = $this->actingAs($newPeternak)->get(route('pelatihan'));
    $trainingResponse->assertOk();
    $trainingResponse->assertSee('Belum ada sertifikat digital yang diterbitkan');
});
