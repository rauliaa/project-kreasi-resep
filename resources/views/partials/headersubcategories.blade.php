<body class="sub_page">

  <div class="hero_area">
    <!-- header section starts -->
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container">
          <a class="navbar-brand" href="{{ url('/') }}">
            <span>Flavora</span>
          </a>

          <style>
            .navbar-toggler {
              border-color: rgba(255, 255, 255, 0.1); /* Warna border tombol */
            }

            .navbar-toggler-icon {
              background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba%28255, 255, 255, 1%29' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
              /* Warna ikon hamburger */
            }

            .dropdown-menu {
              min-width: 150px; /* Mengubah lebar dropdown */
            }

            .dropdown-item {
              font-size: 14px; /* Mengubah ukuran font item */
              padding: 8px 12px; /* Mengubah padding item */
            }

          </style>

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
                      <h6 class="dropdown-header">Jenis Hidangan</h6>
                      <a class="dropdown-item" href="{{ route('recipes.byType', 'Makanan Utama') }}">Makanan Utama</a>
                      <a class="dropdown-item" href="{{ route('recipes.byType', 'Makanan Pembuka') }}">Makanan Pembuka</a>
                      <a class="dropdown-item" href="{{ route('recipes.byType', 'Makanan Pendamping') }}">Makanan Pendamping</a>
                      <a class="dropdown-item" href="{{ route('recipes.byType', 'Makanan Penutup') }}">Makanan Penutup</a>
                    </div>

                    <div class="mr-3">
                      <h6 class="dropdown-header">Cara Memasak</h6>
                      <a class="dropdown-item" href="{{ route('recipes.byMethod', 'Serba Goreng') }}">Serba Goreng</a>
                      <a class="dropdown-item" href="{{ route('recipes.byMethod', 'Serba Rebus') }}">Serba Rebus</a>
                      <a class="dropdown-item" href="{{ route('recipes.byMethod', 'Serba Panggang & Bakar') }}">Serba Panggang & Bakar</a>
                      <a class="dropdown-item" href="{{ route('recipes.byMethod', 'Serba Kukus') }}">Serba Kukus</a>
                      <a class="dropdown-item" href="{{ route('recipes.byMethod', 'Serba Tumis') }}">Serba Tumis</a>
                    </div>

                    <div class="mr-3">
                      <h6 class="dropdown-header">Bahan Makanan</h6>
                      <a class="dropdown-item" href="{{ route('recipes.byIngredient', 'Ayam') }}">Ayam</a>
                      <a class="dropdown-item" href="{{ route('recipes.byIngredient', 'Daging') }}">Daging</a>
                      <a class="dropdown-item" href="{{ route('recipes.byIngredient', 'Sayuran') }}">Sayuran</a>
                      <a class="dropdown-item" href="{{ route('recipes.byIngredient', 'Jamur') }}">Jamur</a>
                      <a class="dropdown-item" href="{{ route('recipes.byIngredient', 'Ikan & Seafood') }}">Ikan & Seafood</a>
                      <a class="dropdown-item" href="{{ route('recipes.byIngredient', 'Bebek') }}">Bebek</a>
                      <a class="dropdown-item" href="{{ route('recipes.byIngredient', 'Nasi & Karbohidrat') }}">Nasi & Karbohidrat</a>
                    </div>

                    <div class="mr-3">
                      <h6 class="dropdown-header">Kategori Khas</h6>
                      <a class="dropdown-item" href="{{ route('recipes.byCuisine', 'Makanan Tradisional') }}">Makanan Tradisional</a>
                      <a class="dropdown-item" href="{{ route('recipes.byCuisine', 'Makanan Internasional') }}">Makanan Internasional</a>
                      <a class="dropdown-item" href="{{ route('recipes.byCuisine', 'Makanan Cepat Saji') }}">Makanan Cepat Saji</a>
                    </div>

                    <div class="mr-3">
                      <h6 class="dropdown-header">Tujuan Makanan</h6>
                      <a class="dropdown-item" href="{{ route('recipes.byPurpose', 'Makanan Diet/Sehat') }}">Makanan Diet/Sehat</a>
                      <a class="dropdown-item" href="{{ route('recipes.byPurpose', 'Makanan Anak') }}">Makanan Anak</a>
                    </div>

                    <div class="mr-3">
                      <h6 class="dropdown-header">Rekomendasi Resep</h6>
                      <a class="dropdown-item" href="{{ route('recipes.byRecommendation', 'Resep Populer') }}">Resep Populer</a>
                      <a class="dropdown-item" href="{{ route('recipes.byRecommendation', 'Resep Favorit') }}">Resep Favorit</a>
                      <a class="dropdown-item" href="{{ route('recipes.byRecommendation', 'Resep Terbaru') }}">Resep Terbaru</a>
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

          <!-- User Option -->
          <div class="User_option">
            @auth
              <span class="navbar-text" style="color: white;">
                {{ Auth::user()->name }}
              </span>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>

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

          <!-- Tombol Hamburger untuk Mobile -->
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>
        </nav>
      </div>
    </header>
    <!-- end header section -->
  </div>

  <script>
    function toggleSearch() {
      const searchContainer = document.querySelector('.search-container');
      const searchIcon = document.getElementById('searchIcon');

      if (searchContainer.style.display === 'none' || searchContainer.style.display === '') {
        searchContainer.style.display = 'flex';
        searchIcon.classList.remove('fa-search');
        searchIcon.classList.add('fa-times');
      } else {
        searchContainer.style.display = 'none';
        searchIcon.classList.remove('fa-times');
        searchIcon.classList.add('fa-search');
      }
    }
  </script>

</body>