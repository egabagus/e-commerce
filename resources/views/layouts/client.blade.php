<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'K UI') }}</title>

    <!-- Fonts -->
    <link href="{{ asset('assets/font-awesome/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />

    <!-- Styles -->
    <style>
        [x-cloak] {
            display: none;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link href="{{ asset('assets/sweetallert/sweetalert2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/datatables5/dataTables.bootstrap5.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/select2/select2-bootstrap.min.css') }}" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">



    <!-- Page Heading -->
    <div class="container">
        <header
            class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
            <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
                <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                    <use xlink:href="#bootstrap" />
                </svg>
            </a>

            <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                <li><a href="#" class="nav-link px-2 link-secondary">Home</a></li>
                <li><a href="#" class="nav-link px-2 link-dark">Features</a></li>
                <li><a href="#" class="nav-link px-2 link-dark">Pricing</a></li>
                <li><a href="#" class="nav-link px-2 link-dark">FAQs</a></li>
                <li><a href="#" class="nav-link px-2 link-dark">About</a></li>
            </ul>

            @if (Route::has('login'))
                <div class="col-md-3 text-end">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn bg-sky-800 text-white hover:bg-sky-900">Daftar
                            Transaksi</a>
                    @else
                        <a href="{{ route('login') }}" class="bg-transparent btn hover:bg-sky-900">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="btn bg-sky-800 text-white hover:bg-sky-900">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            {{-- <div class="col-md-3 text-end">
                <button type="button" class="btn btn-outline-primary me-2">Login</button>
                <button type="button" class="btn btn-primary">Sign-up</button>
            </div> --}}
        </header>
    </div>

    <!-- Page Content -->
    <main class="px-4 mx-5 sm:px-6 flex-1">
        {{ $slot }}
    </main>
    <script src="{{ asset('assets/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/sweetallert/sweetalert2.all.min.js') }}"></script>

    <script src="{{ asset('assets/datatables5/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/datatables5/dataTables.js') }}"></script>
    <script src="{{ asset('assets/datatables5/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/select2/select2.min.js') }}"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
</body>
@include('utils.master')
@include('utils.loading')
@include('utils.error')

</html>
