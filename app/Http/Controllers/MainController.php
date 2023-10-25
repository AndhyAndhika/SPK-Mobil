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
    public function login() // handle tampilan login.
    {
        if (Auth::check() == true) {
            return redirect()->route('dashboard');
        } else {
            return view('login');
        }
    }

    public function index() // handle tampilan landing-page.
    {
        $data = Pertanyaan::whereNotIn('id', [0])->get(); //Ambil semua pertanyaan kecuali yang berID = 3
        $Products = Product::GroupBy('nama')->get('nama');
        return view('landing-page', compact('data', 'Products'));
    }

    public function just_our_product() // handle jika routing hanya '/our-product' aja.
    {
        return redirect()->route('index');
    }

    public function specific_product($nama) // menampilkan salah satu produk yang di klik pada dashboard.
    {
        $data = Product::where('nama', $nama)->get(); //query utuk ambil data berdasarkan $nama yang diparsing routing.
        return view('detail-product', compact('data', 'nama'));
    }

    public function save_rekomendasi(Request $request) // handle post dari form 'bantu kami' di dashboard
    {
        // 1. Validasi untuk Menentukan Kriteria dan Bobot yang datanya didapat dari customer
        $validator = Validator::make($request->all(), [
            "nama_anda" => 'required',
            "no_telp" => 'required',
            "kapasitas_mesin" => 'required', // K5
            "kapasitas_penumpang" => 'required', // K6
            "id_tipe_mobil" => 'required|array|size:2',
            "keamanan_dalam_berkendara" => 'required', // K7
            "interior_mobil" => 'required', // K8
            "dimensi_mobil" => 'required', // K9
            "jumlah_keinginan_eksterior" => 'required', // K11
            "jumlah_keinginan_fitur_tambahan" => 'required', // K10
            "warna_mobil" => 'required', // K12
            "jenis_velg" => 'required', // K13
            "harga_mobil" => 'required', // K4
            "sumber_pendapatan" => 'required', // K1
            "lokasi_tinggal" => 'required', // K2
            "kepemilikan_kendaraan" => 'required', // K3
        ]);

        // Validasi Jika Ada data yang tidak masuk
        if ($validator->fails()) {
            Alert::toast('Harap Mengisi Form Dengan Lengkap', 'error');
            return redirect()->route('index');
        }

        // Eksplode hasil dari Kapasitas mesin
        $kapasitasMesin = explode(
            ', ',
            $request->kapasitas_mesin
        );

        // Eksplode hasil dari Kapasitas mesin
        $kapasitasSeater = explode(
            ', ',
            $request->kapasitas_penumpang
        );

        // $totalNilai = K1 + K2 + K3 + K4 + K5 + K6...... + K13
        $totalNilai = $request->sumber_pendapatan + $request->lokasi_tinggal + $request->kepemilikan_kendaraan + $request->harga_mobil + $kapasitasMesin[0] + $kapasitasSeater[1] + $request->keamanan_dalam_berkendara + $request->interior_mobil + $request->dimensi_mobil + $request->jumlah_keinginan_fitur_tambahan + $request->jumlah_keinginan_eksterior + $request->warna_mobil + $request->jenis_velg;

        // 2. Masukan dalam rumus Perhitungan Relatif Bobot Awal (wj)
        $perhitunganRelatif = [
            "K1" =>   $request->sumber_pendapatan / $totalNilai,
            "K2" =>   $request->lokasi_tinggal / $totalNilai,
            "K3" =>   $request->kepemilikan_kendaraan / $totalNilai,
            "K4" =>   $request->harga_mobil / $totalNilai,
            "K5" =>   $kapasitasMesin[0] / $totalNilai,
            "K6" =>   $kapasitasSeater[1] / $totalNilai,
            "K7" =>   $request->keamanan_dalam_berkendara / $totalNilai,
            "K8" =>   $request->interior_mobil / $totalNilai,
            "K9" =>   $request->dimensi_mobil / $totalNilai,
            "K10" =>   $request->jumlah_keinginan_fitur_tambahan / $totalNilai,
            "K11" =>   $request->jumlah_keinginan_eksterior / $totalNilai,
            "K12" =>   $request->warna_mobil / $totalNilai,
            "K13" =>  $request->jenis_velg / $totalNilai
        ];

        // 3.Membuat Matriks Perbandingan Alternatif dari id_tipe_mobil
        $mobil = [];
        foreach ($request->id_tipe_mobil as $mobs) {
            $mobil[] = Product::find($mobs);
        }

        // 4. Menghitung Alternatif Nilai Vektor S
        $nilaiVektorS = [
            'Mobil1' => ($mobil[0]->kode_sumber_pendapatan ** $perhitunganRelatif['K1']) * ($mobil[0]->kode_lokasi_tinggal ** $perhitunganRelatif['K2']) * ($mobil[0]->kode_kepemilikan_kendaraan ** $perhitunganRelatif['K3']) * ($mobil[0]->kode_price ** $perhitunganRelatif['K4']) * ($mobil[0]->kode_kapasitas_cc ** $perhitunganRelatif['K5']) * ($mobil[0]->kode_kapasitas_orang ** $perhitunganRelatif['K6']) * ($mobil[0]->kode_safety ** $perhitunganRelatif['K7']) * ($mobil[0]->kode_interior ** $perhitunganRelatif['K8']) * ($mobil[0]->kode_dimensi ** $perhitunganRelatif['K9']) * ($mobil[0]->kode_fitur_tambahan ** $perhitunganRelatif['K10']) * ($mobil[0]->kode_eksterior ** $perhitunganRelatif['K11']) * ($mobil[0]->kode_warna_tersedia ** $perhitunganRelatif['K12']) * ($mobil[0]->kode_velg ** $perhitunganRelatif['K13']),

            'Mobil2' => ($mobil[1]->kode_sumber_pendapatan ** $perhitunganRelatif['K1']) * ($mobil[1]->kode_lokasi_tinggal ** $perhitunganRelatif['K2']) * ($mobil[1]->kode_kepemilikan_kendaraan ** $perhitunganRelatif['K3']) * ($mobil[1]->kode_price ** $perhitunganRelatif['K4']) * ($mobil[1]->kode_kapasitas_cc ** $perhitunganRelatif['K5']) * ($mobil[1]->kode_kapasitas_orang ** $perhitunganRelatif['K6']) * ($mobil[1]->kode_safety ** $perhitunganRelatif['K7']) * ($mobil[1]->kode_interior ** $perhitunganRelatif['K8']) * ($mobil[1]->kode_dimensi ** $perhitunganRelatif['K9']) * ($mobil[1]->kode_fitur_tambahan ** $perhitunganRelatif['K10']) * ($mobil[1]->kode_eksterior ** $perhitunganRelatif['K11']) * ($mobil[1]->kode_warna_tersedia ** $perhitunganRelatif['K12']) * ($mobil[1]->kode_velg ** $perhitunganRelatif['K13']),
        ];

        $JumlahVektorS = $nilaiVektorS['Mobil1'] + $nilaiVektorS['Mobil2'];

        // 5. Menghitung Nilai Prefrensi Relatif (Vektor V)
        $nilaiVektorV = [
            'mobilV1' => $nilaiVektorS['Mobil1'] / $JumlahVektorS,
            'mobilV2' => $nilaiVektorS['Mobil2'] / $JumlahVektorS
        ];

        // Mengurutkan array secara descending berdasarkan nilai
        arsort($nilaiVektorV);

        // Memberikan nilai tertinggi dari kedua array
        if ($nilaiVektorV['mobilV1'] > $nilaiVektorV['mobilV2']) {
            $rekomendasiMobil = $mobil[0]->id . " | " . $mobil[0]->nama . " - " . $mobil[0]->type;
            $gambar = '/UIUX/IMG/' . $mobil[0]->nama . '.webp';
            $namaMobil = $mobil[0]->nama . " - " . $mobil[0]->type;
        } else {
            $rekomendasiMobil = $mobil[1]->id . " | " . $mobil[1]->nama . " - " . $mobil[1]->type;
            $gambar = '/UIUX/IMG/' . $mobil[1]->nama . '.webp';
            $namaMobil = $mobil[1]->nama . " - " . $mobil[1]->type;
        }

        // Input Data ke Table Survei
        $insert = Survey::create([
            'name' => $request->nama_anda,
            'no_telp' => $request->no_telp,
            'K1' => $request->sumber_pendapatan,
            'K2' => $request->lokasi_tinggal,
            'K3' => $request->kepemilikan_kendaraan,
            'K4' => $request->harga_mobil,
            'K5' => $kapasitasMesin[0],
            'K6' => $kapasitasSeater[1],
            'K7' => $request->keamanan_dalam_berkendara,
            'K8' => $request->interior_mobil,
            'K9' => $request->dimensi_mobil,
            'K10' => $request->jumlah_keinginan_fitur_tambahan,
            'K11' => $request->jumlah_keinginan_eksterior,
            'K12' => $request->warna_mobil,
            'K13' => $request->jenis_velg,
            'total_nilai' =>  $totalNilai,
            'hasil' => $namaMobil,
        ]);

        if ($insert) {
            // Ambil gambar mobil
            $image = url($gambar);
            Alert::image('<i class="fs-5 text-uppercase"> KAMI MEREKOMENDASIKAN </i> <br> <b>DAIHATSU ' . $namaMobil . '</b>', '', "$image", 'Image Width', 'Image Height', 'Image Alt');
            return redirect()->route('index');
        }
        Alert::toast('Terdapat Error Pada Query', 'error');
        return redirect()->route('index');
    }

    public function save_product(Request $request) // handle post untuk nambah product
    {
        $validator = Validator::make($request->all(), [
            'kode' => 'required',
            'nama' => 'required',
            'type' => 'required',
            'price' => 'required',
            'kode_price' => 'required',
            'eksterior' => 'required',
            'kode_eksterior' => 'required',
            'kapasitas_cc' => 'required',
            'kode_kapasitas_cc' => 'required',
            'dimensi' => 'required',
            'kode_dimensi' => 'required',
            'kapasitas_orang' => 'required',
            'kode_kapasitas_orang' => 'required',
            'safety' => 'required',
            'kode_safety' => 'required',
            'interior' => 'required',
            'kode_interior' => 'required',
            'velg' => 'required',
            'kode_velg' => 'required',
            'fitur_tambahan' => 'required',
            'kode_fitur_tambahan' => 'required',
            'warna_tersedia' => 'required',
            'kode_warna_tersedia' => 'required',
            'kode_sumber_pendapatan' => 'required',
            'kode_lokasi_tinggal' => 'required',
            'kode_kepemilikan_kendaraan' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::toast('Terdapat Field Yang Kosong', 'error');
            return back();
        }

        $insert = Product::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'type' => $request->type,
            'price' => $request->price,
            'kode_price' => $request->kode_price,
            'eksterior' => $request->eksterior,
            'kode_eksterior' => $request->kode_eksterior,
            'kapasitas_cc' => $request->kapasitas_cc,
            'kode_kapasitas_cc' => $request->kode_kapasitas_cc,
            'dimensi' => $request->dimensi,
            'kode_dimensi' => $request->kode_dimensi,
            'kapasitas_orang' => $request->kapasitas_orang,
            'kode_kapasitas_orang' => $request->kode_kapasitas_orang,
            'safety' => $request->safety,
            'kode_safety' => $request->kode_safety,
            'interior' => $request->interior,
            'kode_interior' => $request->kode_interior,
            'velg' => $request->velg,
            'kode_velg' => $request->kode_velg,
            'fitur_tambahan' => $request->fitur_tambahan,
            'kode_fitur_tambahan' => $request->kode_fitur_tambahan,
            'warna_tersedia' => $request->warna_tersedia,
            'kode_warna_tersedia' => $request->kode_warna_tersedia,
            'kode_sumber_pendapatan' => $request->kode_sumber_pendapatan,
            'kode_lokasi_tinggal' => $request->kode_lokasi_tinggal,
            'kode_kepemilikan_kendaraan' => $request->kode_kepemilikan_kendaraan,
        ]);

        if ($insert) {
            Alert::toast('Input Data Berhasil', 'success');
            return redirect()->route('dashboard');
        }
        Alert::toast('Terdapat Error Pada Query', 'error');
        return back();
    }

    public function update_product(Request $request) // handle post untuk update product
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'kode' => 'required',
            'nama' => 'required',
            'type' => 'required',
            'price' => 'required',
            'kode_price' => 'required',
            'eksterior' => 'required',
            'kode_eksterior' => 'required',
            'kapasitas_cc' => 'required',
            'kode_kapasitas_cc' => 'required',
            'dimensi' => 'required',
            'kode_dimensi' => 'required',
            'kapasitas_orang' => 'required',
            'kode_kapasitas_orang' => 'required',
            'safety' => 'required',
            'kode_safety' => 'required',
            'interior' => 'required',
            'kode_interior' => 'required',
            'velg' => 'required',
            'kode_velg' => 'required',
            'fitur_tambahan' => 'required',
            'kode_fitur_tambahan' => 'required',
            'warna_tersedia' => 'required',
            'kode_warna_tersedia' => 'required',
            'kode_sumber_pendapatan' => 'required',
            'kode_lokasi_tinggal' => 'required',
            'kode_kepemilikan_kendaraan' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::toast('Terdapat Field Yang Kosong', 'error');
            return back();
        }

        $insert = Product::find($request->id)->update([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'type' => $request->type,
            'price' => $request->price,
            'kode_price' => $request->kode_price,
            'eksterior' => $request->eksterior,
            'kode_eksterior' => $request->kode_eksterior,
            'kapasitas_cc' => $request->kapasitas_cc,
            'kode_kapasitas_cc' => $request->kode_kapasitas_cc,
            'dimensi' => $request->dimensi,
            'kode_dimensi' => $request->kode_dimensi,
            'kapasitas_orang' => $request->kapasitas_orang,
            'kode_kapasitas_orang' => $request->kode_kapasitas_orang,
            'safety' => $request->safety,
            'kode_safety' => $request->kode_safety,
            'interior' => $request->interior,
            'kode_interior' => $request->kode_interior,
            'velg' => $request->velg,
            'kode_velg' => $request->kode_velg,
            'fitur_tambahan' => $request->fitur_tambahan,
            'kode_fitur_tambahan' => $request->kode_fitur_tambahan,
            'warna_tersedia' => $request->warna_tersedia,
            'kode_warna_tersedia' => $request->kode_warna_tersedia,
            'kode_sumber_pendapatan' => $request->kode_sumber_pendapatan,
            'kode_lokasi_tinggal' => $request->kode_lokasi_tinggal,
            'kode_kepemilikan_kendaraan' => $request->kode_kepemilikan_kendaraan,
        ]);

        if ($insert) {
            Alert::toast('Edit Data Berhasil', 'success');
            return redirect()->route('dashboard');
        }
        Alert::toast('Terdapat Error Pada Query', 'error');
        return back();
    }

    public function delete_product(Request $request) // Handle Request post delete
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return ApiFormatter::createAPi(400, 'Gagal');
        }

        $insert = Product::where('id', $request->id)->delete();
        if ($insert) {
            Alert::toast('Data berhasil dihapus', 'success');
            return ApiFormatter::createAPi(200, 'Berhasil');
        }
        return ApiFormatter::createAPi(400, 'Gagal');
    }

    public function update_kriteria_product(Request $request) // Handle Edit Dari Kriteria Product
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'kode_price' => 'required',
            'kode_eksterior' => 'required',
            'kode_kapasitas_cc' => 'required',
            'kode_dimensi' => 'required',
            'kode_kapasitas_orang' => 'required',
            'kode_safety' => 'required',
            'kode_interior' => 'required',
            'kode_velg' => 'required',
            'kode_fitur_tambahan' => 'required',
            'kode_warna_tersedia' => 'required',
            'kode_sumber_pendapatan' => 'required',
            'kode_lokasi_tinggal' => 'required',
            'kode_kepemilikan_kendaraan' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::toast('Terdapat Field Yang Kosong', 'error');
            return back();
        }

        $insert = Product::find($request->id)->update([
            'kode_price' => $request->kode_price,
            'kode_eksterior' => $request->kode_eksterior,
            'kode_kapasitas_cc' => $request->kode_kapasitas_cc,
            'kode_dimensi' => $request->kode_dimensi,
            'kode_kapasitas_orang' => $request->kode_kapasitas_orang,
            'kode_safety' => $request->kode_safety,
            'kode_interior' => $request->kode_interior,
            'kode_velg' => $request->kode_velg,
            'kode_fitur_tambahan' => $request->kode_fitur_tambahan,
            'kode_warna_tersedia' => $request->kode_warna_tersedia,
            'kode_sumber_pendapatan' => $request->kode_sumber_pendapatan,
            'kode_lokasi_tinggal' => $request->kode_lokasi_tinggal,
            'kode_kepemilikan_kendaraan' => $request->kode_kepemilikan_kendaraan,
        ]);

        if ($insert) {
            Alert::toast('Edit Data Berhasil', 'success');
            return redirect()->route('dashboard');
        }
        Alert::toast('Terdapat Error Pada Query', 'error');
        return back();
    }

    //====================['HANDLE LOGIN']====================//
    public function login_checking(Request $request) // handle post login dan cek ketersediaan pada user
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
            Alert::toast('Username/password Wrong!, Please Try Again!', 'error');
            return back();
        }
        return redirect()->route('login');
    }

    public function login_destroying(Request $request) // handle logout pada dashboard
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        Alert::toast('Berhasil Logout, Have A Good Day.', 'info');
        return redirect('/');
    }

    //====================['HANDLE DASHBOARD AFTER LOGIN PAGE']====================//

    public function dashboard() // handle tampilan pada url '/dashboard'
    {
        $data = "";
        $Products = Product::all();
        $cars =  Product::GroupBy('nama')->get('nama');
        return view('dashboard', compact('data', 'Products', 'cars'));
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

    public function getLastColumn($last)
    {
        //last represent how mouch X axis spaces
        return Coordinate::stringFromColumnIndex($last);
    }

    public function dw_survey() // handle request download pada table Survei
    {
        ini_set('memory_limit', '-1');

        // Ambil Data
        $data = Survey::all();


        // Judul Dalam File Excel
        $fileName = "DATA SURVEI";

        // Menentukan Header Pada File Excel
        $columns = [
            "#",
            "TANGGAL",
            "NAMA CUSTOMER",
            "NO HP CUSTOMER",
            // "K1",
            // "K2",
            // "K3",
            // "K4",
            // "K5",
            // "K6",
            // "K7",
            // "K8",
            // "K9",
            // "K10",
            // "K11",
            // "K12",
            // "K13",
            // "Total Nilai",
            "Hasil Rekomendasi",
            // "Dibuat",
            // "Dirubah"
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
                $sheet->setCellValue($this->getLastColumn($col) . $row, $item->created_at);
                $col++;
                $sheet->setCellValue($this->getLastColumn($col) . $row, $item->name);
                $col++;
                $sheet->setCellValue($this->getLastColumn($col) . $row, $item->no_telp);
                $col++;
                // $sheet->setCellValue($this->getLastColumn($col) . $row, $item->K1);
                // $col++;
                // $sheet->setCellValue($this->getLastColumn($col) . $row, $item->K2);
                // $col++;
                // $sheet->setCellValue($this->getLastColumn($col) . $row, $item->K3);
                // $col++;
                // $sheet->setCellValue($this->getLastColumn($col) . $row, $item->K4);
                // $col++;
                // $sheet->setCellValue($this->getLastColumn($col) . $row, $item->K5);
                // $col++;
                // $sheet->setCellValue($this->getLastColumn($col) . $row, $item->K6);
                // $col++;
                // $sheet->setCellValue($this->getLastColumn($col) . $row, $item->K7);
                // $col++;
                // $sheet->setCellValue($this->getLastColumn($col) . $row, $item->K8);
                // $col++;
                // $sheet->setCellValue($this->getLastColumn($col) . $row, $item->K9);
                // $col++;
                // $sheet->setCellValue($this->getLastColumn($col) . $row, $item->K10);
                // $col++;
                // $sheet->setCellValue($this->getLastColumn($col) . $row, $item->K11);
                // $col++;
                // $sheet->setCellValue($this->getLastColumn($col) . $row, $item->K12);
                // $col++;
                // $sheet->setCellValue($this->getLastColumn($col) . $row, $item->K13);
                // $col++;
                // $sheet->setCellValue($this->getLastColumn($col) . $row, $item->total_nilai);
                // $col++;
                $sheet->setCellValue($this->getLastColumn($col) . $row, $item->hasil);
                $col++;
                // $sheet->setCellValue($this->getLastColumn($col) . $row, $item->created_at);
                // $col++;
                // $sheet->setCellValue($this->getLastColumn($col) . $row, $item->updated_at);
                // $col++;
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
                ->editColumn('created_at', function ($data){
                    $tgl = $data->created_at;
                    $tgl = substr($tgl, 0,10);

                    return $tgl;
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

    //====================['HANDLE API FROM api.php']====================//

    public function filter_product_byID($id)
    {
        $data = Product::find($id);
        if ($data != null) {
            return ApiFormatter::createAPi(200, 'Berhasil', $data);
        } else {
            return ApiFormatter::createAPi(400, 'Data Not Found');
        }
    }

    public function filter_product($spek, $value)
    {
        $data = Product::whereBetween('kapasitas_cc', [1197, 1198])
            ->where('kapasitas_orang', 5)
            ->get();
        if ($data != null) {
            return ApiFormatter::createAPi(200, 'Berhasil', $data);
        } else {
            return ApiFormatter::createAPi(400, 'Data Not Found');
        }
    }

    public function filter_kapasitas_cc(Request $request)
    {
        $dataArray = explode(", ", $request->raw_kapasitas_mesin);
        if ($dataArray[1] != null && $dataArray[2] != null) {
            $data = Product::select('kapasitas_orang', 'kode_kapasitas_orang')->whereBetween('kapasitas_cc', [$dataArray[1], $dataArray[2]])->GroupBy('kapasitas_orang')->orderBy('kapasitas_orang', 'asc')->get();
            return ApiFormatter::createAPi(200, 'Berhasil', $data);
        } else {
            return ApiFormatter::createAPi(400, 'Gagal');
        }
        return ApiFormatter::createAPi(400, 'Gagal');
    }

    public function filter_kapasitas_seater(Request $request)
    {
        $dataArray = explode(", ", $request->raw_kapasitas_mesin);
        $dataArraySeat = explode(", ", $request->raw_kapasitas_seat);
        if ($dataArray[1] != null && $dataArray[2] != null && $dataArraySeat[0] != null) {
            $data = Product::whereBetween('kapasitas_cc', [$dataArray[1], $dataArray[2]])
                ->where('kapasitas_orang', $dataArraySeat[0])
                // ->GroupBy('nama')
                ->get();
            return ApiFormatter::createAPi(200, 'Berhasil', $data);
        } else {
            return ApiFormatter::createAPi(400, 'Gagal');
        }
        return ApiFormatter::createAPi(400, 'Gagal');
    }
}
