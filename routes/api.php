<?php
use App\Http\Controllers\Api\DocumentController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::get('/documents', [DocumentController::class, 'index']);
    Route::get('/document/{id}', [DocumentController::class, 'show']);
    Route::post('/documents', [DocumentController::class, 'store']);
    Route::patch('/document/{id}', [DocumentController::class, 'update']);
});