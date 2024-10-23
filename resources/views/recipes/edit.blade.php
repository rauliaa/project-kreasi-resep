@extends('layouts.resep')

@section('content')
<div class="container">
    <h2>Edit Resep</h2>
    
    <form action="{{ route('recipes.update', $recipe->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Judul Resep:</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $recipe->title }}" required>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi:</label>
            <textarea name="description" id="description" class="form-control" rows="5" required>{{ $recipe->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="ingredients">Bahan-bahan:</label>
            <textarea name="ingredients" id="ingredients" class="form-control" rows="3" required>{{ $recipe->ingredients }}</textarea>
        </div>

        <div class="form-group">
            <label for="steps">Langkah-langkah:</label>
            <textarea name="steps" id="steps" class="form-control" rows="3" required>{{ $recipe->steps }}</textarea>
        </div>

        <div class="form-group">
            <label for="image">Gambar Resep (Opsional):</label>
            <input type="file" name="image" id="image" class="form-control">
            @if($recipe->image)
                <p>Gambar saat ini: <img src="{{ asset('images/' . $recipe->image) }}" width="100"></p>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection
