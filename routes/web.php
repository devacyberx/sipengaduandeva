<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
| Auth Routes (Tanpa Middleware)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Register Routes (Guest Only)
|--------------------------------------------------------------------------
*/
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [RegisterController::class, 'register'])
    ->middleware('guest');

/*
|--------------------------------------------------------------------------
| Theme/Dark Mode Routes (Authenticated Only)
|--------------------------------------------------------------------------
*/
Route::post('/theme', function (Request $request) {
    $request->validate([
        'theme' => 'required|in:light,dark'
    ]);

    session(['theme' => $request->theme]);

    return response()->json([
        'success' => true
    ]);
})->middleware('auth')->name('theme.set');

/*
|--------------------------------------------------------------------------
| Home Redirect (Based on Role)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('siswa.dashboard');
    }

    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Auth + Admin Middleware)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])
            ->name('dashboard');

        // Complaints Management
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

        // Categories Management (CRUD)
        Route::resource('categories', CategoryController::class);

        // Users Management (CRUD)
        Route::resource('users', UserController::class);
        
        // Additional User Routes
        Route::put('/users/{user}/reset-password', [UserController::class, 'resetPassword'])
            ->name('users.reset-password');

        // Reports
        Route::get('/reports', [ReportController::class, 'index'])
            ->name('reports.index');

        Route::get('/reports/print', [ReportController::class, 'print'])
            ->name('reports.print');

        Route::get('/reports/download', [ReportController::class, 'downloadPdf'])
            ->name('reports.download');

        // Settings & Profile
        Route::get('/settings/profile', [ProfileController::class, 'adminProfile'])
            ->name('settings.profile');

        Route::put('/settings/profile', [ProfileController::class, 'updateProfile']);

        Route::put('/settings/password', [ProfileController::class, 'changePassword'])
            ->name('settings.password');
    });

/*
|--------------------------------------------------------------------------
| Siswa Routes (Auth + Siswa Middleware)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'siswaDashboard'])
            ->name('dashboard');

        // My Complaints
        Route::get('/complaints', [ComplaintController::class, 'siswaIndex'])
            ->name('complaints.index');

        Route::get('/complaints/create', [ComplaintController::class, 'create'])
            ->name('complaints.create');

        Route::post('/complaints', [ComplaintController::class, 'store'])
            ->name('complaints.store');

        Route::get('/complaints/{complaint}', [ComplaintController::class, 'siswaShow'])
            ->name('complaints.show');

        // History
        Route::get('/history', [ComplaintController::class, 'history'])
            ->name('history.index');

        // Profile
        Route::get('/profile', [ProfileController::class, 'siswaProfile'])
            ->name('profile.index');

        Route::put('/profile', [ProfileController::class, 'updateProfile']);

        Route::put('/profile/password', [ProfileController::class, 'changePassword'])
            ->name('profile.password');
    });

/*
|--------------------------------------------------------------------------
| Fallback Route (404 Handling)
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});