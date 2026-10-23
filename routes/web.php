<?php

use App\Http\Controllers\AdminVeterinarianController;
use App\Http\Controllers\AnimalHealthReportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommodityPriceController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExhibitionController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\VeterinarianDashboardController;
use App\Http\Controllers\VeterinarianScheduleController;
use Illuminate\Support\Facades\Route;

// 0. Autentikasi Pengguna (Login, Register, Logout)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 1. Landing Page Utama & FAQ (Public Portal Peternak Milenial Jatim)
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/faq', [LandingController::class, 'faq'])->name('faq');

// 2. Global Search
Route::get('/search', [SearchController::class, 'search'])->name('search');

// 3. Dashboard Peternakan Jatim (Tampilan Disesuaikan Sesuai Role)
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// 4. Pengalihan Siaga Darurat (Fitur Telah Dihapus dari Role Admin & Peternak)
Route::get('/darurat', function () {
    return redirect()->route('dashboard');
})->name('darurat');

// 5. Pembelajaran, Pelatihan & Bimbingan Teknis (LMS Peternak & Admin)
Route::middleware(['role:admin,peternak'])->group(function () {
    Route::get('/pelatihan', [TrainingController::class, 'index'])->name('pelatihan');
    Route::get('/pembelajaran', [TrainingController::class, 'index'])->name('pembelajaran');
    Route::post('/pelatihan/{training}/daftar', [TrainingController::class, 'register'])->name('pelatihan.register');
    Route::post('/pelatihan/{training}/daftar-offline', [TrainingController::class, 'registerOffline'])->name('pelatihan.register.offline');
    Route::get('/pelatihan/registrations/{registration}/dokumen', [TrainingController::class, 'downloadRequirementDocument'])->name('pelatihan.registration.document');
    Route::delete('/pelatihan/registrations/{registration}', [TrainingController::class, 'cancelRegistration'])->name('pelatihan.cancel');
    Route::post('/pelatihan/materi/{material}/progress', [TrainingController::class, 'updateVideoProgress'])->name('pelatihan.materials.progress');
    Route::post('/pelatihan/kuis/{quiz}/submit', [TrainingController::class, 'submitQuiz'])->name('pelatihan.quiz.submit');
    Route::get('/pelatihan/dokumen/{type}/{id}', [TrainingController::class, 'downloadDocument'])->name('pelatihan.document.download');
    Route::get('/pelatihan/certificates/{training}/download', [TrainingController::class, 'downloadCertificate'])->name('pelatihan.certificates.download');

    // Fitur Khusus Admin Pelatihan & LMS
    Route::middleware('role:admin')->group(function () {
        Route::post('/pelatihan', [TrainingController::class, 'store'])->name('pelatihan.store');
        Route::delete('/pelatihan/{training}', [TrainingController::class, 'destroy'])->name('pelatihan.destroy');
        Route::post('/pelatihan/zoom-session', [TrainingController::class, 'storeZoomSession'])->name('pelatihan.zoom.store');
        Route::patch('/pelatihan/registrations/{registration}/status', [TrainingController::class, 'updateRegistrationStatus'])->name('pelatihan.registration.status');
        Route::post('/pelatihan/materials', [TrainingController::class, 'storeMaterial'])->name('pelatihan.materials.store');
        Route::match(['put', 'patch'], '/pelatihan/materials/{material}', [TrainingController::class, 'updateMaterial'])->name('pelatihan.materials.update');
        Route::delete('/pelatihan/materials/{material}', [TrainingController::class, 'destroyMaterial'])->name('pelatihan.materials.destroy');
        Route::post('/pelatihan/materials/{material}/quiz', [TrainingController::class, 'storeQuiz'])->name('pelatihan.quiz.store');
        Route::post('/pelatihan/quiz/{quiz}/questions', [TrainingController::class, 'storeQuizQuestion'])->name('pelatihan.quiz.question.store');
        Route::delete('/pelatihan/quiz/questions/{question}', [TrainingController::class, 'destroyQuizQuestion'])->name('pelatihan.quiz.question.destroy');
        Route::post('/pelatihan/certificates', [TrainingController::class, 'issueCertificate'])->name('pelatihan.certificates.issue');
        Route::get('/pelatihan/certificates/{training}/preview', [TrainingController::class, 'previewCertificate'])->name('pelatihan.certificates.preview');
        Route::delete('/pelatihan/trainings/{training}/certificate', [TrainingController::class, 'destroyCertificateTemplate'])->name('pelatihan.certificates.template.destroy');
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
    Route::match(['put', 'patch'], '/marketplace/products/{product}', [MarketplaceController::class, 'updateProduct'])->name('marketplace.products.update');
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

// 8. Konsultasi Dokter & Rekam Medis Digital
Route::middleware(['role:admin,peternak,dokter_hewan'])->group(function () {
    Route::get('/konsultasi', [ConsultationController::class, 'index'])->name('konsultasi');
    Route::post('/konsultasi/start', [ConsultationController::class, 'startConsultation'])->name('konsultasi.start');
    Route::post('/konsultasi/{consultation}/messages', [ConsultationController::class, 'sendMessage'])->name('konsultasi.message');
    Route::post('/konsultasi/livestock', [ConsultationController::class, 'storeLivestock'])->name('konsultasi.livestock.store');

    // Atur Jadwal Konsultasi Medis & Kuota
    Route::post('/konsultasi/book', [ConsultationController::class, 'bookSchedule'])->name('konsultasi.book');
    Route::delete('/konsultasi/bookings/{consultation}/cancel', [ConsultationController::class, 'cancelBooking'])->name('konsultasi.cancel');
    Route::get('/konsultasi/veterinarians/{veterinarian}/slots', [ConsultationController::class, 'getDoctorSlots'])->name('konsultasi.veterinarians.slots');

    // Unduh Dokumen Rekam Medis & Panduan Penanganan Ternak (PDF/Dokumen Resmi)
    Route::get('/konsultasi/rekam-medis/{type}/{id}/dokumen', [ConsultationController::class, 'downloadMedicalRecordDocument'])->name('konsultasi.rekam-medis.download');

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

// 8.1 Manajemen Akun Dokter Hewan oleh Admin Dinas
Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dokter-hewan', [AdminVeterinarianController::class, 'index'])->name('veterinarians.index');
    Route::post('/dokter-hewan', [AdminVeterinarianController::class, 'store'])->name('veterinarians.store');
    Route::put('/dokter-hewan/{veterinarian}', [AdminVeterinarianController::class, 'update'])->name('veterinarians.update');
    Route::patch('/dokter-hewan/{veterinarian}/toggle-active', [AdminVeterinarianController::class, 'toggleActive'])->name('veterinarians.toggle-active');
    Route::delete('/dokter-hewan/{veterinarian}', [AdminVeterinarianController::class, 'destroy'])->name('veterinarians.destroy');
});

// 8.2 Dashboard & Penanganan Laporan oleh Dokter Hewan (Khusus Role Dokter Hewan)
Route::middleware(['role:dokter_hewan'])->prefix('dokter-hewan')->name('dokter-hewan.')->group(function () {
    Route::get('/dashboard', [VeterinarianDashboardController::class, 'index'])->name('dashboard');
    Route::get('/laporan', [VeterinarianDashboardController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/{report}', [VeterinarianDashboardController::class, 'show'])->name('show');
    Route::post('/laporan/{report}/response', [VeterinarianDashboardController::class, 'storeResponse'])->name('response.store');
    Route::post('/laporan/{report}/propose-visit', [VeterinarianDashboardController::class, 'proposeVisit'])->name('visit.propose');
    Route::post('/laporan/{report}/visits/{visit}/complete', [VeterinarianDashboardController::class, 'recordVisitResult'])->name('visit.complete');
    Route::patch('/laporan/{report}/status', [VeterinarianDashboardController::class, 'updateStatus'])->name('status.update');
    Route::get('/kunjungan', [VeterinarianDashboardController::class, 'visits'])->name('kunjungan');

    // 8.2.1 Manajemen Jadwal & Kuota Layanan Konsultasi
    Route::get('/jadwal', [VeterinarianScheduleController::class, 'index'])->name('jadwal.index');
    Route::post('/jadwal', [VeterinarianScheduleController::class, 'storeSlot'])->name('jadwal.store');
    Route::post('/jadwal/generate-daily', [VeterinarianScheduleController::class, 'generateDailySlots'])->name('jadwal.generate');
    Route::patch('/jadwal/{schedule}/toggle', [VeterinarianScheduleController::class, 'toggleStatus'])->name('jadwal.toggle');
    Route::put('/jadwal/{schedule}', [VeterinarianScheduleController::class, 'updateSlot'])->name('jadwal.update');
    Route::delete('/jadwal/{schedule}', [VeterinarianScheduleController::class, 'destroySlot'])->name('jadwal.destroy');
    Route::patch('/jadwal/bookings/{consultation}/status', [VeterinarianScheduleController::class, 'updateBookingStatus'])->name('jadwal.booking.status');
    Route::delete('/jadwal/bookings/{consultation}', [VeterinarianScheduleController::class, 'destroyBooking'])->name('jadwal.booking.destroy');

    // 8.2.2 Pemeriksaan Klinis & Formulir Tanggapan Konsultasi Peternak
    Route::get('/konsultasi/{consultation}', [VeterinarianScheduleController::class, 'showConsultation'])->name('konsultasi.show');
    Route::post('/konsultasi/{consultation}/response', [VeterinarianScheduleController::class, 'storeConsultationResponse'])->name('konsultasi.response.store');
    Route::patch('/konsultasi/{consultation}/quick-status', [VeterinarianScheduleController::class, 'updateQuickStatus'])->name('konsultasi.status.update');
});

// 8.3 Pelaporan Kesehatan Hewan oleh Peternak
Route::middleware(['role:peternak,admin,dokter_hewan'])->group(function () {
    Route::get('/kesehatan-hewan', [AnimalHealthReportController::class, 'index'])->name('kesehatan-hewan.index');
    Route::get('/kesehatan-hewan/buat', [AnimalHealthReportController::class, 'create'])->name('kesehatan-hewan.create');
    Route::post('/kesehatan-hewan', [AnimalHealthReportController::class, 'store'])->name('kesehatan-hewan.store');
    Route::get('/kesehatan-hewan/{report}', [AnimalHealthReportController::class, 'show'])->name('kesehatan-hewan.show');
    Route::post('/kesehatan-hewan/{report}/reply', [AnimalHealthReportController::class, 'storeReply'])->name('kesehatan-hewan.reply');
    Route::post('/kesehatan-hewan/{report}/visits/{visit}/confirm', [AnimalHealthReportController::class, 'confirmVisit'])->name('kesehatan-hewan.visit.confirm');
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
