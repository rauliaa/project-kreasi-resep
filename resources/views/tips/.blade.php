@extends('layouts.tips')

@section('content')
<div class="container mb-5">
    <h1 class="text-center mt-4 mb-4">Tambah Tips</h1>

    <form action="{{ route('tips.store') }}" method="POST" enctype="multipart/form-data" class="p-4 border rounded shadow-sm" style="background-color: #f8f9fa;">
        @csrf
        <div class="form-group">
            <label for="title">Judul Tips</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="steps">Langkah-langkah</label>
            <textarea name="steps" id="steps" class="form-control" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <label for="image">Unggah Gambar</label>
            <input type="file" name="image" id="image" class="form-control" required>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('tips.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan Tips</button>
        </div>
    </form>
</div>
@endsection
