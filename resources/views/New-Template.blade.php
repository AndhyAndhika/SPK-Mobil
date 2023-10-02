<!DOCTYPE html>
<html lang="en" class="notranslate">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="AndhyAndhika" />
        <meta name="author" content="AndhyAndhika" />
        <title>Tunas | Daihatsu</title>
        <link rel="icon" href="{{ asset('UIUX/IMG/logo-tunas.webp') }}">
        <link href="{{ asset('UIUX/JSCSS/bootstrap-min.css') }}" rel="stylesheet">
        <link href="{{ asset('UIUX/JSCSS/bootstrap-icons.css') }}" rel="stylesheet">
        <link href="{{ asset('UIUX/JSCSS/datatables.css') }}" rel="stylesheet">
        <link href="{{ asset('UIUX/JSCSS/select2.css') }}" rel="stylesheet">
        <link href="{{ asset('UIUX/JSCSS/self-style.css') }}" rel="stylesheet">
        <script src="{{ asset('UIUX/JSCSS/jquery-3.7.0.js') }}"></script>
        <script src="{{ asset('UIUX/JSCSS/datatables.js') }}"></script>
        <script src="{{ asset('UIUX/JSCSS/jquerydatatables.js') }}"></script>
        <script src="{{ asset('UIUX/JSCSS/select2.js') }}"></script>
    </head>
<body style="background-color: #f8f9fa">

    {{-- NAVBAR --}}
    <div id="navbar-mandiri" class="sticky-top">
        <nav class="navbar bg-body-tertiary">
            <div class="container-xxl ">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('UIUX/IMG/tunas-daihatsu.webp') }}" alt="Tunas-Daihatsu" width="210" height="40" class="d-inline-block align-text-top">
            </a>
            </div>
        </nav>
        <div class="container-xxl text-center bg-primary fs-6 pb-2">
            <nav class="nav justify-content-center nav-underline ">
                <a class="nav-link text-white" href="{{ url('/') }}">HOME</a>
                <a class="nav-link text-white" href="{{ url('/#Our-Product') }}">PRODUCT</a>
                <a class="nav-link text-white" href="{{ url('/#Recomendasi-card') }}">RECOMMEND</a>
                <a class="nav-link text-white" href="{{ url('/login') }}" >LOGIN</a>
            </nav>
        </div>
    </div>
    {{-- NAVBAR --}}


    {{-- CONTENT --}}
        <div class="container-xxl bg-white pt-3 pb-4">
            @yield('content')
        </div>
    {{-- CONTENT --}}


    {{-- FOOTER --}}
    <footer class="mt-5 mt-lg-1">
        <div class="container-xxl bg-primary fs-6 text-center text-align-center text-white fixed-bottom">
            <p class="my-1">Jl. Prof. DR. Soepomo No.31, Tebet Barat, Kec. Tebet, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12810</p>
        </div>
    </footer>
    {{-- FOOTER --}}
    @include('sweetalert::alert')
    <script src="{{ asset('UIUX/JSCSS/bootstrap-min.js') }}"></script>
    <script src="{{ asset('UIUX/JSCSS/popper-min.js') }}"></script>
    <script src="{{ asset('UIUX/JSCSS/bootstrap-bundle-min.js') }}"></script>
    <script src="{{ asset('UIUX/JSCSS/self-js.js') }}"></script>
</body>
</html>
