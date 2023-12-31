<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\PostController;
use App\Http\Controllers\KendaraanController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Route::get('/kendaraan/stok', [KendaraanController::class, 'getStok'])->name('kendaraan.stok');

Route::middleware('api')->group(function () {
    // Rute yang memerlukan pengisian header API-key
    Route::get('/kendaraan/stok-dan-kendaraan', [KendaraanController::class, 'getStokDanKendaraanByPage'])->name('kendaraan.stok-dan-kendaraan'); 
    Route::put('/kendaraan/{id}/terjual', [KendaraanController::class, 'updateTerjual'])->name('kendaraan.update-terjual');
    Route::get('/kendaraan/terjual/{jenis}', [KendaraanController::class, 'getTerjualKendaraanByPage'])->name('kendaraan.terjual-jenis');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('posts', PostController::class)->only([
    'destroy', 'show', 'store', 'update'
]);
