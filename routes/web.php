<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\CustomerController;

// ================= CUSTOMER =================
Route::get('/', [MenuController::class,'index']);
Route::get('/menu', [MenuController::class, 'index']);

Route::post('/pesan',[PesananController::class,'store']);

// 🔥 cukup 1 bayar (GET)
Route::get('/bayar/{id}', [PaymentController::class, 'pay']);

// ================= MIDTRANS =================
Route::post('/midtrans/callback', [PaymentController::class, 'callback']);

// ================= SUCCESS QR =================
Route::get('/payment/success/{id}', [PaymentController::class, 'success']);


// ================= VENDOR =================
Route::get('/vendor', [VendorController::class,'index']);
Route::get('/vendor/menu', [VendorController::class,'menu']);
Route::post('/vendor/menu/store', [VendorController::class,'storeMenu']);
Route::get('/vendor/pesanan', [VendorController::class,'pesanan']);

// halaman scanner
Route::get('/scan', [ScanController::class, 'index']);

// ambil data dari QR
Route::get('/scan/{id}', [ScanController::class, 'getPesanan']);

Route::get('/customer', [CustomerController::class, 'index']);
Route::get('/customer/create', [CustomerController::class, 'create']);
Route::post('/customer/store', [CustomerController::class, 'store']);

Route::get('/customer/create2', [CustomerController::class, 'create2']);
Route::post('/customer/store2', [CustomerController::class, 'store2']);

Route::get('/vendor/antrian',[VendorController::class, 'antrian'])->name('vendor.antrian');
Route::post('/vendor/panggil/{id}', [VendorController::class, 'panggil']);

Route::post('/vendor/selesai/{id}', [VendorController::class, 'selesai']);

Route::post('/vendor/terlambat/{id}', [VendorController::class, 'terlambat']);
Route::get(
    '/papan-antrian',
    [VendorController::class, 'papan']
);

Route::get(
    '/vendor/papan',
    [VendorController::class, 'papan']
);
Route::get(
    '/api/antrian-terbaru',
    [VendorController::class, 'antrianTerbaru']
);

Route::get(
    '/stream-antrian',
    [VendorController::class, 'stream']
);

