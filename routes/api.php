<?php

use App\Http\Controllers\MainController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/produk/{spek}/{value}', [MainController::class, 'filter_product'])->name('filter_product');
Route::post('/produk-filter/kapasitas_cc', [MainController::class, 'filter_kapasitas_cc'])->name('filter_kapasitas_cc');
Route::post('/produk-filter/kapasitas_seater', [MainController::class, 'filter_kapasitas_seater'])->name('filter_kapasitas_seater');
Route::get('/produk-filter/byid/{id}', [MainController::class, 'filter_product_byID'])->name('filter_product_byID');
