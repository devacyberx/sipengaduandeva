<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Import controller
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (Login & Logout)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login'); // tampil form login
Route::post('/login', [AuthController::class, 'login']); // proses login
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // logout

/*
|--------------------------------------------------------------------------
| REGISTER ROUTES (Hanya untuk guest)
|--------------------------------------------------------------------------
*/
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
    ->middleware('guest') // hanya user belum login
    ->name('register');

Route::post('/register', [RegisterController::class, 'register'])
    ->middleware('guest');

/*
|--------------------------------------------------------------------------
| THEME (Dark / Light Mode)
|--------------------------------------------------------------------------
*/
Route::post('/theme', function (Request $request) {

    // Validasi input theme
    $request->validate([
        'theme' => 'required|in:light,dark'
    ]);

    // Simpan ke session
    session(['theme' => $request->theme]);

    // Return JSON (biasanya AJAX)
    return response()->json([
        'success' => true,
        'message' => 'Theme berhasil diubah',
        'theme' => $request->theme
    ]);
})->middleware('auth')->name('theme.set');

/*
|--------------------------------------------------------------------------
| HOME REDIRECT (Cek Role)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {

    // Jika sudah login
    if (auth()->check()) {

        // Jika admin → dashboard admin
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // Jika siswa → dashboard siswa
        return redirect()->route('siswa.dashboard');
    }

    // Jika belum login → login
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (Harus login + role admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin']) // proteksi route
    ->prefix('admin') // URL diawali /admin
    ->name('admin.')  // nama route diawali admin.
    ->group(function () {

        // Dashboard admin
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])
            ->name('dashboard');

        // ======================
        // COMPLAINTS
        // ======================
        Route::get('/complaints', [ComplaintController::class, 'adminIndex'])
            ->name('complaints.index');

        Route::get('/complaints/{complaint}', [ComplaintController::class, 'adminShow'])
            ->name('complaints.show');

        Route::put('/complaints/{complaint}/status', [ComplaintController::class, 'updateStatus'])
            ->name('complaints.status');

        Route::post('/complaints/{complaint}/feedback', [ComplaintController::class, 'addFeedback'])
            ->name('complaints.feedback');

        Route::post('/complaints/{complaint}/fix-photo', [ComplaintController::class, 'uploadFixPhoto'])
            ->name('complaints.fix-photo');

        // ======================
        // CATEGORY (CRUD)
        // ======================
        Route::resource('categories', CategoryController::class); 
        // otomatis create, store, edit, update, destroy

        // ======================
        // USER (CRUD)
        // ======================
        Route::resource('users', UserController::class);

        // Reset password user
        Route::put('/users/{user}/reset-password', [UserController::class, 'resetPassword'])
            ->name('users.reset-password');

        // ======================
        // REPORT
        // ======================
        Route::get('/reports', [ReportController::class, 'index'])
            ->name('reports.index');

        Route::get('/reports/print', [ReportController::class, 'print'])
            ->name('reports.print');

        Route::get('/reports/download', [ReportController::class, 'downloadPdf'])
            ->name('reports.download');

        // ======================
        // PROFILE ADMIN
        // ======================
        Route::get('/settings/profile', [ProfileController::class, 'adminProfile'])
            ->name('settings.profile');

        Route::put('/settings/profile', [ProfileController::class, 'updateAdminProfile'])
            ->name('settings.profile.update');

        Route::put('/settings/password', [ProfileController::class, 'changeAdminPassword'])
            ->name('settings.password');

        // Theme admin
        Route::post('/settings/theme', [ProfileController::class, 'updateTheme'])
            ->name('settings.theme');
    });

/*
|--------------------------------------------------------------------------
| SISWA ROUTES (Login + role siswa)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {

        // Dashboard siswa
        Route::get('/dashboard', [DashboardController::class, 'siswaDashboard'])
            ->name('dashboard');

        // ======================
        // COMPLAINT (CRUD)
        // ======================
        Route::get('/complaints', [ComplaintController::class, 'siswaIndex'])
            ->name('complaints.index');

        Route::get('/complaints/create', [ComplaintController::class, 'create'])
            ->name('complaints.create');

        Route::post('/complaints', [ComplaintController::class, 'store'])
            ->name('complaints.store');

        Route::get('/complaints/{complaint}', [ComplaintController::class, 'siswaShow'])
            ->name('complaints.show');

        // ======================
        // HISTORY
        // ======================
        Route::get('/history', [ComplaintController::class, 'history'])
            ->name('history.index');

        // ======================
        // PROFILE SISWA
        // ======================
        Route::get('/profile', [ProfileController::class, 'siswaProfile'])
            ->name('profile.index');

        Route::put('/profile', [ProfileController::class, 'updateSiswaProfile'])
            ->name('profile.update');

        Route::put('/profile/password', [ProfileController::class, 'changeSiswaPassword'])
            ->name('profile.password');

        // Theme siswa
        Route::post('/profile/theme', [ProfileController::class, 'updateTheme'])
            ->name('profile.theme');
    });

/*
|--------------------------------------------------------------------------
| FALLBACK (ERROR 404)
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});