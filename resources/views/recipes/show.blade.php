@extends('layouts.resep')

@section('content')
<style>
    /* Membuat responsive container */
    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        padding: 20px;
        box-sizing: border-box;
    }

    .recipe-details {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        width: 100%;
        margin-bottom: 50px;
    }

    .recipe-image {
        flex: 0 0 100%;
        margin-right: 20px;
        margin-top: 20px;
    }

    @media (min-width: 768px) {
        .recipe-details {
            flex-direction: row;
        }
        .recipe-image {
            flex: 0 0 400px;
        }
    }

    .img-fluid {
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        width: 100%;
        height: auto;
        max-width: 800px;
    }

    .icon-section {
        display: flex;
        align-items: center;
        justify-content: flex-start; /* Ubah ke flex-start untuk menyusun item lebih rapat */
        margin-top: 10px;
        gap: 10px; /* Tambahkan jarak antar item */
    }

    .icon-section div {
        display: flex;
        align-items: center;
    }

    .icon-section img {
        width: 30px; /* Kecilkan ukuran ikon jika perlu */
        height: 30px;
        margin-right: 5px; /* Kecilkan jarak antara ikon dan teks */
    }

    .icon-section .badge {
        background-color: #007bff;
        color: white;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 14px;
        margin-right: 10px;
    }

    .save-recipe-btn {
        background-color: #ffc107;
        color: white;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-size: 14px;
        padding: 8px 15px;
        display: inline-block;
        text-align: center;
        margin-left: 10px; /* Ubah margin left */
    }

    .save-recipe-btn:hover {
        background-color: #e0a800;
    }

    .rating {
        display: flex;
        align-items: center;
    }

    .star {
        color: gold;
        margin-right: 5px;
    }

    .tabs {
        width: 100%;
        margin-top: 20px;
    }

    .tab-content {
        margin-top: 20px;
    }

    .comment {
        border: 1px solid #dcdcdc;
        padding: 15px;
        border-radius: 10px;
        background-color: #fff3cd;
        margin-bottom: 15px;
    }

    .comment p {
        margin: 0;
    }

    .comment strong {
        color: #007bff;
    }

    .action-section {
        display: flex;
        align-items: center;
        margin-top: 15px;
    }

    /* Responsive untuk list bahan dengan tinggi terbatas pada desktop */
    .list-group {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); /* Menggunakan grid layout */
        gap: 15px; /* Jarak antar kotak bahan */
        padding: 0;
        list-style: none;
        margin: 0;
    }

    .list-group-item {
        padding: 10px;
        border: 1px solid #ddd;
        margin-bottom: 5px;
        border-radius: 5px;
        text-align: center; /* Agar teks di tengah */
        min-height: 80px; /* Tinggi minimum yang seragam */
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f9f9f9;
    }

    @media (min-width: 768px) {
        .list-group {
            max-height: 400px; /* Batasi tinggi list */
            overflow-y: auto; /* Aktifkan scroll jika terlalu panjang */
        }

        .list-group-item {
            flex: 0 0 48%; /* Membuat 2 kolom di layar besar */
        }

        .list-group-item:nth-child(2n) {
            margin-right: 0; /* Menghilangkan margin kanan di kolom genap */
        }
    }

    @media (min-width: 1200px) {
        .list-group-item {
            flex: 0 0 30%; /* Membuat 3 kolom di layar sangat besar */
            margin-right: 2%;
        }

        .list-group-item:nth-child(3n) {
            margin-right: 0; /* Menghilangkan margin kanan di kolom ganjil */
        }
    }
</style>

<div class="container">
    <div class="recipe-details">
        <div class="recipe-image">
            <img src="{{ asset('delfood-1.0.0/images/' . $recipe->image) }}" alt="{{ $recipe->title }}" class="img-fluid">
        </div>
        <div>
            <h1>{{ $recipe->title }}</h1>
            <div class="description">
                <p>{{ $recipe->description }}</p>
            </div>
            <div class="icon-section">
                <div>
                    <img src="{{ asset('delfood-1.0.0/images/jam.png') }}" alt="Waktu">
                    <span>{{ $recipe->time }} menit</span>
                </div>
                <div>
                    <img src="{{ asset('delfood-1.0.0/images/wang.png') }}" alt="Harga">
                    <span>Rp {{ number_format($recipe->price, 0, ',', '.') }}</span>
                </div>
                <div>
                    <img src="{{ asset('delfood-1.0.0/images/prsi.png') }}" alt="Porsi">
                    <span>{{ $recipe->servings }} Porsi</span>
                </div>
                <form action="{{ route('favorites.store', $recipe->id) }}" method="POST" style="margin-left: 10px;">
                    @csrf
                    <button type="submit" class="save-recipe-btn">Simpan Resep</button>
                </form>
            </div>

            <!-- Bagian Bahan, Cara Memasak, dan Diskusi -->
            <div class="tabs">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#bahan" data-toggle="tab">Bahan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#cara-memasak" data-toggle="tab">Cara Memasak</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#diskusi" data-toggle="tab">Testi Diskusi</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="bahan">
                        <h2>Bahan-bahan</h2>
                        <ul class="list-group">
                            @foreach($recipe->ingredients as $ingredient)
                                <li class="list-group-item">{{ $ingredient->description }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="cara-memasak">
                        <h2>Cara Memasak</h2>
                        <ul class="list-group">
                            @foreach($recipe->steps as $step)
                                <li class="list-group-item">{{ $step->description }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="tab-pane fade" id="diskusi">
                        <h2>Komentar</h2>
                        <div>
                            @foreach($recipe->comments as $comment)
                                <div class="comment">
                                    <img src="{{ $comment->user->profile_image ? asset('images/profile/' . $comment->user->profile_image) : asset('images/default-profile.png') }}" alt="Profil" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;">
                                    <p><strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection