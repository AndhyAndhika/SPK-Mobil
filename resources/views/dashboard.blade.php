@extends('New-Template')
@section('content')
    {{-- WELCOMING CARD DASHBOARD --}}
    <div class="row" style="margin-top: -2vh;">
        <div class="col-12" >
            <div class="card w-100" style="background-color: rgb(102, 255, 255); height: 10vh;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <p class="card-title fw-bold fs-5">Halaman Login SPV</p>
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
            <div class="col-2">
                <div class="card">
                    <div class="card-body" style="min-height: 63.5vh">
                        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <button class="nav-link active" id="v-pills-Hasil-Survei-tab" data-bs-toggle="pill" data-bs-target="#v-pills-Hasil-Survei" type="button" role="tab" aria-controls="v-pills-Hasil-Survei" aria-selected="true">Hasil Survei</button>
                            <button class="nav-link" id="v-pills-Product-Sale-tab" data-bs-toggle="pill" data-bs-target="#v-pills-Product-Sale" type="button" role="tab" aria-controls="v-pills-Product-Sale" aria-selected="false">Product Sale</button>
                          </div>
                    </div>
                </div>
            </div>
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
                                                <th class="text-center">AKSI</th>
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
                                                    <td class="text-center">
                                                        <a class="btn btn-warning" onclick="EditProduct({{ $item->id }}, '{{ $item->nama }} - {{ $item->type }}')">
                                                            <svg height="1.5em" viewBox="0 0 512 512">
                                                                <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"/>
                                                            </svg>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
          </div>
          {{-- MODAL --}}
          <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  ...
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Understood</button>
                </div>
              </div>
            </div>
          </div>
    </div>
    <script>
        $(function () {
            var table = $('#dt_hasilsurvei').DataTable({
            "iDisplayLength": 5,
            "lengthChange": false,
            processing: true,
            serverSide: true,
            ajax: "{{ url('/dt-hasilsurvei') }}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'no_telp', name: 'no_telp'},
                {data: 'hasil', name: 'hasil'},
            ]
            });
        });

        $(function () {
            var table = $('#dt_allproduct').DataTable({
            "iDisplayLength": 5,
            "lengthChange": false,
            });
        });

        function AddProduct(){
            $("#staticBackdropLabel").html('Add New Product'); //Untuk kasih judul di modal
            $("#staticBackdrop").modal("show"); //kalo ID pake "#" kalo class pake "."
            $("#page").html(data); //menampilkan view create di dalam id page
        }
        function EditProduct(id, product){
            $("#staticBackdropLabel").html('<span class="text-capitalize">edit ' + product +'</span>'); //Untuk kasih judul di modal
            $("#staticBackdrop").modal("show"); //kalo ID pake "#" kalo class pake "."
            $("#page").html(data); //menampilkan view create di dalam id page
        }
    </script>
@endsection
