<?php

namespace App\Http\Controllers;

use App\Models\Pertanyaan;
use App\Models\Product;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MainController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function index()
    {
        $data = Pertanyaan::whereNotIn('id', [1])->get();
        $Products = Product::GroupBy('nama')->get('nama');
        $image = url('/UIUX/IMG/ayla.webp');
        Alert::image('<i class="fs-5"> KAMI MEREKOMENDASIKAN </i> <br> <b>DAIHATSU AYLA</b>', '', "$image", 'Image Width', 'Image Height', 'Image Alt');
        return view('dashboard', compact('data', 'Products'));
    }

    public function save_rekomendasi(Request $request)
    {

        return redirect()->route('index')->with('berhasil', 'berhasil');
    }

    public function just_our_product()
    {
        return redirect()->route('index');
    }

    public function our_product($nama)
    {
        $data = Product::where('nama', $nama)->get();
        return view('detail-product', compact('data', 'nama'));
    }

    public function rekomendasi()
    {
        $data = Pertanyaan::whereNotIn('id', [1])->get();
        $Products = Product::GroupBy('namaa')->get('nama');
        return view('rekomendasi', compact('data', 'Products'));
    }

    public function rekomendasi_simpan(Request $request)
    {
        dd($request);
    }
}
