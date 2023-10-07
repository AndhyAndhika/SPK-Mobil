<?php

namespace App\Http\Controllers;

use App\Exports\SurveyExport;
use App\Models\Survey;
use App\Models\Product;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{
    public function login() //handle tampilan login.
    {
        if (Auth::check() == true) {
            return redirect()->route('dashboard');
        } else {
            return view('login');
        }
    }

    public function index() //handle tampilan landing-page.
    {
        $data = Pertanyaan::whereNotIn('id', [0])->get(); //Ambil semua pertanyaan kecuali yang berID = 3
        $Products = Product::GroupBy('nama')->get('nama');
        // $image = url('/UIUX/IMG/ayla.webp');
        // Alert::image('<i class="fs-5"> KAMI MEREKOMENDASIKAN </i> <br> <b>DAIHATSU AYLA</b>', '', "$image", 'Image Width', 'Image Height', 'Image Alt');
        return view('landing-page', compact('data', 'Products'));
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
        // dd($request);
        $validator = Validator::make($request->all(), [
            "nama_anda" => 'required',
            "no_telp" => 'required',
            "kapasitas_mesin" => 'required',
            "kapasitas_penumpang" => 'required',
            "id_tipe_mobil" => 'required|array|size:2',
            "keamanan_dalam_berkendara" => 'required',
            "interior_mobil" => 'required',
            "dimensi_mobil" => 'required',
            "jumlah_keinginan_eksterior" => 'required',
            "jumlah_keinginan_fitur_tambahan" => 'required',
            "warna_mobil" => 'required',
            "jenis_velg" => 'required',
            "harga_mobil" => 'required',
            "sumber_pendapatan" => 'required',
            "lokasi_tinggal" => 'required',
            "kepemilikan_kendaraan" => 'required',
        ]);

        if ($validator->fails()) {
            Alert::toast('Harap Mengisi Form Dengan Lengkap', 'error');
            return redirect()->route('index');
        }
        Alert::toast('Terjadi Error.! Hubungi Team Program', 'error');
        return redirect()->route('index');
    }

    //====================['HANDLE DASHBOARD AFTER LOGIN PAGE']====================//

    public function dashboard()
    {
        $data = "";
        $Products = Product::all();
        return view('dashboard', compact('data', 'Products'));
    }

    //====================['HANDLE YAJRA']====================//

    public function dt_hasilsurvei(Request $request)
    {
        if ($request->ajax()) {
            $data = Survey::all();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = '<a class="btn fa-solid fa-pen-to-square fa-lg text-warning" onclick="EditReject(' . $data->id . ')"></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function dt_allproduct(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::all();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = '<a class="btn fa-solid fa-pen-to-square fa-lg text-warning" onclick="EditReject(' . $data->id . ')"></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    //====================['HANDLE DOWNLOAD']====================//
    public function dw_survey()
    {
        return Excel::download(new SurveyExport, 'HasilSurvey.xlsx');
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
                // ->GroupBy('nama')
                ->get();
            return ApiFormatter::createAPi('200', 'Berhasil', $data);
        } else {
            return ApiFormatter::createAPi('400', 'Gagal');
        }
        return ApiFormatter::createAPi('400', 'Gagal');
    }

    //====================['HANDLE LOGIN']====================//
    public function login_checking(Request $request)
    {
        $credentials =  $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $message = "Login successfully, Hello " . Auth::user()->name;
            Alert::toast($message, 'success');
            return redirect()->route('dashboard');
        } else {
            Alert::toast('Role is not defined!', 'error');
            return back();
        }
        return redirect()->route('login');
    }
    public function login_destroying(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        Alert::toast('Berhasil Logout, Have A Good Day.', 'info');
        return redirect('/');
    }
}
