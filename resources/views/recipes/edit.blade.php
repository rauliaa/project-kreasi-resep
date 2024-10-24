@extends('layouts.resep')
@section('title', 'Edit Resep')
@section('content')
<div class="container mt-5">
    <div class="card shadow-sm rounded-lg">
        <div class="card-body">
            <h3 class="mb-4">Edit Resep</h3>

            <!-- Form Edit Resep -->
            <form action="{{ route('recipes.update', $recipe->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="title">Judul Resep</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $recipe->title }}" placeholder="Masukkan judul resep" required>
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Deskripsi resep" required>{{ $recipe->description }}</textarea>
                </div>

                <div class="form-group">
                    <label for="ingredients">Bahan-Bahan</label>
                    <div id="ingredients-container">
                        @foreach($recipe->ingredients as $ingredient)
                            <input type="text" class="form-control mb-2" name="ingredients[]" value="{{ $ingredient->description }}" placeholder="Bahan" required>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-secondary mt-2" id="add-ingredient">Tambah Bahan</button>
                </div>

                <div class="form-group">
                    <label for="instructions">Instruksi Memasak</label>
                    <textarea class="form-control" id="instructions" name="instructions" rows="4" placeholder="Langkah-langkah memasak" required>{{ $recipe->instructions }}</textarea>
                </div>

                <div class="form-group">
                    <label for="prep_time">Waktu Persiapan (menit)</label>
                    <input type="number" class="form-control" id="prep_time" name="prep_time" value="{{ $recipe->prep_time }}" required>
                </div>

                <div class="form-group">
                    <label for="cook_time">Waktu Memasak (menit)</label>
                    <input type="number" class="form-control" id="cook_time" name="cook_time" value="{{ $recipe->cook_time }}" required>
                </div>

                <div class="form-group">
                    <label for="price">Harga (Rp)</label>
                    <input type="number" class="form-control" id="price" name="price" value="{{ $recipe->price }}" required>
                </div>

                <div class="form-group">
                    <label for="servings">Jumlah Porsi</label>
                    <input type="number" class="form-control" id="servings" name="servings" value="{{ $recipe->servings }}" required>
                </div>

                <div class="form-group">
                    <label for="recipe_category">Kategori Resep</label>
                    <select id="recipe_category" class="form-control" name="recipe_category" required>
                        <option value="" disabled>Pilih kategori resep</option>
                        <option value="goreng" {{ $recipe->recipe_category == 'goreng' ? 'selected' : '' }}>Serba Goreng</option>
                        <option value="rebus" {{ $recipe->recipe_category == 'rebus' ? 'selected' : '' }}>Serba Rebus</option>
                        <option value="panggang" {{ $recipe->recipe_category == 'panggang' ? 'selected' : '' }}>Serba Panggang & Bakar</option>
                        <option value="kukus" {{ $recipe->recipe_category == 'kukus' ? 'selected' : '' }}>Serba Kukus</option>
                        <option value="tumis" {{ $recipe->recipe_category == 'tumis' ? 'selected' : '' }}>Serba Tumis</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="food_category">Kategori Makanan</label>
                    <select id="food_category" class="form-control" name="food_category" required>
                        <option value="" disabled>Pilih kategori makanan</option>
                        <option value="pendamping" {{ $recipe->food_category == 'pendamping' ? 'selected' : '' }}>Makanan Pendamping</option>
                        <option value="utama" {{ $recipe->food_category == 'utama' ? 'selected' : '' }}>Makanan Utama</option>
                        <option value="pembuka" {{ $recipe->food_category == 'pembuka' ? 'selected' : '' }}>Makanan Pembuka</option>
                        <option value="penutup" {{ $recipe->food_category == 'penutup' ? 'selected' : '' }}>Makanan Penutup</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="cuisine">Masakan Apa</label>
                    <select id="cuisine" class="form-control" name="cuisine" required>
                        <option value="" disabled>Pilih jenis masakan</option>
                        <option value="cepat_saji" {{ $recipe->cuisine == 'cepat_saji' ? 'selected' : '' }}>Makanan Cepat Saji</option>
                        <option value="internasional" {{ $recipe->cuisine == 'internasional' ? 'selected' : '' }}>Makanan Internasional</option>
                        <option value="tradisional" {{ $recipe->cuisine == 'tradisional' ? 'selected' : '' }}>Makanan Tradisional</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="purpose">Tujuan</label>
                    <select id="purpose" class="form-control" name="purpose" required>
                        <option value="" disabled>Pilih tujuan</option>
                        <option value="sehat" {{ $recipe->purpose == 'sehat' ? 'selected' : '' }}>Makanan Sehat / Diet</option>
                        <option value="anak" {{ $recipe->purpose == 'anak' ? 'selected' : '' }}>Makanan Anak</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="image">Upload Gambar</label>
                    <input type="file" class="form-control-file" id="image" name="image">
                    <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                </div>

                <button type="submit" class="btn btn-primary">Update Resep</button>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('add-ingredient').addEventListener('click', function() {
            const ingredientsContainer = document.getElementById('ingredients-container');
            const newIngredient = document.createElement('input');
            newIngredient.type = 'text';
            newIngredient.className = 'form-control mb-2';
            newIngredient.name = 'ingredients[]';
            newIngredient.placeholder = 'Bahan ' + (ingredientsContainer.children.length + 1);
            newIngredient.required = true; // Pastikan input baru juga required
            
            // Tambahkan input baru ke kontainer
            ingredientsContainer.appendChild(newIngredient);
        });
    });
</script>
@endsection
@endsection
