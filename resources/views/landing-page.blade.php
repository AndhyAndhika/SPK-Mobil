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
        <style>
            .img-hover:hover {
                background-color: #6a737bd2;
            }
        </style>
        @foreach ($Products as $item)
            <div class="col-12 col-lg-3 mb-3">
                <div class="card border border-0 mx-auto" style="width: 18rem; height:18rem;" >
                    <a href="{{ url('/our-product'.'/'. $item->nama) }}">
                        <img src="{{ asset('UIUX/IMG/' . $item->nama . '.webp') }}"  class="card-img-top img-hover" alt="{{ asset('UIUX/IMG/' . $item->nama . '.webp') }}">
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
                        @csrf
                        <div class="row">
                            {{-- NAMA ANDA --}}
                            <div class="col-12 col-lg-6 mb-lg-3">
                                <ul>
                                    <li class="fw-bold fs-6">Nama Anda<sup class="text-danger">*</sup></li>
                                    <li class="list-unstyled">
                                        <input class="form-control" type="text" name="nama_anda" placeholder="Nama Anda" aria-label="Nama Anda example" required>
                                    </li>
                                </ul>
                            </div>
                            {{-- NOMOR TELPON --}}
                            <div class="col-12 col-lg-6 mb-lg-3">
                                <ul>
                                    <li class="fw-bold fs-6">Nomor Telp<sup class="text-danger">*</sup></li>
                                    <li class="list-unstyled">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">+62 </span>
                                            <input type="number" name="no_telp" class="form-control" placeholder="No-telp" required>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            {{-- KAPASITAS MESIN --}}
                            <div class="col-12 col-lg-6 mb-lg-3">
                                <ul>
                                    <li class="fw-bold fs-6"> Kapasitas mesin <sup class="text-danger">*</sup></li>
                                    <li class="list-unstyled">
                                        <select class="form-select" name="kapasitas_mesin" id="kapasitas_mesin" required="">
                                            <option value="" disabled="" selected="">-- Pilih --</option>
                                                <option value="1, 0, 998">998 cc</option>
                                                <option value="2, 1197, 1198">1197 cc - 1198cc</option>
                                                <option value="3, 1298, 1329">1298 cc - 1329 cc</option>
                                                <option value="4, 1945, 1946">1945 cc - 1946 cc</option>
                                                <option value="5, 2496, 2496">2496 cc</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            {{-- KAPASITAS PENUMPANG --}}
                            <div class="col-12 col-lg-6 mb-lg-3">
                                <ul>
                                    <li class="fw-bold fs-6"> Kapasitas penumpang <sup class="text-danger">*</sup></li>
                                    <li class="list-unstyled">
                                        <select class="form-select" name="kapasitas_penumpang" id="kapasitas_penumpang" required="">
                                            <option value="" disabled="" selected="">-- Pilih --</option>
                                                <div id="option_kapasitas_penumpang"></div>
                                                {{-- <option value="1, 2">2 seat</option>
                                                <option value="2, 3">3 seat</option>
                                                <option value="3, 5">5 seat</option>
                                                <option value="4, 7">7 seat</option>
                                                <option value="5, 8">8 seat</option> --}}
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            {{-- PILIHAN MOBIL 2 MOBIL SEKALIGUS --}}
                            <div class="col-12 col-lg-6 mb-lg-3">
                                <ul>
                                    <li class="fw-bold fs-6">Pilih mobil yang diinginkan (Wajib pilih 2 mobil)<sup class="text-danger">*</sup></li>
                                    <li class="list-unstyled">
                                        <div class="row">
                                            <div id="forCheckbox"></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            {{-- KEAMANAN BERKENDARA --}}
                            <div class="col-12 col-lg-6 mb-lg-3">
                                <ul>
                                    <li class="fw-bold fs-6"> Keamanan dalam berkendara <sup class="text-danger">*</sup></li>
                                    <li class="list-unstyled">
                                        <select class="form-select" name="keamanan_dalam_berkendara" id="keamanan_dalam_berkendara" required="">
                                            <option value="" disabled="" selected="">-- Pilih --</option>
                                                <option value="1">Sangat Tidak Penting</option>
                                                <option value="2">Tidak Penting</option>
                                                <option value="3">Penting</option>
                                                <option value="4">Cukup Penting</option>
                                                <option value="5">Sangat Penting</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            {{-- INTERITOR MOBIL --}}
                            <div class="col-12 col-lg-6 mb-lg-3">
                                <ul>
                                    <li class="fw-bold fs-6"> Interior mobil <sup class="text-danger">*</sup></li>
                                    <li class="list-unstyled">
                                        <select class="form-select" name="interior_mobil" id="interior_mobil" required="">
                                            <option value="" disabled="" selected="">-- Pilih --</option>
                                                <option value="1">Sangat Tidak Penting</option>
                                                <option value="2">Tidak Penting</option>
                                                <option value="3">Penting</option>
                                                <option value="4">Cukup Penting</option>
                                                <option value="5">Sangat Penting</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            {{-- DIMENSI MOBIL --}}
                            <div class="col-12 col-lg-6 mb-lg-3">
                                <ul>
                                    <li class="fw-bold fs-6"> Dimensi mobil <sup class="text-danger">*</sup></li>
                                    <li class="list-unstyled">
                                        <select class="form-select" name="dimensi_mobil" id="dimensi_mobil" required="">
                                            <option value="" disabled="" selected="">-- Pilih --</option>
                                                <option value="1">Kecil</option>
                                                <option value="2">Sedang</option>
                                                <option value="3">Cukup Besar</option>
                                                <option value="4">Besar</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            {{-- JUMLAH KEINGINAN EKSTERIOR --}}
                            <div class="col-12 col-lg-6 mb-lg-3">
                                <ul>
                                    <li class="fw-bold fs-6"> Jumlah keinginan eksterior <sup class="text-danger">*</sup></li>
                                    <li class="list-unstyled">
                                        <select class="form-select" name="jumlah_keinginan_eksterior" id="jumlah_keinginan_eksterior" required="">
                                            <option value="" disabled="" selected="">-- Pilih --</option>
                                                <option value="1">&lt; 3 purpose</option>
                                                <option value="2">8 - 3 purpose</option>
                                                <option value="3">14 - 9 purpose</option>
                                                <option value="4">20 - 15 purpose</option>
                                                <option value="5">&gt; 20 purpose</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            {{-- JUMLAH FITUR TAMBAHAN --}}
                            <div class="col-12 col-lg-6 mb-lg-3">
                                <ul>
                                    <li class="fw-bold fs-6"> Jumlah keinginan fitur tambahan <sup class="text-danger">*</sup></li>
                                    <li class="list-unstyled">
                                        <select class="form-select" name="jumlah_keinginan_fitur_tambahan" id="jumlah_keinginan_fitur_tambahan" required="">
                                            <option value="" disabled="" selected="">-- Pilih --</option>
                                                <option value="1">&lt; 3 commodity</option>
                                                <option value="2">8 - 3 commodity</option>
                                                <option value="3">14 - 9 commodity</option>
                                                <option value="4">20 - 15 commodity</option>
                                                <option value="5">&gt; 20 commodity</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            {{-- WARNA MOBIL --}}
                            <div class="col-12 col-lg-6 mb-lg-3">
                                <ul>
                                    <li class="fw-bold fs-6"> Warna mobil <sup class="text-danger">*</sup></li>
                                    <li class="list-unstyled">
                                        <select class="form-select" name="warna_mobil" id="warna_mobil" required="">
                                            <option value="" disabled="" selected="">-- Pilih --</option>
                                                <option value="1">Sangat Tidak Penting</option>
                                                <option value="2">Tidak Penting</option>
                                                <option value="3">Penting</option>
                                                <option value="4">Cukup Penting</option>
                                                <option value="5">Sangat Penting</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            {{-- JENIS VELK --}}
                            <div class="col-12 col-lg-6 mb-lg-3">
                                <ul>
                                    <li class="fw-bold fs-6"> Jenis velg <sup class="text-danger">*</sup></li>
                                    <li class="list-unstyled">
                                        <select class="form-select" name="jenis_velg" id="jenis_velg" required="">
                                            <option value="" disabled="" selected="">-- Pilih --</option>
                                            {{--  <option value="1">Sangat Tidak Penting</option>
                                                <option value="2">Tidak Penting</option>
                                                <option value="3">Penting</option> --}} 
                                                <option value="4">Tidak Penting</option>
                                                <option value="5">Penting</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            {{-- HARGA MOBIL --}}
                            <div class="col-12 col-lg-6 mb-lg-3">
                                <ul>
                                    <li class="fw-bold fs-6"> Harga mobil <sup class="text-danger">*</sup></li>
                                    <li class="list-unstyled">
                                        <select class="form-select" name="harga_mobil" id="harga_mobil" required="">
                                            <option value="" disabled="" selected="">-- Pilih --</option>
                                                <option value="1">Sangat Tidak Penting</option>
                                                <option value="2">Tidak Penting</option>
                                                <option value="3">Penting</option>
                                                <option value="4">Cukup Penting</option>
                                                <option value="5">Sangat Penting</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            {{-- SUMBER PENDAPATAN --}}
                            <div class="col-12 col-lg-6 mb-lg-3">
                                <ul>
                                    <li class="fw-bold fs-6"> Sumber pendapatan <sup class="text-danger">*</sup></li>
                                    <li class="list-unstyled">
                                        <select class="form-select" name="sumber_pendapatan" id="sumber_pendapatan" required="">
                                            <option value="" disabled="" selected="">-- Pilih --</option>
                                            <option value="1">Tidak Bekerja</option>
                                            <option value="2">Freelance</option>
                                            <option value="3">Tabungan</option>
                                            <option value="4">Pekerjaan</option>
                                            <option value="5">Pekerjaan + Tabungan</option>
                                    </select>
                                    </li>
                                </ul>
                            </div>
                            {{-- LOKASI TINGGAL --}}
                            <div class="col-12 col-lg-6 mb-lg-3">
                                <ul>
                                    <li class="fw-bold fs-6"> Lokasi tinggal <sup class="text-danger">*</sup></li>
                                    <li class="list-unstyled">
                                        <select class="form-select" name="lokasi_tinggal" id="lokasi_tinggal" required="">
                                            <option value="" disabled="" selected="">-- Pilih --</option>
                                                <option value="1">Rumah susun</option>
                                                <option value="2">Rumah pribadi/kontrak (tidak memiliki garasi)</option>
                                                <option value="3">Rumah kontrak (memiliki garasi)</option>
                                                <option value="4">Apartemen pribadi</option>
                                                <option value="5">Rumah pribadi (memiliki garasi)</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            {{-- KEPEMILIKAN KENDARAAN --}}
                            <div class="col-12 col-lg-6 mb-lg-3">
                                <ul>
                                    <li class="fw-bold fs-6"> Kepemilikan kendaraan <sup class="text-danger">*</sup></li>
                                    <li class="list-unstyled">
                                        <select class="form-select" name="kepemilikan_kendaraan" id="kepemilikan_kendaraan" required="">
                                            <option value="" disabled="" selected="">-- Pilih --</option>
                                                <option value="1">Belum memiliki kendaraan pribadi</option>
                                                <option value="2">2-1 Kendaraan</option>
                                                <option value="3">3 Kendaraan</option>
                                                <option value="4">5-4 Kendaraan</option>
                                                <option value="5">&gt; 5 Kendaraan</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            {{-- INI BUTTON UNTUK SAVE --}}
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
                    {{-- SCRIPT JS UNTUK FILTER AWAL --}}
                    <script>
                        var raw_kapasitas_mesin;
                        var raw_kapasitas_seat;

                        $('#kapasitas_mesin').change(function(){
                            raw_kapasitas_mesin = $(this).val();
                            $('#kapasitas_penumpang option').not(':selected :disabled').remove();
                            $("#forCheckbox").html('');
                            $.ajax({
                                method: "POST",
                                dataType: "json",
                                url: "{{ url('/api/produk-filter/kapasitas_cc') }}",
                                data: {
                                    raw_kapasitas_mesin: $(this).val(),
                                },
                                success: function(respon) {
                                    console.log(respon)
                                    if(respon.data.length == 0 ){
                                        $("#kapasitas_penumpang").append('<option value="" disabled>Tidak ada data yang sesuai</option>');
                                    }else{
                                        $("#kapasitas_penumpang").append(' <option value="" disabled="" selected="">-- Pilih --</option>');
                                        for (let i = 0; i < respon.data.length; i++) {
                                            $('#kapasitas_penumpang').append('<option value="' + respon.data[i].kapasitas_orang + ', '+ respon.data[i].kode_kapasitas_orang+'">' + respon.data[i].kapasitas_orang + '</option>');
                                        }
                                    }
                                },
                                error: function(data){
                                    alert("Terjadi Error Silahkan Refesh dan Coba lagi..")
                                }
                            });

                        })

                        $('#kapasitas_penumpang').change(function(){
                            raw_kapasitas_seat = $(this).val();
                            $("#forCheckbox").html('');
                            $.ajax({
                                method: "POST",
                                dataType: "json",
                                url: "{{ url('/api/produk-filter/kapasitas_seater') }}",
                                data: {
                                    raw_kapasitas_seat: $(this).val(),
                                    raw_kapasitas_mesin: raw_kapasitas_mesin
                                },
                                success: function(respon) {
                                    if(respon.data.length == 0 ){
                                        $("#forCheckbox").html('Pilihan Tipe tidak tersedia');
                                    }else{
                                        $("#forCheckbox").html('');
                                        var myHTML = '';
                                            respon.data.forEach(element => {
                                                myHTML +=   '<div class="col">'+
                                                                    '<div class="form-check form-check-inline">'+
                                                                        '<input class="form-check-input" type="checkbox" id="'+element.nama+'" name="id_tipe_mobil[]" value="'+element.id+'">'+
                                                                        '<label class="form-check-label" for="'+element.nama+'">'+element.nama +' - '+ element.type+'</label>'+
                                                                    '</div>'+
                                                            '</div>';
                                                console.log(element.nama)
                                            });
                                        $("#forCheckbox").html(myHTML);
                                        var checks = document.querySelectorAll(".form-check-input");
                                        var max = 2;
                                        for (var i = 0; i < checks.length; i++)
                                        checks[i].onclick = selectiveCheck;
                                        function selectiveCheck (event) {
                                        var checkedChecks = document.querySelectorAll(".form-check-input:checked");
                                        if (checkedChecks.length >= max + 1)
                                            return false;
                                        }
                                    }
                                },
                                error: function(data){
                                    alert("Terjadi Error Silahkan Refesh dan Coba lagi..")
                                }
                            });
                        })
                    </script>
                </div>
            </div>
        </div>
    </div>
@endsection
