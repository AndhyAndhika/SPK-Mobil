@extends('New-Template')
@section('content')
{{-- CAROSEL AWAL DAN SEJARAH --}}
    <div class="row">
        <div class="col-12 col-lg-8 mb-3 mb-lg-0">
            <div class="card">
                <div id="carouselExampleInterval" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    {{-- Ini untuk indicator dibawah gambar --}}
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleInterval" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleInterval" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleInterval" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        <button type="button" data-bs-target="#carouselExampleInterval" data-bs-slide-to="3" aria-label="Slide 4"></button>
                    </div>

                    {{-- Gambarnya ada disini --}}
                    <div class="carousel-inner">
                        <div class="carousel-item active" data-bs-interval="2000">
                        <img src="{{ asset('UIUX/IMG/iklan-ayla.webp') }}" class="d-block w-100" alt="{{ asset('UIUX/IMG/iklan-ayla.webp') }}">
                        </div>
                        <div class="carousel-item" data-bs-interval="2000">
                        <img src="{{ asset('UIUX/IMG/iklan-xenia.webp') }}" class="d-block w-100" alt="{{ asset('UIUX/IMG/iklan-xenia.webp') }}">
                        </div>
                        <div class="carousel-item" data-bs-interval="2000">
                        <img src="{{ asset('UIUX/IMG/iklan-rocky.webp') }}" class="d-block w-100" alt="{{ asset('UIUX/IMG/iklan-rocky.webp') }}">
                        </div>
                        <div class="carousel-item" data-bs-interval="2000">
                        <img src="{{ asset('UIUX/IMG/iklan-sirion.webp') }}" class="d-block w-100" alt="{{ asset('UIUX/IMG/iklan-sirion.webp') }}">
                        </div>
                    </div>

                    {{-- ini button panah untuk geser --}}
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="h3 text-center fw-bold text-decoration-underline">SEJARAH PERUSAHAAN</h3>
                        </div>
                        <div class="col-12 text-start bg-logoTunas">
                            <p class="text-align-justify fs-6 fw-bold">&ensp;&ensp;&ensp;&ensp;&ensp;PT Tunas Ridean ("Tunas Group") terlahir sebagai perusahaan keluarga bernama Tunas Indonesia Motor pada tahun 1967 sebagai importir dan penjualan mobil baru maupun bekas. Pada tahun 1980, grup mengintegrasikan seluruh bisnis unit ke dalam satu Perseroan induk PT Tunas Ridean.</p> <br>
                            <p class="text-align-justify fs-6 fw-bold">&ensp;&ensp;&ensp;&ensp;&ensp;Tunas Daihatsu berdiri sejak 1970 dan bagian dari Tunas Group selalu berkomitmen untuk memberikan produk yang berkualitas kepada konsumen mereka. Penggunaan bahan material berkualitas, proses pengerjaan dengan standar tinggi hingga quality control yang ketat menjamin mobil Daihatsu yang akan konsumen terima terjaga dalam kondisi yang prima dan optimal.</p>
                        </div>
                        <div class="col-12">
                            <img src="{{ asset('UIUX/IMG/daihatsu-jargon.webp') }}" class="float-end d-block w-25" alt="{{ asset('UIUX/IMG/daihatsu-jargon.webp') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-- TAG OUR PRODUCT --}}
    <div class="row mt-5 mb-3" id="Our-Product">
        <div class="d-flex justify-content-center">
            <span class="fs-3 text-center badge bg-info text-dark fw-bold" style="width: 16rem; height: 3rem;" >OUR PRODUCT</span>
        </div>
    </div>
{{-- FOTO FOTO MOBILNYA --}}
    <div class="row justify-content-center">
        @foreach ($Products as $item)
            <div class="col-12 col-lg-3 mb-3">
                <div class="card border border-0 mx-auto" style="width: 18rem; height:18rem;" >
                    <a href="{{ url('/our-product'.'/'. $item->nama) }}">
                        <img src="{{ asset('UIUX/IMG/' . $item->nama . '.webp') }}"  class="card-img-top" alt="{{ asset('UIUX/IMG/' . $item->nama . '.webp') }}">
                    </a>
                </div>
            </div>
        @endforeach
    </div>
{{-- TAMPILAN UNTUK SPK --}}
    <div class="row justify-content-center mx-auto" id="Recomendasi-card">
        <div class="col-12 text-center mb-3">
            <span class="fs-3 mb-3 text-center badge bg-info text-dark fw-bold" style="width: 21rem; height: 3rem;" >BANTU SAYA MEMILIH</span>
            <p class="text-center fs-5">Beri tahu kami apa yang Anda butuhkan. Kami membantu Anda memilih produk yang tepat.</p>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ url('/save-rekomendasi') }}" method="POST" enctype="multipart/form-data" onsubmit="DisabledButtomSubmit()">
                    {{-- <form enctype="multipart/form-data" onsubmit="SubmitRekomendasi(event)"> --}}
                        @csrf
                        <div class="row">
                            <div class="col-12 col-lg-6 mb-lg-3">
                                <ul>
                                    <li class="fw-bold fs-6">Nama Anda<sup class="text-danger">*</sup></li>
                                    <li class="list-unstyled">
                                        <input class="form-control" type="text" placeholder="Nama Anda" aria-label="Nama Anda example" required>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-12 col-lg-6 mb-lg-3">
                                <ul>
                                    <li class="fw-bold fs-6">Nomor Telp<sup class="text-danger">*</sup></li>
                                    <li class="list-unstyled">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">+62 </span>
                                            <input type="number" class="form-control" placeholder="No-telp" required>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-12 col-lg-6 mb-lg-3">
                                <ul>
                                    <li class="fw-bold fs-6">Pilih mobil yang diinginkan (Pilih 2 mobil)<sup class="text-danger">*</sup></li>
                                    <li class="list-unstyled">
                                        <select class="form-select js-example-basic-multiple-limit" name="tipe_mobil[]" id="tipe_mobil" multiple="multiple" required>
                                            @foreach ($Products as $product)
                                                <option value="{{ $product->nama }}">Daihatsu {{ $product->nama }}</option>
                                            @endforeach
                                        </select>
                                        <script>
                                            $(document).ready(function() {
                                                $('.js-example-basic-multiple-limit').select2({maximumSelectionLength: 2});
                                            });
                                        </script>
                                    </li>
                                </ul>
                            </div>
                            @foreach ($data as $item)
                                <?php $itemsArray = explode(', ', $item->jawaban)  ?>
                                <div class="col-12 col-lg-6 mb-lg-3">
                                    <ul>
                                        <li class="fw-bold fs-6"> {{ $item->pertanyaan }} <sup class="text-danger">*</sup></li>
                                        <li class="list-unstyled">
                                            <select class="form-select" name="{{ $item->pertanyaan }}" id="cars" required>
                                                <option value="" disabled selected>-- Pilih --</option>
                                                @foreach ($itemsArray as $jawab)
                                                    <option value="{{ $loop->iteration }}">{{ $jawab }}</option>
                                                @endforeach
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                            @endforeach
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
@endsection
