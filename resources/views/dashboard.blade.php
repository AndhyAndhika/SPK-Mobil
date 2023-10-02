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
                            <p class="text-dark text-end fs-5">Selamat Datang, <span class="fw-bold">Binta</span> </p>
                        </div>
                        <div class="col-1 m-0">
                            <a href="" class="btn btn-danger btn-sm w-100 text-light">Logout
                                <svg height="1em" viewBox="0 0 512 512" style="fill:#ffffff">
                                <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/></svg>
                            </a>
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
                    <div class="card-body" style="height: 63.5vh">
                        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <button class="nav-link active" id="v-pills-Hasil-Survei-tab" data-bs-toggle="pill" data-bs-target="#v-pills-Hasil-Survei" type="button" role="tab" aria-controls="v-pills-Hasil-Survei" aria-selected="true">Hasil Survei</button>
                            <button class="nav-link" id="v-pills-Product-Sale-tab" data-bs-toggle="pill" data-bs-target="#v-pills-Product-Sale" type="button" role="tab" aria-controls="v-pills-Product-Sale" aria-selected="false">Product Sale</button>
                            {{-- <button class="nav-link" id="v-pills-disabled-tab" data-bs-toggle="pill" data-bs-target="#v-pills-disabled" type="button" role="tab" aria-controls="v-pills-disabled" aria-selected="false" disabled>Disabled</button>
                            <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Messages</button>
                            <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</button> --}}
                          </div>
                    </div>
                </div>
            </div>
            <div class="col-10">
                <div class="card ms-1">
                    <div class="card-body" style="height: 63.5vh">
                        <div class="tab-content" id="v-pills-tabContent">
                            {{-- TAB HASIL SURVEI --}}
                            <div class="tab-pane fade show active" id="v-pills-Hasil-Survei" role="tabpanel" aria-labelledby="v-pills-Hasil-Survei-tab" tabindex="0">
                                <div class="table-responsive">
                                    <button class="btn btn-success btn-sm mb-2 float-end" onclick="AddMachine()"><i class="fa-solid fa-plus"></i>
                                        Download</button>
                                    <table id="dt_hasilsurvei" class="table table-light table-hover table-bordered display">
                                        <thead>
                                            <tr>
                                                <th>Customer Name</th>
                                                <th>Telp Number</th>
                                                <th>Our Recomended</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            {{-- TAB PRODUCT SALE --}}
                            <div class="tab-pane fade" id="v-pills-Product-Sale" role="tabpanel" aria-labelledby="v-pills-Product-Sale-tab" tabindex="0">
                                <div class="table-responsive">
                                    <button class="btn btn-primary btn-sm mb-2 float-end" onclick="AddMachine()"><i class="fa-solid fa-plus"></i>
                                        New Product</button>
                                    <table id="dt_allproduct" class="table table-light table-hover table-bordered display">
                                        <thead>
                                            <tr>
                                                <th>Customer Name</th>
                                                <th>Telp Number</th>
                                                <th>Our Recomended</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            {{-- <div class="tab-pane fade" id="v-pills-disabled" role="tabpanel" aria-labelledby="v-pills-disabled-tab" tabindex="0">...</div>
                            <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab" tabindex="0">...</div>
                            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab" tabindex="0">...</div> --}}
                          </div>
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
            processing: true,
            serverSide: true,
            ajax: "{{ url('/dt-allproduct') }}",
            columns: [
                // {data: 'name', name: 'name'},
                // {data: 'no_telp', name: 'no_telp'},
                // {data: 'hasil', name: 'hasil'},
            ]
            });
        });
    </script>
@endsection
