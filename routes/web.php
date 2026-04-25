<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\FileManagerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VaultController;
use App\Http\Controllers\Admin\VaultAdminController;

// Public routes
Route::get('/', function () {
    return view('layouts.app');
})->name('home');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ============================================================
// HIDDEN ADMIN ROUTES (not accessible from public navigation)
// ============================================================
// IMPORTANT: Ye route public navigation mein nahi dikhega
// Admin API routes (add these inside admin group)
Route::prefix(env('ADMIN_SECRET_PREFIX', 'manage-panel-x9k'))->middleware(['auth', 'admin'])->name('admin.')->group(function () {
        
    
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        // API endpoints
        Route::prefix('api')->group(function () {
            // Stats
            Route::get('/stats', [AdminController::class, 'stats']);
            
            // Stems
            Route::get('/stems', [AdminController::class, 'stems']);
            Route::get('/stems/{stem}', [AdminController::class, 'getStem']);
            Route::put('/stems/{stem}', [AdminController::class, 'updateStem']);
            Route::post('/stems/{stem}/toggle-visibility', [AdminController::class, 'toggleVisibility']);
            Route::post('/stems/bulk-visibility', [AdminController::class, 'bulkVisibility']);
            Route::post('/stems/bulk-delete', [AdminController::class, 'bulkDelete']);
            
            // Customers
            Route::get('/customers', [AdminController::class, 'customers']);
              // ⚠️  import-csv MUST be before /customers/{id}
             Route::post('/customers/import-csv',[AdminController::class, 'importCsv']);
            Route::get('/customers/{id}', [AdminController::class, 'getUser']);
            Route::post('/customers/{user}/status', [AdminController::class, 'updateUserStatus']);
            Route::post('/customers/{user}/tier', [AdminController::class, 'updateUserTier']);
            Route::post('/customers/{user}/reset-password', [AdminController::class, 'resetUserPassword']);
                Route::put('/customers/{user}', [AdminController::class, 'updateUser']);  // ✅ ADD THIS LINE
                Route::delete('/customers/{user}', [AdminController::class, 'deleteUser']);

            
            // Email
            Route::post('/email/send', [AdminController::class, 'sendEmail']);
            Route::get('/email/jobs', [AdminController::class, 'emailJobs']);
            
            // Audit logs
            Route::get('/audit-logs', [AdminController::class, 'auditLogs']);
            
            // Downloads report
            Route::get('/downloads-report', [AdminController::class, 'downloadsReport']);

                // File Manager Routes
         // File Manager Routes
            Route::get('/files', [FileManagerController::class, 'index']);
            Route::post('/files/folder', [FileManagerController::class, 'createFolder']);
            Route::delete('/files/folder', [FileManagerController::class, 'deleteFolder']);
            Route::post('/files/move', [FileManagerController::class, 'moveFile']);
            Route::post('/files/organize', [FileManagerController::class, 'organize']);
            Route::delete('/files', [FileManagerController::class, 'delete']);
            Route::post('/files/bulk-delete', [FileManagerController::class, 'bulkDelete']);
            Route::get('/files/{filename}/download', [FileManagerController::class, 'download']);
            Route::post('/files/upload', [FileManagerController::class, 'upload']);

            Route::prefix('vault')->group(function () {
            Route::get('genres',              [VaultAdminController::class, 'index']);
            Route::put ('genres/{genreId}',    [VaultAdminController::class, 'update']);
            Route::post ('genres/{genreId}/toggle', [VaultAdminController::class, 'toggleVisibility']);
            Route::get('genres/meta', [VaultAdminController::class, 'meta']);
                });
        });


    });

            // Payment routes
        Route::middleware(['auth'])->group(function () {
            Route::post('/checkout/{tier}', [PaymentController::class, 'checkout'])->name('checkout');
            Route::post('/subscribe/free', [PaymentController::class, 'subscribeFree'])->name('subscribe.free');
            Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
            Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
            Route::post('/api/user/update-email', [UserController::class, 'updateEmail']);
            Route::post('/api/user/change-password', [UserController::class, 'changePassword']);
            Route::delete('/api/user/delete-account', [UserController::class, 'deleteAccount']);
              Route::get('/vault', [VaultController::class, 'index'])->name('vault');
    Route::get('/vault/download/{genre}', [VaultController::class, 'downloadByGenre'])->name('vault.download');
    Route::get('/api/vault/genres', [VaultController::class, 'getGenreStats']);

      Route::get('/checkout-page', function () {
        return view('pages.checkout');
    })->name('checkout.page');
        });

        

        // Webhook (no auth needed)
        Route::post('/stripe/webhook', [PaymentController::class, 'webhook'])->name('stripe.webhook');
        Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

    Route::get('/test-mail-config', function () {
    // Check config values
    $config = [
        'driver' => config('mail.default'),
        'host' => config('mail.mailers.smtp.host'),
        'port' => config('mail.mailers.smtp.port'),
        'username' => config('mail.mailers.smtp.username'),
        'password' => config('mail.mailers.smtp.password') ? 'SET' : 'NOT SET',
        'from' => config('mail.from.address'),
    ];
    
    return response()->json($config);
});