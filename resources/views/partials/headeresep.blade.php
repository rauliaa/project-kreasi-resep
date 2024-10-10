<body class="sub_page">

  <div class="hero_area">
    <!-- header section starts -->
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container">
          <a class="navbar-brand" href="{{ url('/recipes') }}">
            <span>Flavora</span>
          </a>

         <!-- Navbar bagian Kategori Makanan, Bahan, Tips, dll -->
<div class="collapse navbar-collapse" id="navbarNavDropdown">
  <ul class="navbar-nav">

    <!-- Dropdown Resep Makanan -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Resep Makanan
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <div class="d-flex flex-row justify-content-between">
          <div class="mr-3">
            <h6 class="dropdown-header">Kategori Makanan</h6>
            <a class="dropdown-item" href="{{ url('/recipes/category/makanan-utama') }}">Makanan Utama</a>
            <a class="dropdown-item" href="{{ url('/recipes/category/makanan-pembuka') }}">Makanan Pembuka</a>
            <a class="dropdown-item" href="{{ url('/recipes/category/makanan-penutup') }}">Makanan Penutup</a>
          </div>

          <div class="mr-3">
            <h6 class="dropdown-header">Cara Memasak</h6>
            <a class="dropdown-item" href="{{ url('/recipes/cara-memasak/goreng') }}">Goreng</a>
            <a class="dropdown-item" href="{{ url('/recipes/cara-memasak/rebus') }}">Rebus</a>
            <a class="dropdown-item" href="{{ url('/recipes/cara-memasak/panggang') }}">Panggang</a>
          </div>

          <div class="mr-3">
            <h6 class="dropdown-header">Bahan Makanan</h6>
            <a class="dropdown-item" href="{{ url('/recipes/bahan/ayam') }}">Ayam</a>
            <a class="dropdown-item" href="{{ url('/recipes/bahan/daging') }}">Daging</a>
            <a class="dropdown-item" href="{{ url('/recipes/bahan/sayuran') }}">Sayuran</a>
            <a class="dropdown-item" href="{{ url('/recipes/bahan/Jamur') }}">Jamur</a>
          </div>

          <div>
            <h6 class="dropdown-header">Rekomendasi</h6>
            <a class="dropdown-item" href="{{ url('/recipes/populer') }}">Resep Populer</a>
            <a class="dropdown-item" href="{{ url('/recipes/favorit') }}">Resep Favorit</a>
            <a class="dropdown-item" href="{{ url('/recipes/terbaru') }}">Resep Terbaru</a>
            <a class="dropdown-item" href="{{ url('/recipes/teruji') }}">Resep Teruji</a>
          </div>
        </div>
      </div>
    </li>

    <!-- Bahan Makanan -->
    <li class="nav-item">
      <a class="nav-link text-white" href="{{ url('/bahan') }}">Bahan Makanan</a>
    </li>

    <!-- Kuliner -->
    <li class="nav-item">
      <a class="nav-link text-white" href="{{ url('/tipsandtrik') }}">Tips & Triks</a>
    </li>
  </ul>
</div>
<!-- End Navbar bagian Kategori -->


          <!-- Pencarian dan menu lainnya -->
          <div class="d-flex align-items-center">
            <!-- Form pencarian -->
            <div class="search-container" style="display: none;">
              <form class="form-inline">
                <input type="search" placeholder="Search" class="form-control mr-2" />
                <button class="btn nav_search-btn" type="submit">
                  <i class="fa fa-search" aria-hidden="true"></i>
                </button>
              </form>
            </div>
            <button class="btn nav_search-toggle" onclick="toggleSearch()">
              <i class="fa fa-search" aria-hidden="true" id="searchIcon"></i>
            </button>

            <div class="custom_menu-btn">
              <button onclick="openNav()">
                <img src="{{ asset('delfood-1.0.0/images/menu.png') }}" alt="Menu">
              </button>
            </div>
          </div>

          <!-- User Option -->
          <div class="User_option">
            @auth
              <span class="navbar-text" style="color: white;">
                {{ Auth::user()->name }}
              </span>
              
              <!-- Tambahkan form logout dengan metode POST -->
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>

              <!-- Tombol logout yang menggunakan form POST -->
              <a href="#" class="btn btn-outline-danger ml-2" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Keluar
              </a>

            @else
              <a href="{{ route('login') }}" class="btn btn-outline-primary">
                <i class="fa fa-user" aria-hidden="true"></i>
                Masuk
              </a>
            @endauth
          </div>

          <div id="myNav" class="overlay">
            <div class="overlay-content">
              <a href="{{ url('/') }}">Beranda</a>
              <a href="{{ url('/recipes') }}">Resep</a>
              <a href="{{ url('/blog') }}">Kategori Resep</a>
              <a href="{{ url('/tips') }}">Tips & Trik</a>
            </div>
          </div>
        </nav>
      </div>
    </header>
    <!-- end header section -->
  </div>

  <script>
    function toggleSearch() {
      const searchContainer = document.querySelector('.search-container');
      const searchIcon = document.getElementById('searchIcon');

      // Tampilkan atau sembunyikan kotak pencarian
      if (searchContainer.style.display === 'none' || searchContainer.style.display === '') {
        searchContainer.style.display = 'flex';
        searchIcon.classList.remove('fa-search'); // Hapus ikon pencarian
        searchIcon.classList.add('fa-times'); // Ganti dengan ikon close
      } else {
        searchContainer.style.display = 'none';
        searchIcon.classList.remove('fa-times'); // Hapus ikon close
        searchIcon.classList.add('fa-search'); // Kembali ke ikon pencarian
      }
    }
  </script>

</body>
