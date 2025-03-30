<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;

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
Route::get('/item/:{item}', [ItemController::class, 'show']);
Route::get('/search', [ItemController::class, 'search']);

Route::middleware('auth')->group(function () {
    Route::get('/mypage/profile', [ProfileController::class, 'index']);
    Route::post('/mypage/profile', [ProfileController::class, 'store']);
    Route::get('/item/:{item}/like', [ItemController::class, 'like']);
    Route::get('/item/:{item}/unlike', [ItemController::class, 'unlike']);

    Route::get('/mypage', [ProfileController::class, 'mypage']);
    Route::get('/sell', [ItemController::class, 'exhibit']);
    Route::get('/purchase', [PurchaseController::class, 'purchase']);
    Route::get('/mypage/profile', [ProfileController::class, 'edit']);
    Route::get('/purchase/address', [PurchaseController::class, 'edit']);
});