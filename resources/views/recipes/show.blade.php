@extends('layouts.resep')

@section('content')
    <div class="container">
        <h1>{{ $recipe->title }}</h1>

        <div class="row mb-4">
            <div class="col-md-6">
               <img src="{{ asset('delfood-1.0.0/images/' . $recipe->image) }}" alt="{{ $recipe->title }}" class="img-fluid">

                <!-- Form untuk menambahkan resep ke favorit -->
                <div class="mt-3">
                    <form action="{{ route('favorites.store', $recipe->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-warning">Simpan</button>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <p><strong>Category:</strong> {{ $recipe->categories->pluck('name')->implode(', ') }}</p>
                <p><strong>Waktu Persiapan:</strong> {{ $recipe->prep_time }} menit</p>
                <p><strong>Waktu Memasak:</strong> {{ $recipe->cook_time }} menit</p>
                <p><strong>Porsi:</strong> {{ $recipe->servings }} orang</p>
                <p><strong>Deskripsi:</strong> {{ $recipe->description }}</p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="css-yd65l2">
                    <p class="chakra-text css-yak3wy">{{ $recipe->prep_time }} mnt</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="css-yd65l2">
                    <p class="chakra-text css-yak3wy">Rp {{ number_format($recipe->price, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="css-yd65l2">
                    <p class="chakra-text css-yak3wy">{{ $recipe->halal ? 'Tanpa Babi' : 'Mengandung Babi' }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="css-yd65l2">
                    <p class="chakra-text css-yak3wy">Porsi {{ $recipe->servings }} orang</p>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <h3>Bahan</h3>
            <ul>
                @foreach ($recipe->ingredients as $ingredient)
                    <li>{{ $ingredient->name }}</li>
                @endforeach
            </ul>
        </div>

        <div class="mb-4">
            <h3>Langkah Langkah</h3>
            <ol>
                @foreach ($recipe->steps as $step)
                    <li>{{ $step->description }}</li>
                @endforeach
            </ol>
        </div>

        <!-- Form untuk menambahkan komentar -->
        <div class="mb-4">
            <h4>Tambah Komentar</h4>
            <form action="{{ route('comments.store', $recipe->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="comment">Komeentarmu:</label>
                    <textarea name="content" id="comment" class="form-control" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Kirim Komentar</button>
            </form>
        </div>

        <!-- Section untuk menampilkan komentar -->
        <div class="mb-4">
            <h3>Komentar</h3>
            @if ($recipe->comments->isEmpty())
                <p>Tidak ada Komentar</p>
            @else
                <ul class="list-unstyled">
                    @foreach ($recipe->comments as $comment)
                        <li class="media mb-3">
                            <img src="{{ $comment->user->avatar ?? 'default-avatar.png' }}" class="mr-3 rounded-circle" alt="{{ $comment->user->name }}" style="width: 50px; height: 50px;">
                            <div class="media-body">
                                <h5 class="mt-0 mb-1">{{ $comment->user->name }}</h5>
                                <small>{{ $comment->created_at->diffForHumans() }}</small>
                                <p>{{ $comment->content }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection
