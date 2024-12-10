@extends('layouts.resep')

@section('content')
<style>
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

    .action-buttons {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .action-button {
        background-color: #f8f9fa;
        border: 2px solid #ced4da;
        color: #495057;
        border-radius: 5px;
        padding: 10px 15px;
        font-size: 14px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .action-button:hover {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    .delete-btn {
        background-color: #dc3545;
    }

    .recipe-section {
        width: 100%;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 2px solid #e0e0e0;
    }

    .section-header {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .section-content {
        font-size: 1rem;
        margin-bottom: 20px;
    }

    .comment {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        border-bottom: 1px solid #e0e0e0;
        padding-bottom: 10px;
    }

    .comment img {
        border-radius: 50%;
        width: 50px;
        height: 50px;
        margin-right: 10px;
    }

    .add-comment-btn {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
    }

    .add-comment-btn:hover {
        background-color: #0056b3;
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
                    <span>{{ $recipe->cook_time }} menit</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('recipes.edit', $recipe->id) }}" class="action-button">
                    <i class="fa fa-pencil"></i> Edit Resep
                </a>

                <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus resep ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-button delete-btn">
                        <i class="fa fa-trash"></i> Hapus Resep
                    </button>
                </form>

                 <!-- Save Recipe Button -->
                 <form action="{{ route('recipes.save', $recipe->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="action-button" style="background-color: #ffc107; color: white;">
                        <i class="fa fa-heart"></i> Simpan Resep
                    </button>
                </form>
            </div>

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

                <!-- Tab Content -->
                <div class="tab-content">
                    <!-- Ingredients Section -->
                    <div class="tab-pane fade show active" id="bahan">
                        <h2>Bahan-bahan</h2>
                        <div class="section-content">
                            <ul>
                                @foreach (json_decode($recipe->ingredients) as $ingredient)
                                    <li>{{ $ingredient }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
            


                    <!-- Cooking Instructions Section -->
                    <div class="tab-pane fade" id="cara-memasak">
                        <h2>Cara Memasak</h2>
                        <div class="section-content">
                            <ol>
                            @foreach(explode("\n", is_array($recipe->instructions) ? implode("\n", $recipe->instructions) : $recipe->instructions) as $step)
                                <li>{{ $step }}</li>
                            @endforeach

                            </ol>
                        </div>
                    </div>

                    <!-- Comments Section -->
                    <div class="tab-pane fade" id="diskusi">
                        <h2>Komentar</h2>
                        <div class="section-content">
                            @foreach($recipe->comments as $comment)
                                <div class="comment">
                                    <img src="{{ $comment->user->profile_image ? asset('images/profile/' . $comment->user->profile_image) : asset('images/default-profile.png') }}" alt="Profil">
                                    <p><strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}</p>
                                </div>
                            @endforeach
                        </div>

                        @auth
                        <form action="{{ route('comments.store', $recipe->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <textarea name="content" class="form-control" placeholder="Tulis komentar..." required></textarea>
                            </div>
                            <button type="submit" class="add-comment-btn">Tambahkan Diskusi</button>
                        </form>
                        @else
                        <p>Silakan <a href="{{ route('login') }}">login</a> untuk menambahkan komentar.</p>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
