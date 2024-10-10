@extends('layouts.resep') <!-- Pastikan layout ini sudah sesuai dengan style yang kamu inginkan -->

@section('title', 'Flavora - All Resep!')

@section('content')
<div class="container">
    <div class="heading_container heading_center mb-4">
        <h2>Semua Resep</h2>
    </div>
    
    <div class="row">
        @foreach ($recipes as $recipe) 
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="{{ $recipe->image }}" class="card-img-top" alt="{{ $recipe->title }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $recipe->title }}</h5>
                    <p class="card-text">{{ Str::limit($recipe->description, 50) }}</p>
                    <p class="text-muted"><strong>Kategori:</strong> {{ $recipe->categories->pluck('name')->implode(', ') }}</p>
                </div>
                <div class="card-footer">
                    <small class="text-muted">
                        <i class="fa fa-clock-o"></i> {{ $recipe->prep_time }} menit |
                        <i class="fa fa-star"></i> {{ $recipe->rating ?? '4.0' }}
                    </small>
                    <a href="{{ route('recipes.show', $recipe->id) }}" class="btn btn-primary float-end">Lihat Resep</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
