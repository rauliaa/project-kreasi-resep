@extends('layouts.resep')
@section('title', 'Tambah Resep Baru')
@section('content')
<div class="container mt-5">
    <div class="card shadow-sm rounded-lg">
        <div class="card-body">
            <h3 class="mb-4">Tambah Resep Baru</h3>

            <!-- Form Tambah Resep -->
            <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Judul Resep</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Masukkan judul resep" required>
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Deskripsi resep" required></textarea>
                </div>

                <div class="form-group">
                    <label for="ingredients">Bahan-Bahan</label>
                    <div id="ingredients-container">
                        <input type="text" class="form-control mb-2" name="ingredients[]" placeholder="Bahan 1" required>
                        <input type="text" class="form-control mb-2" name="ingredients[]" placeholder="Bahan 2" required>
                        <input type="text" class="form-control mb-2" name="ingredients[]" placeholder="Bahan 3" required>
                        <input type="text" class="form-control mb-2" name="ingredients[]" placeholder="Bahan 4" required>
                    </div>
                    <button type="button" class="btn btn-secondary mt-2" id="add-ingredient">Tambah Bahan</button>
                </div>

                <div class="form-group">
                    <label for="instructions">Instruksi Memasak</label>
                    <textarea class="form-control" id="instructions" name="instructions" rows="4" placeholder="Langkah-langkah memasak" required></textarea>
                </div>

                <div class="form-group">
                    <label for="prep_time">Waktu Persiapan (menit)</label>
                    <input type="number" class="form-control" id="prep_time" name="prep_time" required>
                </div>

                <div class="form-group">
                    <label for="cook_time">Waktu Memasak (menit)</label>
                    <input type="number" class="form-control" id="cook_time" name="cook_time" required>
                </div>

                <div class="form-group">
                    <label for="price">Harga (Rp)</label>
                    <input type="number" class="form-control" id="price" name="price" required>
                </div>

                <div class="form-group">
                    <label for="servings">Jumlah Porsi</label>
                    <input type="number" class="form-control" id="servings" name="servings" required>
                </div>

                <div class="form-group">
                    <label for="recipe_category">Kategori Resep</label>
                    <select id="recipe_category" class="form-control" name="recipe_category" required>
                        <option value="" disabled selected>Pilih kategori resep</option>
                        <option value="goreng">Serba Goreng</option>
                        <option value="rebus">Serba Rebus</option>
                        <option value="panggang">Serba Panggang & Bakar</option>
                        <option value="kukus">Serba Kukus</option>
                        <option value="tumis">Serba Tumis</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="food_category">Kategori Makanan</label>
                    <select id="food_category" class="form-control" name="food_category" required>
                        <option value="" disabled selected>Pilih kategori makanan</option>
                        <option value="pendamping">Makanan Pendamping</option>
                        <option value="utama">Makanan Utama</option>
                        <option value="pembuka">Makanan Pembuka</option>
                        <option value="penutup">Makanan Penutup</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="cuisine">Masakan Apa</label>
                    <select id="cuisine" class="form-control" name="cuisine" required>
                        <option value="" disabled selected>Pilih jenis masakan</option>
                        <option value="cepat_saji">Makanan Cepat Saji</option>
                        <option value="internasional">Makanan Internasional</option>
                        <option value="tradisional">Makanan Tradisional</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="purpose">Tujuan</label>
                    <select id="purpose" class="form-control" name="purpose" required>
                        <option value="" disabled selected>Pilih tujuan</option>
                        <option value="sehat">Makanan Sehat / Diet</option>
                        <option value="anak">Makanan Anak</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="image">Upload Gambar</label>
                    <input type="file" class="form-control-file" id="image" name="image" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Resep</button>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('add-ingredient').addEventListener('click', function() {
            console.log('Tombol "Tambah Bahan" diklik'); // Umpan balik ke konsol
            const ingredientsContainer = document.getElementById('ingredients-container');
            const newIngredient = document.createElement('input');
            newIngredient.type = 'text';
            newIngredient.className = 'form-control mb-2';
            newIngredient.name = 'ingredients[]';
            newIngredient.placeholder = 'Bahan ' + (ingredientsContainer.children.length + 1);
            newIngredient.required = true; // Pastikan input baru juga required
            
            // Tambahkan input baru ke kontainer
            ingredientsContainer.appendChild(newIngredient);
            console.log('Input baru ditambahkan: ' + newIngredient.placeholder); // Umpan balik untuk input baru
        });
    });
</script>
@endsection
@endsection
