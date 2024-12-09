@extends('layouts.bahan')

@section('content')
<div class="container mt-5">
    <div class="description text-center">
        <h3 class="fw-bold">Punya bahan apa di kulkas?</h3>
        <p class="text-muted">Kami akan beri rekomendasi resep sesuai dengan bahan yang kamu punya.</p>
    </div>
    <div class="row">
        <!-- Kolom Kiri: Pencarian dan Bahan -->
        <div class="col-md-4">
            <form id="ingredient-form" class="p-4 bg-light rounded shadow">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Pilih Bahan:</label>
                    <input type="text" id="search-box" class="form-control mb-3" placeholder="Cari bahan..." />

                    <div class="ingredient-list" style="max-height: 400px; overflow-y: auto;">
                        @foreach ($groupedIngredients as $letter => $ingredientsGroup)
                            <div class="mb-3 ingredient-group" data-letter="{{ $letter }}">
                                <h5 class="fw-bold">{{ $letter }}</h5>
                                <div class="row">
                                    @foreach($ingredientsGroup as $ingredient)
                                        <div class="col-12 mb-1">
                                            <div class="form-check">
                                                <input class="form-check-input ingredient-checkbox" type="checkbox" name="ingredients[]" value="{{ $ingredient->id }}" id="ingredient-{{ $ingredient->id }}">
                                                <label class="form-check-label" for="ingredient-{{ $ingredient->id }}">
                                                    {{ $ingredient->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </form>
        </div>

        <!-- Kolom Kanan: Daftar Resep -->
        <div class="col-md-8">
            <div id="recipes-placeholder">
                <h2>Recipes will appear here based on your selected ingredients</h2>
            </div>
            <div id="recipes"></div> <!-- Di sini resep yang diambil akan ditampilkan -->
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Event listener untuk pencarian bahan
    $('#search-box').on('input', function() {
        let searchQuery = $(this).val().toLowerCase(); // Ambil query pencarian dalam huruf kecil

        // Jika kotak pencarian kosong, tampilkan semua bahan dan grup huruf
        if (searchQuery === '') {
            $('.ingredient-group').show(); // Tampilkan semua grup huruf
            $('.form-check').show(); // Tampilkan semua bahan
            $('.ingredient-list').find('.text-muted').remove(); // Hapus pesan "Bahan tidak ditemukan" jika ada
            return; // Hentikan fungsi di sini
        }

        let anyMatch = false; // Variabel untuk melacak apakah ada bahan yang cocok

        // Loop untuk setiap grup bahan
        $('.ingredient-group').each(function() {
            let group = $(this);
            let foundInGroup = false; // Untuk melacak bahan dalam grup ini

            // Periksa setiap bahan dalam grup
            group.find('.form-check').each(function() {
                let ingredientName = $(this).find('label').text().toLowerCase();
                if (ingredientName.indexOf(searchQuery) !== -1) {
                    $(this).show(); // Tampilkan bahan yang cocok
                    foundInGroup = true; // Set true jika ada bahan cocok dalam grup ini
                } else {
                    $(this).hide(); // Sembunyikan bahan yang tidak cocok
                }
            });

            // Tampilkan grup hanya jika ada bahan yang cocok di dalamnya
            if (foundInGroup) {
                group.show(); // Tampilkan grup ini
                anyMatch = true; // Set true jika ada bahan yang cocok
            } else {
                group.hide(); // Sembunyikan grup ini jika tidak ada bahan cocok
            }
        });

        // Tampilkan pesan jika tidak ada bahan yang cocok di seluruh grup
        if (!anyMatch) {
            $('.ingredient-list').find('.text-muted').remove();
            $('.ingredient-list').append('<p class="text-center text-muted">Bahan tidak ditemukan. Coba kata kunci yang lain, ya.</p>');
        } else {
            $('.ingredient-list').find('.text-muted').remove();
        }
    });

    // Event listener untuk centang bahan
    $('.ingredient-checkbox').on('change', function() {
        updateRecipeList();
    });

    function updateRecipeList() {
        let selectedIngredients = [];
        $('.ingredient-checkbox:checked').each(function() {
            selectedIngredients.push($(this).val()); // Ambil ID bahan yang dicentang
        });

        // Kirim data AJAX untuk mendapatkan resep berdasarkan bahan yang dicentang
        $.ajax({
            url: '/get-recipes',  // Ganti dengan URL rute yang sesuai di Laravel
            method: 'POST',
            data: {
                ingredients: selectedIngredients,
                _token: $('input[name="_token"]').val()  // Untuk keamanan CSRF
            },
            success: function(response) {
                displayRecipes(response);  // Tampilkan resep yang diterima dari server
            },
            error: function() {
                $('#recipes').html('<p class="text-center text-danger">Gagal memuat resep. Coba lagi nanti.</p>');
            }
        });
    }

    function displayRecipes(data) {
        let html = '';

        if (data.length === 0) {
            html = '<p class="text-center text-muted">Tidak ada resep yang cocok dengan bahan yang dipilih.</p>';
        } else {
            data.forEach(recipe => {
                html += `
                    <div class="recipe-item mb-3">
                        <h5>${recipe.name}</h5>
                        <p>Bahan yang diperlukan: ${recipe.ingredients.join(', ')}</p>
                        ${recipe.missingIngredients.length > 0 ? `<p class="text-danger">Bahan yang kurang: ${recipe.missingIngredients.join(', ')}</p>` : ''}
                    </div>
                `;
            });
        }

        $('#recipes').html(html);  // Tampilkan resep yang sesuai di elemen dengan id 'recipes'
    }
});

</script>
@endsection