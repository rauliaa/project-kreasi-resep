@extends('layouts.resep') 
@section('title', 'Flavora - All Resep!') 
@section('content') 
<div class="container">     
    <div class="heading_container heading_center mb-5">         
        <h2 style="font-weight: normal; letter-spacing: 1px; color: #333; margin-top: 20px;">Semua Resep</h2>     
    </div>      
    <div class="row">         
        @foreach ($recipes as $recipe)         
        <div class="col-md-3 mb-4">             
            <a href="{{ route('recipes.show', $recipe->id) }}">                 
                <div class="card shadow-sm rounded-lg" style="border: none;">                     
                    <img src="{{ asset('delfood-1.0.0/images/' . $recipe->image) }}"                           
                         alt="{{ $recipe->title }}"                           
                         class="card-img-top"                           
                         style="height: 200px; object-fit: cover; border-radius: 10px;">                 
                </div>             
            </a>              
            <div class="mt-2">                 
                <div class="d-flex justify-content-between align-items-start">                     
                    <div>                         
                        <h5 class="mb-1" style="font-size: 16px; font-weight: bold; color: #333;">{{ $recipe->title }}</h5>                         
                        <p class="text-muted" style="font-size: 14px;">                             
                            <i class="fa fa-clock-o"></i> {{ $recipe->prep_time }} menit                         
                        </p>                     
                    </div>                     
                    <div class="d-flex align-items-center" style="margin-top: -8px;">
                        <button class="btn favorite-button" data-recipe-id="{{ $recipe->id }}" >                             
                            <i class="fa fa-bookmark-o"></i>                          
                        </button>                     
                    </div>                 
                </div>             
            </div>         
        </div>         
        @endforeach     
    </div> 
</div>  

<!-- Script AJAX untuk handle Favorite -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Event listener untuk tombol favorite
        document.querySelectorAll('.favorite-button').forEach(function (button) {
            button.addEventListener('click', function () {
                const recipeId = this.getAttribute('data-recipe-id');

                // Kirim request AJAX ke server untuk bookmark
                fetch(/favorites/${recipeId}, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        this.innerHTML = '<i class="fa fa-bookmark"></i> Favorited';
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    });
</script>
@endsection
