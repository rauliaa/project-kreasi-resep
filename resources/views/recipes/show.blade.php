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

    .edit-btn {
        background-color: #28a745;
    }

    .delete-btn {
        background-color: #dc3545;
    }

    .recipe-section {
        width: 100%;
        margin-top: 20px;
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

    .recipe-info {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .recipe-info .section {
        flex: 1;
        min-width: 300px;
    }

    .comment {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .comment img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .comment p {
        font-size: 1rem;
        margin: 0;
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

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="bahan">
                            <h2>Bahan-bahan</h2>
                            <ul class="list-group">
                                @if($recipe->ingredients && $recipe->ingredients->count())
                                @foreach($recipe->ingredients as $ingredient)
                                    <li class="list-group-item">{{ $ingredient->description }}</li>
                                @endforeach
                                @else
                                    <li class="list-group-item">Bahan-bahan tidak tersedia.</li>
                                @endif
                            </ul>
                    </div>
                    <div class="tab-pane fade" id="cara-memasak">
                            <h2>Cara Memasak</h2>
                            <ul class="list-group">
                                @if($recipe->steps && $recipe->steps->count())
                                    
                                @foreach($recipe->steps as $step)
                                    <li class="list-group-item">{{ $step->description }}</li>
                                @endforeach
                                @else
                                    <li class="list-group-item">Cara memasak tidak tersedia.</li>
                                @endif
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
