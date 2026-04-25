<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StemController;
use App\Http\Controllers\Api\UploadController;
use App\Http\Controllers\UserController;


// Public library API
Route::middleware(['web'])->group(function () {
Route::get('/stems', [StemController::class, 'index']);
Route::get('/stems/{id}', [StemController::class, 'show']);
Route::get('/stems/{id}/preview', [StemController::class, 'preview']);

// Protected download (requires auth check but accessible via token)
Route::get('/stems/{id}/download', [StemController::class, 'download']);

});

// Upload endpoints
Route::post('/upload/single', [UploadController::class, 'uploadSingle']);
Route::post('/upload/bulk', [UploadController::class, 'uploadBulk']);
Route::middleware('auth:sanctum')->post('/user/update-email', [UserController::class, 'updateEmail']);
    Route::get('/stems/bulk-download', [StemController::class, 'bulkDownload'])->name('stems.bulk-download');
Route::middleware('auth:sanctum')->post('/user/update-email', [UserController::class, 'updateEmail']);

