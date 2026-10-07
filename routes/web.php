<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommodityPriceController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmergencyReportController;
use App\Http\Controllers\ExhibitionController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TrainingController;
use Illuminate\Support\Facades\Route;

// 0. Autentikasi Pengguna (Login, Register, Logout)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 1. Landing Page Utama (Public Portal Peternak Milenial Jatim)
Route::get('/', [LandingController::class, 'index'])->name('landing');

// 2. Global Search
Route::get('/search', [SearchController::class, 'search'])->name('search');

// 3. Dashboard Peternakan Jatim (Tampilan Disesuaikan Sesuai Role)
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// 4. Siaga Darurat & Kesejahteraan Hewan (Hanya Admin & Peternak)
Route::middleware(['role:admin,peternak'])->group(function () {
    Route::get('/darurat', [EmergencyReportController::class, 'index'])->name('darurat');
    Route::post('/darurat', [EmergencyReportController::class, 'store'])->name('darurat.store');
    Route::patch('/darurat/{report}/status', [EmergencyReportController::class, 'updateStatus'])
        ->middleware('role:admin')
        ->name('darurat.status');
    Route::delete('/darurat/{report}', [EmergencyReportController::class, 'destroy'])->name('darurat.destroy');
});

// 5. Pelatihan & Bimbingan Teknis (Hanya Admin & Peternak)
Route::middleware(['role:admin,peternak'])->group(function () {
    Route::get('/pelatihan', [TrainingController::class, 'index'])->name('pelatihan');
    Route::post('/pelatihan/{training}/daftar', [TrainingController::class, 'register'])->name('pelatihan.register');
    Route::delete('/pelatihan/registrations/{registration}', [TrainingController::class, 'cancelRegistration'])->name('pelatihan.cancel');

    // Fitur Khusus Admin Pelatihan
    Route::middleware('role:admin')->group(function () {
        Route::post('/pelatihan', [TrainingController::class, 'store'])->name('pelatihan.store');
        Route::delete('/pelatihan/{training}', [TrainingController::class, 'destroy'])->name('pelatihan.destroy');
        Route::patch('/pelatihan/registrations/{registration}/status', [TrainingController::class, 'updateRegistrationStatus'])->name('pelatihan.registration.status');
        Route::post('/pelatihan/materials', [TrainingController::class, 'storeMaterial'])->name('pelatihan.materials.store');
        Route::delete('/pelatihan/materials/{material}', [TrainingController::class, 'destroyMaterial'])->name('pelatihan.materials.destroy');
        Route::post('/pelatihan/certificates', [TrainingController::class, 'issueCertificate'])->name('pelatihan.certificates.issue');
        Route::delete('/pelatihan/certificates/{certificate}', [TrainingController::class, 'destroyCertificate'])->name('pelatihan.certificates.destroy');
    });
});

// 6. Marketplace & Pesanan Peternak Milenial
Route::get('/marketplace', [MarketplaceController::class, 'index'])->name('marketplace');
Route::get('/pesanan', [MarketplaceController::class, 'ordersIndex'])->name('pesanan');
Route::get('/pesanan/{order}', [MarketplaceController::class, 'showOrder'])->name('pesanan.show');
Route::get('/marketplace/orders/{order}', [MarketplaceController::class, 'showOrder'])->name('marketplace.orders.show');
Route::post('/marketplace/products/{product}/buy', [MarketplaceController::class, 'buyProduct'])->name('marketplace.products.buy');
Route::patch('/marketplace/orders/{order}/status', [MarketplaceController::class, 'updateOrderStatus'])->name('marketplace.orders.status');

// Kelola Produk (Peternak & Admin)
Route::middleware(['role:admin,peternak'])->group(function () {
    Route::post('/marketplace/products', [MarketplaceController::class, 'storeProduct'])->name('marketplace.products.store');
    Route::delete('/marketplace/products/{product}', [MarketplaceController::class, 'destroyProduct'])->name('marketplace.products.destroy');

    // Verifikasi Produk oleh Admin
    Route::patch('/marketplace/products/{product}/verify', [MarketplaceController::class, 'verifyProduct'])
        ->middleware('role:admin')
        ->name('marketplace.products.verify');
});

// 7. Harga Komoditas & Sentra Produksi
Route::get('/harga-komoditas', [CommodityPriceController::class, 'index'])->name('harga-komoditas');
Route::middleware(['role:admin'])->group(function () {
    Route::post('/harga-komoditas', [CommodityPriceController::class, 'store'])->name('harga-komoditas.store');
    Route::delete('/harga-komoditas/{price}', [CommodityPriceController::class, 'destroy'])->name('harga-komoditas.destroy');
});

// 8. Konsultasi Dokter & Rekam Medis Digital (Hanya Admin & Peternak)
Route::middleware(['role:admin,peternak'])->group(function () {
    Route::get('/konsultasi', [ConsultationController::class, 'index'])->name('konsultasi');
    Route::post('/konsultasi/start', [ConsultationController::class, 'startConsultation'])->name('konsultasi.start');
    Route::post('/konsultasi/{consultation}/messages', [ConsultationController::class, 'sendMessage'])->name('konsultasi.message');
    Route::post('/konsultasi/livestock', [ConsultationController::class, 'storeLivestock'])->name('konsultasi.livestock.store');

    // Tindak Lanjut & Rekam Medis Resmi (Admin / Dokter Hewan Dinas)
    Route::middleware('role:admin')->group(function () {
        Route::post('/konsultasi/rekam-medis', [ConsultationController::class, 'storeHealthRecord'])->name('konsultasi.health-record.store');
        Route::delete('/konsultasi/rekam-medis/{record}', [ConsultationController::class, 'destroyHealthRecord'])->name('konsultasi.health-record.destroy');
        Route::post('/konsultasi/diseases', [ConsultationController::class, 'storeDisease'])->name('konsultasi.diseases.store');
        Route::delete('/konsultasi/diseases/{disease}', [ConsultationController::class, 'destroyDisease'])->name('konsultasi.diseases.destroy');
        Route::post('/konsultasi/veterinarians', [ConsultationController::class, 'storeVeterinarian'])->name('konsultasi.veterinarians.store');
        Route::put('/konsultasi/veterinarians/{veterinarian}', [ConsultationController::class, 'updateVeterinarian'])->name('konsultasi.veterinarians.update');
        Route::delete('/konsultasi/veterinarians/{veterinarian}', [ConsultationController::class, 'destroyVeterinarian'])->name('konsultasi.veterinarians.destroy');
    });
});

// 9. Pameran & Kalender Terpadu
Route::get('/pameran', [ExhibitionController::class, 'index'])->name('pameran');
Route::middleware(['role:admin,peternak'])->group(function () {
    Route::post('/pameran/register', [ExhibitionController::class, 'registerStand'])->name('pameran.register');
    Route::delete('/pameran/registrations/{registration}', [ExhibitionController::class, 'destroyRegistration'])->name('pameran.destroy');
    Route::patch('/pameran/registrations/{registration}/status', [ExhibitionController::class, 'updateStatus'])
        ->middleware('role:admin')
        ->name('pameran.status');
    Route::post('/pameran/exhibitions', [ExhibitionController::class, 'storeExhibition'])
        ->middleware('role:admin')
        ->name('pameran.exhibition.store');
    Route::put('/pameran/exhibitions/{exhibition}', [ExhibitionController::class, 'updateExhibition'])
        ->middleware('role:admin')
        ->name('pameran.exhibition.update');
    Route::delete('/pameran/exhibitions/{exhibition}', [ExhibitionController::class, 'destroyExhibition'])
        ->middleware('role:admin')
        ->name('pameran.exhibition.destroy');
    Route::post('/pameran/calendar-events', [ExhibitionController::class, 'storeCalendarEvent'])
        ->middleware('role:admin')
        ->name('pameran.calendar.store');
});

// 10. API Data Valid Peternakan Resmi Provinsi Jawa Timur (Disnak Jatim & BPS)
Route::get('/api/statistik-peternakan', [DashboardController::class, 'apiStatistikPeternakan'])->name('api.statistik-peternakan');
Route::get('/api/sentra-peternakan', [DashboardController::class, 'apiSentraPeternakan'])->name('api.sentra-peternakan');
