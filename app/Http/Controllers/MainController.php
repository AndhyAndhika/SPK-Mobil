<?php

namespace App\Http\Controllers;

use App\Models\Pertanyaan;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use RealRashid\SweetAlert\Facades\Alert;

class MainController extends Controller
{
    public function login() //handle tampilan login.
    {
        return view('login');
    }

    public function index() //handle tampilan dashboard.
    {
        $data = Pertanyaan::whereNotIn('id', [0])->get(); //Ambil semua pertanyaan kecuali yang berID = 3
        $Products = Product::GroupBy('nama')->get('nama');
        // $image = url('/UIUX/IMG/ayla.webp');
        // Alert::image('<i class="fs-5"> KAMI MEREKOMENDASIKAN </i> <br> <b>DAIHATSU AYLA</b>', '', "$image", 'Image Width', 'Image Height', 'Image Alt');
        return view('dashboard', compact('data', 'Products'));
    }

    public function just_our_product() //handle jika routing hanya '/our-product' aja.
    {
        return redirect()->route('index');
    }

    public function specific_product($nama) //menampilkan salah satu produk yang di klik pada dashboard.
    {
        $data = Product::where('nama', $nama)->get(); //query utuk ambil data berdasarkan $nama yang diparsing routing.
        return view('detail-product', compact('data', 'nama'));
    }

    public function save_rekomendasi(Request $request) //handle post dari form 'bantu kami' di dashboard
    {
        dd($request);
        return redirect()->route('index')->with('berhasil', 'berhasil');
    }

    // public function rekomendasi()
    // {
    //     $data = Pertanyaan::whereNotIn('id', [1])->get();
    //     $Products = Product::GroupBy('namaa')->get('nama');
    //     return view('rekomendasi', compact('data', 'Products'));
    // }

    // public function rekomendasi_simpan(Request $request)
    // {
    //     dd($request);
    // }

    //====================['HANDLE API FROM api.php']====================//

    public function filter_product($spek, $value)
    {
        $data = Product::whereBetween('kapasitas_cc', [1197, 1198])
            ->where('kapasitas_orang', 5)
            ->get();
        return ApiFormatter::createAPi('200', 'Berhsil', $data);
    }

    public function filter_kapasitas_cc(Request $request)
    {
        $dataArray = explode(", ", $request->raw_kapasitas_mesin);
        if ($dataArray[1] != null && $dataArray[2] != null) {
            $data = Product::whereBetween('kapasitas_cc', [$dataArray[1], $dataArray[2]])->GroupBy('kapasitas_orang')->orderBy('kapasitas_orang', 'asc')->get('kapasitas_orang');
            return ApiFormatter::createAPi('200', 'Berhasil', $data);
        } else {
            return ApiFormatter::createAPi('400', 'Gagal');
        }
        return ApiFormatter::createAPi('400', 'Gagal');
    }

    public function filter_kapasitas_seater(Request $request)
    {
        $dataArray = explode(", ", $request->raw_kapasitas_mesin);
        if ($dataArray[1] != null && $dataArray[2] != null && $request->raw_kapasitas_seat != null) {
            $data = Product::whereBetween('kapasitas_cc', [$dataArray[1], $dataArray[2]])
                ->where('kapasitas_orang', $request->raw_kapasitas_seat)
                ->GroupBy('nama')
                ->get();
            return ApiFormatter::createAPi('200', 'Berhasil', $data);
        } else {
            return ApiFormatter::createAPi('400', 'Gagal');
        }
        return ApiFormatter::createAPi('400', 'Gagal');
    }
}
