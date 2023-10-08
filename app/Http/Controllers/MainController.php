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
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

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
    function getColumnRange()
    {
        $columnRange = [];
        $letters = range('A', 'Z');

        foreach ($letters as $letter) {
            $columnRange[] = $letter;
        }

        foreach ($letters as $firstLetter) {
            foreach ($letters as $secondLetter) {
                $columnRange[] = $firstLetter . $secondLetter;
            }
        }

        foreach ($letters as $firstLetter) {
            foreach ($letters as $secondLetter) {
                foreach ($letters as $thirdLetter) {
                    $columnRange[] = $firstLetter . $secondLetter . $thirdLetter;
                }
            }
        }

        return $columnRange;
    }

    // for excel export
    public function getLastColumn($last)
    { //last represent how mouch X axis spaces
        return Coordinate::stringFromColumnIndex($last);
    }

    public function dw_survey()
    {
        ini_set('memory_limit', '-1');

        // Ambil Data
        $data = Survey::all();


        // Judul Dalam File Excel
        $fileName = "DATA SURVEI";

        // Menentukan Header Pada File Excel
        $columns = [
            "#",
            "NAMA CUSTOMER",
            "NO HP CUSTOMER",
            "K1",
            "K2",
            "K3",
            "K4",
            "K5",
            "K6",
            "K7",
            "K8",
            "K9",
            "K10",
            "K11",
            "K12",
            "K13",
            "Total Nilai",
            "Hasil Rekomendasi",
            "Dibuat",
            "Dirubah"
        ];

        // Menentukan jumlah baris gap antara judul dengan header
        $row_gap = 1;

        // Sytyling pada Title
        $title_style = [
            'font'  => [
                'bold'  => true,
                'size'  => 19,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        ];

        $excelColumns = $this->getColumnRange();
        $columns_count = count($columns) - 1;

        // Buat Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet()->setTitle('Sheet1');

        // Buat Isi dari Excel Disini
        try {
            $col = 1;
            $row = 1;
            // Set Judul
            $sheet->setCellValue($this->getLastColumn($col) . $row, $fileName);
            $sheet->getStyle($this->getLastColumn($col) . $row)->applyFromArray($title_style);
            $row++;

            // merge title cell
            $sheet->mergeCells("A1:{$excelColumns[$columns_count]}1");

            // Set Header
            $row += $row_gap;
            foreach ($columns as $column) {
                $sheet->setCellValue($this->getLastColumn($col) . $row, $column);
                $sheet->getStyle($this->getLastColumn($col) . $row)->getFont()->setBold(true);
                $col++;
            }

            $row++;

            // Set Value
            foreach ($data as $key => $item) {
                $col = 1;
                $sheet->setCellValue($this->getLastColumn($col) . $row, $key + 1);
                $col++;
                $sheet->setCellValue($this->getLastColumn($col) . $row, $item->name);
                $col++;
                $sheet->setCellValue($this->getLastColumn($col) . $row, $item->no_telp);
                $col++;
                $sheet->setCellValue($this->getLastColumn($col) . $row, $item->K1);
                $col++;
                $sheet->setCellValue($this->getLastColumn($col) . $row, $item->K2);
                $col++;
                $sheet->setCellValue($this->getLastColumn($col) . $row, $item->K3);
                $col++;
                $sheet->setCellValue($this->getLastColumn($col) . $row, $item->K4);
                $col++;
                $sheet->setCellValue($this->getLastColumn($col) . $row, $item->K5);
                $col++;
                $sheet->setCellValue($this->getLastColumn($col) . $row, $item->K6);
                $col++;
                $sheet->setCellValue($this->getLastColumn($col) . $row, $item->K7);
                $col++;
                $sheet->setCellValue($this->getLastColumn($col) . $row, $item->K8);
                $col++;
                $sheet->setCellValue($this->getLastColumn($col) . $row, $item->K9);
                $col++;
                $sheet->setCellValue($this->getLastColumn($col) . $row, $item->K10);
                $col++;
                $sheet->setCellValue($this->getLastColumn($col) . $row, $item->K11);
                $col++;
                $sheet->setCellValue($this->getLastColumn($col) . $row, $item->K12);
                $col++;
                $sheet->setCellValue($this->getLastColumn($col) . $row, $item->K13);
                $col++;
                $sheet->setCellValue($this->getLastColumn($col) . $row, $item->total_nilai);
                $col++;
                $sheet->setCellValue($this->getLastColumn($col) . $row, $item->hasil);
                $col++;
                $sheet->setCellValue($this->getLastColumn($col) . $row, $item->created_at);
                $col++;
                $sheet->setCellValue($this->getLastColumn($col) . $row, $item->updated_at);
                $col++;
                $row++;
            }
            // autosize columns width
            foreach ($sheet->getColumnIterator() as $column) {
                $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
            }
        } catch (\Exception $e) {
            dd($e);
        }

        // Save Template
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '.xlsx' . '"');
        $writer->save('php://output');

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
