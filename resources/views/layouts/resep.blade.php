<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Flavora')</title>
    <!-- Fonts and Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('delfood-1.0.0/css/style1.css') }}">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" integrity="sha256-mLBIhmBvigTFWPSCtvdu6a76T+3Xyt+K571hupeFLg4=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" integrity="sha256-UK1EiopXIL+KVhfbFa8xrmAWPeBjMVdvYMYkTAEv/HI=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" integrity="undefined" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include CSS untuk Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <link href="{{ asset('delfood-1.0.0/css/responsive.css') }}" rel="stylesheet" />
    @stack('styles')
    <style>
        .dropdown-menu {
            min-width: 150px; /* Mengubah lebar dropdown */
        }

        .dropdown-item {
            font-size: 14px; /* Mengubah ukuran font item */
            padding: 8px 12px; /* Mengubah padding item */
        }
        
        .ingredient-group h5 {
            margin-bottom: 5px; /* Mengurangi jarak bawah huruf kapital */
        }

        .ingredient-group .row {
            margin-top: 0; /* Menghilangkan jarak atas row */
        }

        .ingredient-group .col-12 {
            margin-bottom: 2px; /* Mengurangi jarak antara bahan */
        }

        .ingredient-group {
            margin-bottom: 10px; /* Mengurangi jarak antar grup huruf */
        }
    </style>
</head>
<body>
    <!-- Include header -->
    @include('partials.headersubcategories')
    <!-- Main Content -->
    <div class="container">
        @yield('content')
    </div>
    <!-- Include footer -->
    @include('partials.footer')
    <!-- Scripts -->
    <script src="{{ asset('delfood-1.0.0/js/jquery-3.4.1.min.js') }}" defer></script>
    <script src="{{ asset('delfood-1.0.0/js/bootstrap.js') }}" defer></script>
    <script src="{{ asset('delfood-1.0.0/js/custom.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js" integrity="sha256-Zr3vByTlMGQhvMfgkQ5BtWRSKBGa2QlspKYJnkjZTmo=" crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Include JS untuk Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    @stack('scripts')
</body>
</html>
