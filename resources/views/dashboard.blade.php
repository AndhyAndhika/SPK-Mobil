@extends('New-Template')
@section('content')
    {{-- WELCOMING CARD DASHBOARD --}}
    <div class="row" style="margin-top: -2vh;">
        <div class="col-12" >
            <div class="card w-100" style="background-color: rgb(102, 255, 255); height: 10vh;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <p class="card-title fw-bold fs-5 text-capitalize">Halaman {{ Auth::User()->role }}</p>
                        </div>
                        <div class="col-5">
                            <p class="text-dark text-end fs-5">Selamat Datang, <span class="fw-bold text-capitalize">{{ Auth::user()->name }}</span> </p>
                        </div>
                        <div class="col-1 m-0">
                            <form action="/login/destroying" method="POST">@csrf
                                <button class="btn btn-danger btn-sm w-100 text-light" type="submit">Logout
                                    <svg height="1em" viewBox="0 0 512 512" style="fill:#ffffff">
                                    <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- CONTENT ON DASHBOARD --}}
    <div class="row mt-1 mb-2">
        <div class="d-flex align-items-start">
            {{-- BUTTON MENU SEBELAH KIRI --}}
            <div class="col-2">
                <div class="card">
                    <div class="card-body " style="min-height: 63.5vh">
                        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <button class="nav-link text-start active" id="v-pills-Hasil-Survei-tab" data-bs-toggle="pill" data-bs-target="#v-pills-Hasil-Survei" type="button" role="tab" aria-controls="v-pills-Hasil-Survei" aria-selected="true">Hasil Survei</button>
                            <button class="nav-link text-start" id="v-pills-Product-Sale-tab" data-bs-toggle="pill" data-bs-target="#v-pills-Product-Sale" type="button" role="tab" aria-controls="v-pills-Product-Sale" aria-selected="false">Product Sale</button>
                            <button class="nav-link text-start" id="v-pills-Kriteria-Product-Sale-tab" data-bs-toggle="pill" data-bs-target="#v-pills-Kriteria-Product-Sale" type="button" role="tab" aria-controls="v-pills-Kriteria-Product-Sale" aria-selected="false">Kriteria Product</button>
                          </div>
                    </div>
                </div>
            </div>
            {{-- ISI KONTEN SEBELAH KANAN --}}
            <div class="col-10">
                <div class="card ms-1">
                    <div class="card-body" style="min-height: 63.5vh">
                        <div class="tab-content" id="v-pills-tabContent">
                            {{-- TAB HASIL SURVEI --}}
                            <div class="tab-pane fade show active" id="v-pills-Hasil-Survei" role="tabpanel" aria-labelledby="v-pills-Hasil-Survei-tab" tabindex="0">
                                <div class="table-responsive">
                                    <a class="btn btn-success btn-sm mb-2 float-end" href="/download/survey"><i class="fa-solid fa-plus"></i>
                                        Download</a>
                                    <table id="dt_hasilsurvei" class="table table-light table-hover table-bordered display">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Tanggal</th>
                                                <th class="text-center">Customer Name</th>
                                                <th class="text-center">Telp Number</th>
                                                <th class="text-center">Our Recomended</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            {{-- TAB PRODUCT SALE --}}
                            <div class="tab-pane fade" id="v-pills-Product-Sale" role="tabpanel" aria-labelledby="v-pills-Product-Sale-tab" tabindex="0">
                                <div class="table-responsive">
                                    @if (Auth::User()->role == 'supervisor')
                                        <button class="btn btn-primary btn-sm mb-2 float-end" onclick="AddProduct()"><i class="fa-solid fa-plus"></i> New Product</button>
                                    @else

                                    @endif

                                    <table id="dt_allproduct" class="table table-light table-hover table-bordered display table-responsive" style="overflow-y: scroll;">
                                        <thead>
                                            <tr>
                                                <th class="text-center">MODEL - TYPE</th>
                                                <th class="text-center">HARGA</th>
                                                <th class="text-center">MESIN (CC)</th>
                                                <th class="text-center">SEATER</th>
                                                <th class="text-center">DIMENSI (cm)</th>
                                                <th class="text-center">VELG</th>
                                                <th class="text-center">INTERIOR</th>
                                                <th class="text-center">EXTERIOR</th>
                                                <th class="text-center">FITUR SAFETY</th>
                                                <th class="text-center">FITUR TAMBAHAN</th>
                                                <th class="text-center">WARNA TERSEDIA</th>
                                                @if (Auth::User()->role == 'supervisor')
                                                    <th class="text-center" colspan="2">AKSI</th>
                                                @else
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($Products as $item)
                                                <tr>
                                                    <td>{{ $item->nama }} - {{ $item->type }}</td>
                                                    <td>@Rupiah($item->price)</td>
                                                    <td class="text-end">{{ $item->kapasitas_cc }} cc</td>
                                                    <td class="text-center">{{ $item->kapasitas_orang }}</td>
                                                    <td>{{ $item->dimensi }}</td>
                                                    <td>{{ $item->velg }}</td>
                                                    <td><?php $itemsArray = explode(', ', $item->interior) ?>
                                                        <ul>
                                                            @foreach ($itemsArray as $inter)
                                                                <li>{{ $inter }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    <td><?php $itemsArray = explode(', ', $item->eksterior) ?>
                                                        <ul>
                                                            @foreach ($itemsArray as $eks)
                                                                <li>{{ $eks }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    <td><?php $itemsArray = explode(', ', $item->safety) ?>
                                                        <ul>
                                                            @foreach ($itemsArray as $safe)
                                                                <li>{{ $safe }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    <td><?php $itemsArray = explode(', ', $item->fitur_tambahan) ?>
                                                        <ul>
                                                            @foreach ($itemsArray as $fitur_)
                                                                <li>{{ $fitur_ }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    <td><?php $itemsArray = explode(', ', $item->warna_tersedia) ?>
                                                        <ul>
                                                            @foreach ($itemsArray as $warna_)
                                                                <li>{{ $warna_ }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    @if (Auth::User()->role == 'supervisor')
                                                        <td class="text-center">
                                                            <a class="btn btn-warning" onclick="EditProduct({{ $item->id }}, '{{ $item->nama }} - {{ $item->type }}')">
                                                                <svg height="1em" viewBox="0 0 512 512">
                                                                    <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"/>
                                                                </svg>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a class="btn btn-danger" onclick="DeleteProduct({{ $item->id }})">
                                                                <svg height="1em" viewBox="0 0 512 512">
                                                                    <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                                                                </svg>
                                                            </a>
                                                        </td>
                                                    @else
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- TAB KRITERIA PRODUCT SALE --}}
                            <div class="tab-pane fade" id="v-pills-Kriteria-Product-Sale" role="tabpanel" aria-labelledby="v-pills-Kriteria-Product-Sale-tab" tabindex="0">
                                <div class="table-responsive">
                                    <table id="dt_kriteria" class="table table-light table-hover table-bordered display table-responsive" style="overflow-y: scroll;">
                                        <thead>
                                            <tr>
                                                <th class="text-center">MODEL - TYPE</th>
                                                <th class="text-center">K1</th>
                                                <th class="text-center">K2</th>
                                                <th class="text-center">K3</th>
                                                <th class="text-center">K4</th>
                                                <th class="text-center">K5</th>
                                                <th class="text-center">K6</th>
                                                <th class="text-center">K7</th>
                                                <th class="text-center">K8</th>
                                                <th class="text-center">K9</th>
                                                <th class="text-center">K10</th>
                                                <th class="text-center">K11</th>
                                                <th class="text-center">K12</th>
                                                <th class="text-center">K13</th>
                                                {{-- <th class="text-center">K1 - Sumber pendapatan</th>
                                                <th class="text-center">K2 - Lokasi tinggal</th>
                                                <th class="text-center">K3 - Kepemilikan kendaraan</th>
                                                <th class="text-center">K4 - Harga mobil</th>
                                                <th class="text-center">K5 - Kapasitas mesin</th>
                                                <th class="text-center">K6 - Kapasitas penumpang</th>
                                                <th class="text-center">K7 - Keamanan dalam berkendara</th>
                                                <th class="text-center">K8 - Interior mobil</th>
                                                <th class="text-center">K9 - Dimensi mobil</th>
                                                <th class="text-center">K10 - Jumlah keinginan fitur tambahan</th>
                                                <th class="text-center">K11 - Jumlah keinginan eksterior</th>
                                                <th class="text-center">K12 - Warna mobil tersedia</th>
                                                <th class="text-center">K13 - Jenis velg</th> --}}
                                                @if (Auth::User()->role == 'supervisor')
                                                    <th class="text-center">AKSI</th>
                                                @else
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($Products as $item)
                                                <tr>
                                                    <td style="width: 500px;">{{ $item->nama }} - {{ $item->type }}</td>
                                                    <td class="text-center">{{ $item->kode_sumber_pendapatan }}</td> {{-- "sumber_pendapatan" => 'required', // K1 --}}
                                                    <td class="text-center">{{ $item->kode_lokasi_tinggal }}</td> {{-- "lokasi_tinggal" => 'required', // K2 --}}
                                                    <td class="text-center">{{ $item->kode_kepemilikan_kendaraan }}</td> {{-- "kepemilikan_kendaraan" => 'required', // K3 --}}
                                                    <td class="text-center">{{ $item->kode_price }}</td> {{-- "harga_mobil" => 'required', // K4 --}}
                                                    <td class="text-center">{{ $item->kode_kapasitas_cc }}</td> {{-- "kapasitas_mesin" => 'required', // K5 --}}
                                                    <td class="text-center">{{ $item->kode_kapasitas_orang }}</td> {{-- "kapasitas_penumpang" => 'required', // K6 --}}
                                                    <td class="text-center">{{ $item->kode_safety }}</td> {{-- "keamanan_dalam_berkendara" => 'required', // K7 --}}
                                                    <td class="text-center">{{ $item->kode_interior }}</td> {{-- "interior_mobil" => 'required', // K8 --}}
                                                    <td class="text-center">{{ $item->kode_dimensi }}</td> {{-- "dimensi_mobil" => 'required', // K9 --}}
                                                    <td class="text-center">{{ $item->kode_fitur_tambahan }}</td> {{-- "jumlah_keinginan_fitur_tambahan" => 'required', // K10 --}}
                                                    <td class="text-center">{{ $item->kode_eksterior }}</td> {{-- "jumlah_keinginan_eksterior" => 'required', // K11 --}}
                                                    <td class="text-center">{{ $item->kode_warna_tersedia }}</td> {{-- "warna_mobil" => 'required', // K12 --}}
                                                    <td class="text-center">{{ $item->kode_velg }}</td> {{-- "jenis_velg" => 'required', // K13 --}}
                                                    @if (Auth::User()->role == 'supervisor')
                                                        <td class="text-center">
                                                            <a class="btn btn-warning" onclick="EditKriteriaProduct({{ $item->id }}, '{{ $item->nama }} - {{ $item->type }}')">
                                                                <svg height="1em" viewBox="0 0 512 512">
                                                                    <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"/>
                                                                </svg>
                                                            </a>
                                                        </td>
                                                    @else
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <table style="width: 100%">
                                        <tr>
                                            <th>Keterangan Nilai :</th>
                                        </tr>
                                        <tr>
                                            <th>1 : Tidak Penting </th>
                                            <th>2 : Kurang Penting </th>
                                            <th>3 : Cukup Penting </th>
                                            <th>4 : Penting </th>
                                            <th>5 : Sangat Penting</th>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
          </div>
          {{-- MODAL ADD PRODUCT DAN EDIT--}}
          <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <div class="modal-body">
                        <form action="{{ url('/save-product') }}" method="POST" enctype="multipart/form-data" onsubmit="DisabledButtomSubmit()">
                            @csrf
                            <div class="row">
                                <div class="col-3">
                                    <div class="mb-3" id="bukankode">
                                        <label for="kode" class="form-label">Kode Product <sup class="text-danger">*</sup> </label>
                                        <input required type="text" class="form-control" id="kode" name="kode">
                                    </div>
                                    <div class="mb-3" id="bukankode">
                                        <label for="nama" class="form-label">Nama <sup class="text-danger">*</sup> </label>
                                        {{-- <input required type="text" class="form-control" id="nama" name="nama"> --}}
                                        <div id="inputtypenama">
                                            <select class="form-select" aria-label="Default select example" required id="nama" name="nama">
                                                <option selected>Open this select menu</option>
                                                @foreach ($cars as $car)
                                                    <option value="{{ $car->nama }}">{{ $car->nama }}</option>
                                                @endforeach
                                                <option value="etc">Dan lain lain</option>
                                            </select>
                                        </div>
                                        <script>
                                            $('#nama').on('change', function() {
                                                if(this.value === 'etc'){
                                                    $('#inputtypenama').html('<input required type="text" class="form-control" id="nama" name="nama" placeholder="Masukan Type Nama Mobil">')
                                                }
                                            });
                                        </script>
                                    </div>
                                    <div class="mb-3" id="bukankode">
                                        <label for="type" class="form-label">Type <sup class="text-danger">*</sup> </label>
                                        <input required type="text" class="form-control" id="type" name="type">
                                    </div>
                                    <div class="mb-3" id="bukankode">
                                        <label for="price" class="form-label">Price <sup class="text-danger">*</sup> </label>
                                        <input required type="number" min="1" class="form-control" id="price" name="price">
                                    </div>
                                    <div class="mb-3" id="kode">
                                        <label for="kode_price" class="form-label">Kode Price <sup class="text-danger">*</sup> </label>
                                        {{-- <input required type="number" min="1" class="form-control" id="kode_price" name="kode_price"> --}}
                                        <select class="form-select" aria-label="Default select example" required id="kode_price" name="kode_price">
                                            <option selected>Open this select menu</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="mb-3" id="bukankode">
                                        <label for="eksterior" class="form-label">Eksterior <sup class="text-danger">*</sup> </label>
                                        <input required type="textarea" class="form-control" id="eksterior" name="eksterior">
                                    </div>

                                    <div class="mb-3">
                                        <label for="kode_lokasi_tinggal" class="form-label">Kode Lokasi Tinggal <sup class="text-danger">*</sup> </label>
                                        {{-- <input required type="number" min="1" class="form-control" id="kode_lokasi_tinggal" name="kode_lokasi_tinggal"> --}}
                                        <select class="form-select" aria-label="Default select example" required id="kode_lokasi_tinggal" name="kode_lokasi_tinggal">
                                            <option selected>Open this select menu</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3" id="kode">
                                        <label for="kode_eksterior" class="form-label">Kode Eksterior <sup class="text-danger">*</sup> </label>
                                        {{-- <input required type="number" min="1" class="form-control" id="kode_eksterior" name="kode_eksterior"> --}}
                                        <select class="form-select" aria-label="Default select example" required id="kode_eksterior" name="kode_eksterior">
                                            <option selected>Open this select menu</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="mb-3" id="bukankode">
                                        <label for="kapasitas_cc" class="form-label">Kapasitas CC <sup class="text-danger">*</sup> </label>
                                        <input required type="text" class="form-control" id="kapasitas_cc" name="kapasitas_cc">
                                    </div>
                                    <div class="mb-3" id="kode">
                                        <label for="kode_kapasitas_cc" class="form-label">Kode kapasitas CC <sup class="text-danger">*</sup> </label>
                                        {{-- <input required type="number" min="1" class="form-control" id="kode_kapasitas_cc" name="kode_kapasitas_cc"> --}}
                                        <select class="form-select" aria-label="Default select example" required id="kode_kapasitas_cc" name="kode_kapasitas_cc">
                                            <option selected>Open this select menu</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="mb-3" id="bukankode">
                                        <label for="dimensi" class="form-label">Dimensi <sup class="text-danger">*</sup> </label>
                                        <input required type="text" class="form-control" id="dimensi" name="dimensi">
                                    </div>
                                    <div class="mb-3" id="kode">
                                        <label for="kode_dimensi" class="form-label">Kode Dimensi <sup class="text-danger">*</sup> </label>
                                        {{-- <input required type="number" min="1" class="form-control" id="kode_dimensi" name="kode_dimensi"> --}}
                                        <select class="form-select" aria-label="Default select example" required id="kode_dimensi" name="kode_dimensi">
                                            <option selected>Open this select menu</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="mb-3" id="bukankode">
                                        <label for="kapasitas_orang" class="form-label">Kapasitas Orang <sup class="text-danger">*</sup> </label>
                                        <input required type="text" class="form-control" id="kapasitas_orang" name="kapasitas_orang">
                                    </div>
                                    <div class="mb-3">
                                        <label for="kode_kepemilikan_kendaraan" class="form-label">Kode Kepemilikan Kendaraan <sup class="text-danger">*</sup> </label>
                                        {{-- <input required type="number" min="1" class="form-control" id="kode_kepemilikan_kendaraan" name="kode_kepemilikan_kendaraan"> --}}
                                        <select class="form-select" aria-label="Default select example" required id="kode_kepemilikan_kendaraan" name="kode_kepemilikan_kendaraan">
                                            <option selected>Open this select menu</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3" id="kode">
                                        <label for="kode_kapasitas_orang" class="form-label">Kode Kapasitas Orang <sup class="text-danger">*</sup> </label>
                                        {{-- <input required type="number" min="1" class="form-control" id="kode_kapasitas_orang" name="kode_kapasitas_orang"> --}}
                                        <select class="form-select" aria-label="Default select example" required id="kode_kapasitas_orang" name="kode_kapasitas_orang">
                                            <option selected>Open this select menu</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="mb-3" id="bukankode">
                                        <label for="safety" class="form-label">Safety <sup class="text-danger">*</sup> </label>
                                        <input required type="text" class="form-control" id="safety" name="safety">
                                    </div>
                                    <div class="mb-3" id="kode">
                                        <label for="kode_safety" class="form-label">Kode Safety <sup class="text-danger">*</sup> </label>
                                        {{-- <input required type="number" min="1" class="form-control" id="kode_safety" name="kode_safety"> --}}
                                        <select class="form-select" aria-label="Default select example" required id="kode_safety" name="kode_safety">
                                            <option selected>Open this select menu</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="mb-3" id="bukankode">
                                        <label for="interior" class="form-label">Interior <sup class="text-danger">*</sup> </label>
                                        <input required type="text" class="form-control" id="interior" name="interior">
                                    </div>
                                    <div class="mb-3" id="kode">
                                        <label for="kode_interior" class="form-label">Kode Interior <sup class="text-danger">*</sup> </label>
                                        {{-- <input required type="number" min="1" class="form-control" id="kode_interior" name="kode_interior"> --}}
                                        <select class="form-select" aria-label="Default select example" required id="kode_interior" name="kode_interior">
                                            <option selected>Open this select menu</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="mb-3" id="bukankode">
                                        <label for="velg" class="form-label">Velg <sup class="text-danger">*</sup> </label>
                                        <input required type="text" class="form-control" id="velg" name="velg">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3" id="kode">
                                        <label for="kode_velg" class="form-label">Kode Velg <sup class="text-danger">*</sup> </label>
                                        {{-- <input required type="number" min="1" class="form-control" id="kode_velg" name="kode_velg"> --}}
                                        <select class="form-select" aria-label="Default select example" required id="kode_velg" name="kode_velg">
                                            <option selected>Open this select menu</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="mb-3" id="bukankode">
                                        <label for="fitur_tambahan" class="form-label">Fitur Tambahan <sup class="text-danger">*</sup> </label>
                                        <input required type="text" class="form-control" id="fitur_tambahan" name="fitur_tambahan">
                                    </div>
                                    <div class="mb-3" id="kode">
                                        <label for="kode_fitur_tambahan" class="form-label">Kode Fitur Tambahan <sup class="text-danger">*</sup> </label>
                                        {{-- <input required type="number" min="1" class="form-control" id="kode_fitur_tambahan" name="kode_fitur_tambahan"> --}}
                                        <select class="form-select" aria-label="Default select example" required id="kode_fitur_tambahan" name="kode_fitur_tambahan">
                                            <option selected>Open this select menu</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="mb-3" id="bukankode">
                                        <label for="warna_tersedia" class="form-label">Warna Tersedia <sup class="text-danger">*</sup> </label>
                                        <input required type="text" class="form-control" id="warna_tersedia" name="warna_tersedia">
                                    </div>
                                    <div class="mb-3" id="kode">
                                        <label for="kode_warna_tersedia" class="form-label">Kode Warna Tersedia <sup class="text-danger">*</sup> </label>
                                        {{-- <input required type="number" min="1" class="form-control" id="kode_warna_tersedia" name="kode_warna_tersedia"> --}}
                                        <select class="form-select" aria-label="Default select example" required id="kode_warna_tersedia" name="kode_warna_tersedia">
                                            <option selected>Open this select menu</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="kode_sumber_pendapatan" class="form-label">Kode Sumber Pendapatan <sup class="text-danger">*</sup> </label>
                                        {{-- <input required type="number" min="1" class="form-control" id="kode_sumber_pendapatan" name="kode_sumber_pendapatan"> --}}
                                        <select class="form-select" aria-label="Default select example" required id="kode_sumber_pendapatan" name="kode_sumber_pendapatan">
                                            <option selected>Open this select menu</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="insideCOl"></div>
                                <div class="col-12">
                                    <button type="submit" id="submit" class="btn btn-success float-end">
                                        <svg height="1em" viewBox="0 0 448 512">
                                        <style>svg{fill:#ffffff}</style>
                                        <path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V173.3c0-17-6.7-33.3-18.7-45.3L352 50.7C340 38.7 323.7 32 306.7 32H64zm0 96c0-17.7 14.3-32 32-32H288c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V128zM224 288a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/>
                                        </svg> SUBMIT
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
              </div>
            </div>
          </div>
          {{-- MODAL EDIT KRITERIA --}}
          <div class="modal fade" id="kriteria-staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="kriteria-staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="kriteria-staticBackdropLabel">Modal title</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <div class="modal-body">
                        <form action="{{ url('/update-kriteria-product') }}" method="POST" enctype="multipart/form-data" onsubmit="DisabledButtomSubmit()">
                            @csrf
                            <div class="row">
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label for="kodee_sumber_pendapatan" class="form-label">K1 - Sumber pendapatan<sup class="text-danger">*</sup> </label>
                                        {{-- <input required type="number" min="1" class="form-control" id="kodee_sumber_pendapatan" name="kode_sumber_pendapatan"> --}}
                                        <select class="form-select" aria-label="Default select example" required id="kodee_sumber_pendapatan" name="kode_sumber_pendapatan">
                                            <option selected>Open this select menu</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kodee_lokasi_tinggal" class="form-label">K2 - Lokasi tinggal<sup class="text-danger">*</sup> </label>
                                        {{-- <input required type="number" min="1" class="form-control" id="kodee_lokasi_tinggal" name="kode_lokasi_tinggal"> --}}
                                        <select class="form-select" aria-label="Default select example" required  id="kodee_lokasi_tinggal" name="kode_lokasi_tinggal">
                                            <option selected>Open this select menu</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kodee_kepemilikan_kendaraan" class="form-label">K3 - Kepemilikan kendaraan<sup class="text-danger">*</sup> </label>
                                        {{-- <input required type="number" min="1" class="form-control" id="kodee_kepemilikan_kendaraan" name="kode_kepemilikan_kendaraan"> --}}
                                        <select class="form-select" aria-label="Default select example" required id="kodee_kepemilikan_kendaraan" name="kode_kepemilikan_kendaraan">
                                            <option selected>Open this select menu</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kodee_price" class="form-label">K4 - Harga mobil<sup class="text-danger">*</sup> </label>
                                        {{-- <input required type="number" min="1" class="form-control" id="kodee_price" name="kode_price"> --}}
                                        <select class="form-select" aria-label="Default select example" required id="kodee_price" name="kode_price">
                                            <option selected>Open this select menu</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label for="kodee_kapasitas_cc" class="form-label">K5 - Kapasitas mesin<sup class="text-danger">*</sup> </label>
                                        {{-- <input required type="number" min="1" class="form-control" id="kodee_kapasitas_cc" name="kode_kapasitas_cc"> --}}
                                        <select class="form-select" aria-label="Default select example" required id="kodee_kapasitas_cc" name="kode_kapasitas_cc">
                                            <option selected>Open this select menu</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kodee_kapasitas_orang" class="form-label">K6 - Kapasitas penumpang<sup class="text-danger">*</sup> </label>
                                        {{-- <input required type="number" min="1" class="form-control" id="kodee_kapasitas_orang" name="kode_kapasitas_orang"> --}}
                                        <select class="form-select" aria-label="Default select example" required id="kodee_kapasitas_orang" name="kode_kapasitas_orang">
                                            <option selected>Open this select menu</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kodee_safety" class="form-label">K7 - Keamanan dalam berkendara<sup class="text-danger">*</sup> </label>
                                        {{-- <input required type="number" min="1" class="form-control" id="kodee_safety" name="kode_safety"> --}}
                                        <select class="form-select" aria-label="Default select example" required id="kodee_safety" name="kode_safety">
                                            <option selected>Open this select menu</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label for="kodee_interior" class="form-label">K8 - Interior mobil<sup class="text-danger">*</sup> </label>
                                        {{-- <input required type="number" min="1" class="form-control" id="kodee_interior" name="kode_interior"> --}}
                                        <select class="form-select" aria-label="Default select example" required id="kodee_interior" name="kode_interior">
                                            <option selected>Open this select menu</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kodee_dimensi" class="form-label">K9 - Dimensi mobil<sup class="text-danger">*</sup> </label>
                                        {{-- <input required type="number" min="1" class="form-control" id="kodee_dimensi" name="kode_dimensi"> --}}
                                        <select class="form-select" aria-label="Default select example" required id="kodee_dimensi" name="kode_dimensi">
                                            <option selected>Open this select menu</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kodee_fitur_tambahan" class="form-label">K10 - Jumlah keinginan fitur tambahan<sup class="text-danger">*</sup> </label>
                                        {{-- <input required type="number" min="1" class="form-control" id="kodee_fitur_tambahan" name="kode_fitur_tambahan"> --}}
                                        <select class="form-select" aria-label="Default select example" required id="kodee_fitur_tambahan" name="kode_fitur_tambahan">
                                            <option selected>Open this select menu</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-3">
                                        <label for="kodee_eksterior" class="form-label">K11 - Jumlah keinginan eksterior<sup class="text-danger">*</sup> </label>
                                        {{-- <input required type="number" min="1" class="form-control" id="kodee_eksterior" name="kode_eksterior"> --}}
                                        <select class="form-select" aria-label="Default select example" required id="kodee_eksterior" name="kode_eksterior">
                                            <option selected>Open this select menu</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kodee_warna_tersedia" class="form-label">K12 - Warna mobil tersedia<sup class="text-danger">*</sup> </label>
                                        {{-- <input required type="number" min="1" class="form-control" id="kodee_warna_tersedia" name="kode_warna_tersedia"> --}}
                                        <select class="form-select" aria-label="Default select example" required id="kodee_warna_tersedia" name="kode_warna_tersedia">
                                            <option selected>Open this select menu</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kodee_velg" class="form-label">K13 - Jenis velg<sup class="text-danger">*</sup> </label>
                                        {{-- <input required type="number" min="1" class="form-control" id="kodee_velg" name="kode_velg"> --}}
                                        <select class="form-select" aria-label="Default select example" required id="kodee_velg" name="kode_velg">
                                            <option selected>Open this select menu</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="insideeCOl"></div>
                                <div class="col-12">
                                    <button type="submit" id="submit" class="btn btn-success float-end">
                                        <svg height="1em" viewBox="0 0 448 512">
                                        <style>svg{fill:#ffffff}</style>
                                        <path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V173.3c0-17-6.7-33.3-18.7-45.3L352 50.7C340 38.7 323.7 32 306.7 32H64zm0 96c0-17.7 14.3-32 32-32H288c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V128zM224 288a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/>
                                        </svg> SUBMIT
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
              </div>
            </div>
          </div>
    </div>
    <script>
        @if (Auth::User()->role == 'supervisor')
            function AddProduct(){
                $("#staticBackdropLabel").html('Add New Product'); //Untuk kasih judul di modal
                $("#staticBackdrop").modal("show"); //kalo ID pake "#" kalo class pake "."
                $("form").attr("action", "{{ url('/save-product') }}");
                $("#kode").val("");
                $("#nama").val("");
                $("#type").val("");
                $("#price").val(1);
                $("#kode_price").val(1);
                $("#eksterior").val("");
                $("#kode_eksterior").val(1);
                $("#kapasitas_cc").val("");
                $("#kode_kapasitas_cc").val(1);
                $("#dimensi").val("");
                $("#kode_dimensi").val(1);
                $("#kapasitas_orang").val("");
                $("#kode_kapasitas_orang").val(1);
                $("#safety").val("");
                $("#kode_safety").val(1);
                $("#interior").val("");
                $("#kode_interior").val(1);
                $("#velg").val("");
                $("#kode_velg").val(1);
                $("#fitur_tambahan").val("");
                $("#kode_fitur_tambahan").val(1);
                $("#warna_tersedia").val("");
                $("#kode_warna_tersedia").val(1);
                $("#insideCOl").html("");
                $("#kode_kepemilikan_kendaraan").val(1);
                $("#kode_lokasi_tinggal").val(1);
                $("#kode_sumber_pendapatan").val(1);
            }

            function EditProduct(id, product){
                $("#staticBackdropLabel").html('<span class="text-capitalize">edit ' + product +'</span>'); //Untuk kasih judul di modal
                $("#staticBackdrop").modal("show"); //kalo ID pake "#" kalo class pake "."
                $.ajax({
                    dataType: "json",
                    url: "{{ url('/api/produk-filter/byid') }}"+"/"+id,
                    success: function (respon) {
                        console.log(respon)
                        console.log(respon.data.dimensi)
                        $("form").attr("action", "{{ url('/update-product') }}");
                        $("#kode").val(respon.data.kode);
                        $("#nama").val(respon.data.nama);
                        $("#type").val(respon.data.type);
                        $("#price").val(respon.data.price);
                        $("#kode_sumber_pendapatan").val(respon.data.kode_sumber_pendapatan)
                        $("#kode_lokasi_tinggal").val(respon.data.kode_lokasi_tinggal)
                        $("#kode_kepemilikan_kendaraan").val(respon.data.kode_kepemilikan_kendaraan)
                        $("#kode_price").val(respon.data.kode_price);
                        $("#eksterior").val(respon.data.eksterior);
                        $("#kode_eksterior").val(respon.data.kode_eksterior);
                        $("#kapasitas_cc").val(respon.data.kapasitas_cc);
                        $("#kode_kapasitas_cc").val(respon.data.kode_kapasitas_cc);
                        $("#dimensi").val(respon.data.dimensi);
                        $("#kode_dimensi").val(respon.data.kode_dimensi);
                        $("#kapasitas_orang").val(respon.data.kapasitas_orang);
                        $("#kode_kapasitas_orang").val(respon.data.kode_kapasitas_orang);
                        $("#safety").val(respon.data.safety);
                        $("#kode_safety").val(respon.data.kode_safety);
                        $("#interior").val(respon.data.interior);
                        $("#kode_interior").val(respon.data.kode_interior);
                        $("#velg").val(respon.data.velg);
                        $("#kode_velg").val(respon.data.kode_velg);
                        $("#fitur_tambahan").val(respon.data.fitur_tambahan);
                        $("#kode_fitur_tambahan").val(respon.data.kode_fitur_tambahan);
                        $("#warna_tersedia").val(respon.data.warna_tersedia);
                        $("#kode_warna_tersedia").val(respon.data.kode_warna_tersedia);
                        $("#insideCOl").html('<input type="hidden" required name="id" value="'+respon.data.id+'">');
                    },
                });
            }

            function DeleteProduct(id){
                let text = "Apakah anda yakin akan menghapus ini ?";
                if (confirm(text) == true) {
                    $.ajax({
                        method: "POST",
                        dataType: "json",
                        url: "{{ url('/delete-product') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id,
                        },
                        success: function (respon) {
                            if(respon.code = 200){
                                console.log(respon)
                                window.location.href = "{{ url('/dashboard') }}"
                            }
                        },
                    });
                } else {
                    alert("Berhasil Dibatalkan")
                }
            }

            function EditKriteriaProduct(id, product){
                $("#kriteria-staticBackdropLabel").html('<span class="text-capitalize">edit kriteria ' + product +'</span>'); //Untuk kasih judul di modal
                $("#kriteria-staticBackdrop").modal("show"); //kalo ID pake "#" kalo class pake "."
                $.ajax({
                    dataType: "json",
                    url: "{{ url('/api/produk-filter/byid') }}"+"/"+id,
                    success: function (respon) {
                        $("#kodee_sumber_pendapatan").val(respon.data.kode_sumber_pendapatan)
                        $("#kodee_lokasi_tinggal").val(respon.data.kode_lokasi_tinggal)
                        $("#kodee_kepemilikan_kendaraan").val(respon.data.kode_kepemilikan_kendaraan)
                        $("#kodee_price").val(respon.data.kode_price);
                        $("#kodee_eksterior").val(respon.data.kode_eksterior);
                        $("#kodee_kapasitas_cc").val(respon.data.kode_kapasitas_cc);
                        $("#kodee_dimensi").val(respon.data.kode_dimensi);
                        $("#kodee_kapasitas_orang").val(respon.data.kode_kapasitas_orang);
                        $("#kodee_safety").val(respon.data.kode_safety);
                        $("#kodee_interior").val(respon.data.kode_interior);
                        $("#kodee_velg").val(respon.data.kode_velg);
                        $("#kodee_fitur_tambahan").val(respon.data.kode_fitur_tambahan);
                        $("#kodee_warna_tersedia").val(respon.data.kode_warna_tersedia);
                        $("#insideeCOl").html('<input type="hidden" required name="id" value="'+respon.data.id+'">');
                    },
                });
            }
        @else
        @endif
        $(document).ready( function () {
            var dt_hasilsurvei = $('#dt_hasilsurvei').DataTable({
                "iDisplayLength": 5,
                "lengthChange": false,
                processing: true,
                serverSide: true,
                ajax: "{{ url('/dt-hasilsurvei') }}",
                columns: [
                    {data: 'created_at', name: 'created_at'},
                    {data: 'name', name: 'name'},
                    {data: 'no_telp', name: 'no_telp'},
                    {data: 'hasil', name: 'hasil'},
                ]
            });

            var dt_kriteria = $('#dt_kriteria').DataTable({
                "iDisplayLength": 5,
                "lengthChange": false,
            });

            var dt_allproduct = $('#dt_allproduct').DataTable({
                "iDisplayLength": 5,
                "lengthChange": false,
                "columnDefs": [ {
                        "targets": 12,
                        "searchable": false,
                    }],
            });


        });
    </script>
@endsection
