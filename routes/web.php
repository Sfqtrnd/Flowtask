<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Mahasiswa\SubmissionController as MhsSubmissionController;
use App\Http\Controllers\Mahasiswa\ProfilController as MhsProfilController;
use App\Http\Controllers\Asdos\KelasController;
use App\Http\Controllers\Asdos\ModulController;
use App\Http\Controllers\Asdos\SubmissionReviewController;
use App\Http\Controllers\Mahasiswa\TugasPribadiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('auth.login');
})->name('auth.login');

// --- AUTH ---
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.authenticate');
Route::delete('/logout', [AuthController::class, 'logout'])->name('auth.logout');

// --- SEMUA HARUS LOGIN ---
Route::middleware('auth')->group(function () {
    // Dashboard (otomatis menampilkan sesuai role)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Mahasiswa routes
    Route::middleware('can:mahasiswa')->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        // Dashboard Mahasiswa (override jika butuh route tersendiri)
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Tugas Pribadi
        Route::get('/personal-tasks', [TugasPribadiController::class, 'index'])->name('personal-tasks.index');
        Route::get('/personal-tasks/create', [TugasPribadiController::class, 'create'])->name('personal-tasks.create');
        Route::post('/personal-tasks', [TugasPribadiController::class, 'store'])->name('personal-tasks.store');
        Route::get('/personal-tasks/{id}/edit', [TugasPribadiController::class, 'edit'])->name('personal-tasks.edit');
        Route::put('/personal-tasks/{id}', [TugasPribadiController::class, 'update'])->name('personal-tasks.update');
        Route::delete('/personal-tasks/{id}', [TugasPribadiController::class, 'destroy'])->name('personal-tasks.destroy');

        // Submission Praktikum
        Route::get('/submissions', [MhsSubmissionController::class, 'indexModules'])->name('submissions.index');
        Route::get('/submissions/upload/{modul}', [MhsSubmissionController::class, 'showUploadForm'])->name('submissions.upload');
        Route::post('/submissions/upload/{modul}', [MhsSubmissionController::class, 'store'])->name('submissions.store');
        Route::get('/submissions/{id}', [MhsSubmissionController::class, 'detail'])->name('submissions.detail');
        Route::delete('/submissions/{id}', [MhsSubmissionController::class, 'destroy'])->name('submissions.destroy');
    });

    // Asdos routes
    Route::middleware('can:asdos')->prefix('asdos')->name('asdos.')->group(function () {
        // Dashboard Asdos
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Kelas
        Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
        Route::get('/kelas/create', [KelasController::class, 'create'])->name('kelas.create');
        Route::post('/kelas', [KelasController::class, 'store'])->name('kelas.store');
        Route::get('/kelas/{id}/edit', [KelasController::class, 'edit'])->name('kelas.edit');
        Route::put('/kelas/{id}', [KelasController::class, 'update'])->name('kelas.update');
        Route::delete('/kelas/{id}', [KelasController::class, 'destroy'])->name('kelas.destroy');

        // Modul
        Route::get('/kelas/{kelasId}/modul', [ModulController::class, 'index'])->name('modul.index');
        Route::get('/kelas/{kelasId}/modul/create', [ModulController::class, 'create'])->name('modul.create');
        Route::post('/kelas/{kelasId}/modul', [ModulController::class, 'store'])->name('modul.store');
        Route::get('/kelas/{kelasId}/modul/{modulId}/edit', [ModulController::class, 'edit'])->name('modul.edit');
        Route::put('/kelas/{kelasId}/modul/{modulId}', [ModulController::class, 'update'])->name('modul.update');
        Route::delete('/kelas/{kelasId}/modul/{modulId}', [ModulController::class, 'destroy'])->name('modul.destroy');

        // Submission Review
        Route::get('/submissions/waiting', [SubmissionReviewController::class, 'waiting'])->name('submissions.waiting');
        Route::get('/submissions/history', [SubmissionReviewController::class, 'history'])->name('submissions.history');
        Route::get('/submissions/review/{id}', [SubmissionReviewController::class, 'reviewForm'])->name('submissions.reviewForm');
        Route::post('/submissions/review/{id}', [SubmissionReviewController::class, 'review'])->name('submissions.review');
        Route::delete('/submissions/{id}', [SubmissionReviewController::class, 'destroy'])->name('submissions.destroy');
    });
});
