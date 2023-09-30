<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [MainController::class, 'index'])->name('index');
Route::get('/our-product', [MainController::class, 'just_our_product'])->name('our_product');
Route::get('/our-product/{nama}', [MainController::class, 'specific_product'])->name('specific_product');
Route::post('/save-rekomendasi', [MainController::class, 'save_rekomendasi'])->name('save_rekomendasi');

Route::get('/login', [MainController::class, 'login'])->name('login');

// Route::get('/rekomendasi', [MainController::class, 'rekomendasi'])->name('rekomendasi');
// Route::post('/rekomendasi/simpan', [MainController::class, 'rekomendasi_simpan'])->name('rekomendasi_simpan');

// public function simpanEdit(Request $request, $id)
// {
//     $data = Kelas::where('_id', $id)->first();

//     $update = $data->update([
//         ['nama' => $datas['nama']]
//     ]);
// }
