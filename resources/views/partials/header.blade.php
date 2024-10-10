<div class="hero_area" style="position: relative;">
  <!-- header section starts -->
  <header class="header_section" style="position: relative;">
    <img src="{{ asset('delfood-1.0.0/images/hero-bg.jpg') }}" alt="Delfood" style="width: 100%; height: auto; position: absolute; top: 0; left: 0; z-index: 0;">
    
    <div class="container-fluid" style="position: relative; z-index: 1;">
      <nav class="navbar navbar-expand-lg custom_nav-container">
        <a class="navbar-brand" href="{{ url('/') }}">
          <span>Flavora</span>
        </a>

        <!-- Navbar bagian Kategori Makanan, Bahan, Tips, dll (disembunyikan di desktop) -->
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Resep Makanan
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <div class="d-flex flex-column">
                  <h6 class="dropdown-header">Kategori Makanan</h6>
                  <a class="dropdown-item" href="{{ url('/recipes/category/makanan-utama') }}">Makanan Utama</a>
                  <a class="dropdown-item" href="{{ url('/recipes/category/makanan-pembuka') }}">Makanan Pembuka</a>
                  <a class="dropdown-item" href="{{ url('/recipes/category/makanan-penutup') }}">Makanan Penutup</a>

                  <h6 class="dropdown-header">Cara Memasak</h6>
                  <a class="dropdown-item" href="{{ url('/recipes/cara-memasak/goreng') }}">Goreng</a>
                  <a class="dropdown-item" href="{{ url('/recipes/cara-memasak/rebus') }}">Rebus</a>
                  <a class="dropdown-item" href="{{ url('/recipes/cara-memasak/panggang') }}">Panggang</a>

                  <h6 class="dropdown-header">Bahan Makanan</h6>
                  <a class="dropdown-item" href="{{ url('/recipes/bahan/ayam') }}">Ayam</a>
                  <a class="dropdown-item" href="{{ url('/recipes/bahan/daging') }}">Daging</a>
                  <a class="dropdown-item" href="{{ url('/recipes/bahan/sayuran') }}">Sayuran</a>
                  <a class="dropdown-item" href="{{ url('/recipes/bahan/jamur') }}">Jamur</a>

                  <h6 class="dropdown-header">Rekomendasi</h6>
                  <a class="dropdown-item" href="{{ url('/recipes/populer') }}">Resep Populer</a>
                  <a class="dropdown-item" href="{{ url('/recipes/favorit') }}">Resep Favorit</a>
                  <a class="dropdown-item" href="{{ url('/recipes/terbaru') }}">Resep Terbaru</a>
                  <a class="dropdown-item" href="{{ url('/recipes/teruji') }}">Resep Teruji</a>
                </div>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link text-white" href="{{ url('/bahan') }}">Bahan Makanan</a>
            </li>

            <li class="nav-item">
              <a class="nav-link text-white" href="{{ url('/tipsandtrik') }}">Tips & Triks</a>
            </li>
          </ul>
        </div>

        <div class="custom_menu-btn">
          <button onclick="openNav()">
            <img src="{{ asset('delfood-1.0.0/images/menu.png') }}" alt="Menu">
          </button>
        </div>

        <div class="User_option">
          @auth
            <span class="navbar-text" style="color: white; margin-right: 10px;">
              {{ Auth::user()->name }}
            </span>
            
            <!-- Logout Form -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>

            <a href="#" class="btn btn-outline-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
            <a href="{{ url('/bahan') }}">Bahan Makanan</a>
            <a href="{{ url('/tipsandtrik') }}">Tips & Trik</a>
            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header">Kategori Makanan</h6>
            <a class="dropdown-item" href="{{ url('/recipes/category/makanan-utama') }}">Makanan Utama</a>
            <a class="dropdown-item" href="{{ url('/recipes/category/makanan-pembuka') }}">Makanan Pembuka</a>
            <a class="dropdown-item" href="{{ url('/recipes/category/makanan-penutup') }}">Makanan Penutup</a>
            <h6 class="dropdown-header">Cara Memasak</h6>
            <a class="dropdown-item" href="{{ url('/recipes/cara-memasak/goreng') }}">Goreng</a>
            <a class="dropdown-item" href="{{ url('/recipes/cara-memasak/rebus') }}">Rebus</a>
            <a class="dropdown-item" href="{{ url('/recipes/cara-memasak/panggang') }}">Panggang</a>
            <h6 class="dropdown-header">Bahan Makanan</h6>
            <a class="dropdown-item" href="{{ url('/recipes/bahan/ayam') }}">Ayam</a>
            <a class="dropdown-item" href="{{ url('/recipes/bahan/daging') }}">Daging</a>
            <a class="dropdown-item" href="{{ url('/recipes/bahan/sayuran') }}">Sayuran</a>
            <a class="dropdown-item" href="{{ url('/recipes/bahan/jamur') }}">Jamur</a>
            <h6 class="dropdown-header">Rekomendasi</h6>
            <a class="dropdown-item" href="{{ url('/recipes/populer') }}">Resep Populer</a>
            <a class="dropdown-item" href="{{ url('/recipes/favorit') }}">Resep Favorit</a>
            <a class="dropdown-item" href="{{ url('/recipes/terbaru') }}">Resep Terbaru</a>
            <a class="dropdown-item" href="{{ url('/recipes/teruji') }}">Resep Teruji</a>
          </div>
        </div>
      </nav>
    </div>
  </header>
</div>
