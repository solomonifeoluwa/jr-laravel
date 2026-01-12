<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\SecretController;

Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});

Route::prefix('v1')->group(function () {
    Route::post('/secrets', [SecretController::class, 'store'])
        ->middleware('throttle:10,1'); // Rate limiting

    Route::get('/secrets/{id}', [SecretController::class, 'show']);
});
