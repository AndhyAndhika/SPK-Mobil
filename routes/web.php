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
Route::post('/login/checking', [MainController::class, 'login_checking'])->name('login_checking');
// Route::post('/login/destroying', [MainController::class, 'login_destroying'])->name('login_destroying');

Route::get('/dt-hasilsurvei', [MainController::class, 'dt_hasilsurvei'])->name('dt_hasilsurvei');
Route::get('/dt-allproduct', [MainController::class, 'dt_allproduct'])->name('dt_allproduct');

Route::get('/download/survey', [MainController::class, 'dw_survey'])->name('dt_survey');

// Route::get('/rekomendasi', [MainController::class, 'rekomendasi'])->name('rekomendasi');
// Route::post('/rekomendasi/simpan', [MainController::class, 'rekomendasi_simpan'])->name('rekomendasi_simpan');

// public function simpanEdit(Request $request, $id)
// {
//     $data = Kelas::where('_id', $id)->first();

//     $update = $data->update([
//         ['nama' => $datas['nama']]
//     ]);
// }
Route::group(['middleware' => ['auth', 'CekLevel:supervisor,sales']], function () {
    Route::get('/dashboard', [MainController::class, 'dashboard'])->name('dashboard');
    Route::post('/login/destroying', [MainController::class, 'login_destroying'])->name('login_destroying');
    Route::post('/save-product', [MainController::class, 'save_product'])->name('save_product');
    Route::post('/update-product', [MainController::class, 'update_product'])->name('update_product');
    Route::post('/delete-product', [MainController::class, 'delete_product'])->name('delete_product');

    Route::post('/update-kriteria-product', [MainController::class, 'update_kriteria_product'])->name('update_kriteria_product');
});
// Route::group(['middleware' => ['auth', 'CekLevel:sales']], function () {
//     Route::post('/login/destroying', [MainController::class, 'login_destroying'])->name('login_destroying');
// });
