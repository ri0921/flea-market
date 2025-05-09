<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\CheckoutController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [ItemController::class, 'index']);
Route::get('/item/{item}', [ItemController::class, 'show']);
Route::get('/search', [ItemController::class, 'search']);

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/mypage/profile', [ProfileController::class, 'edit']);
    Route::post('/mypage/profile', [ProfileController::class, 'update']);
    Route::get('/item/{item}/like', [ItemController::class, 'like']);
    Route::get('/item/{item}/unlike', [ItemController::class, 'unlike']);
    Route::post('/item/{item}', [ItemController::class, 'comment']);
    Route::get('/purchase/{item}', [PurchaseController::class, 'purchase']);
    Route::get('/purchase/address/{item}', [PurchaseController::class, 'edit']);
    Route::post('/purchase/address/{item}', [PurchaseController::class, 'update']);
    Route::post('/purchase/{item}', [PurchaseController::class, 'store']);
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
    Route::get('/sell', [ItemController::class, 'exhibit']);
    Route::post('/sell', [ItemController::class, 'store']);
    Route::get('/mypage', [ProfileController::class, 'mypage']);
});