@extends('New-Template')
@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-7">
        <div class="card my-5">
            <div class="card-body">
                <form action="{{ url('/rekomendasi/simpan') }}" method="POST" enctype="multipart/form-data" onsubmit="DisabledButtomSubmit()">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <ul>
                                    <li class="fw-bold fs-6">Nama Anda</li>
                                    <li class="list-unstyled"> <input class="form-control form-control-sm" type="text" placeholder="Default input" aria-label="default input example"> </li>
                                </ul>
                                <ul>
                                    <li class="fw-bold fs-6">Nomor Telp</li>
                                    <li class="list-unstyled"> <input class="form-control form-control-sm" type="text" placeholder="Default input" aria-label="default input example"> </li>
                                </ul>
                            </div>
                            <div class="col-12 mb-3">
                                <ul>
                                    <li class="fw-bold fs-6">Pilih mobil yang diinginkan (Pilih 2 mobil)</li>
                                    <li class="list-unstyled">
                                        <select class="form-select js-example-basic-multiple-limit" name="cars[]" id="cars" multiple="multiple">
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
                                <div class="col-12 mb-3">
                                    <ul>
                                        <li class="fw-bold fs-6"> {{ $item->pertanyaan }} <sup class="text-danger">*</sup></li>
                                    </ul>
                                    <?php $itemsArray = explode(', ', $item->jawaban)  ?>
                                    @foreach ($itemsArray as $jawab)
                                        <div class="form-check ms-4">
                                            <input class="form-check-input" type="radio" value="{{ $loop->iteration }}" name="{{ $item->kode }}" id="{{ $item->kode }}{{ $loop->iteration }}">
                                            <label class="form-check-label" for="{{ $item->kode }}{{ $loop->iteration }}">{{ $jawab }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-12 d-grid mx-auto">
                                <button type="submit" id="submit" class="btn btn-primary">
                                    <svg height="1em" viewBox="0 0 448 512">
                                    <style>svg{fill:#ffffff}</style>
                                    <path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V173.3c0-17-6.7-33.3-18.7-45.3L352 50.7C340 38.7 323.7 32 306.7 32H64zm0 96c0-17.7 14.3-32 32-32H288c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V128zM224 288a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/>
                                    </svg> SUBMIT
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
