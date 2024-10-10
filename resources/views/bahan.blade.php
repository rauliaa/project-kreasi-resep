@extends('layouts.resep')

@section('content')
<div class="container">
    <h1>Bahan Makanan</h1>
    <div style="display: flex;">
        <form id="ingredients-form" style="flex: 1; margin-right: 20px;">
            <div class="form-group">
                @foreach($ingredients as $ingredient)
                    <div>
                        <input type="checkbox" class="ingredient-checkbox" value="{{ $ingredient->name }}" id="ingredient-{{ $ingredient->id }}">
                        <label for="ingredient-{{ $ingredient->id }}">{{ $ingredient->name }}</label>
                    </div>
                @endforeach
            </div>
        </form>

        <div id="recipes-list" style="flex: 2;">
            <h2>Resep yang Ditemukan</h2>
            <!-- Daftar resep akan muncul di sini -->
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.ingredient-checkbox').change(function() {
            var selectedIngredients = [];
            $('.ingredient-checkbox:checked').each(function() {
                selectedIngredients.push($(this).val());
            });

            $.ajax({
                url: '/bahan/getRecipes',
                method: 'POST',
                data: {
                    ingredients: selectedIngredients,
                    _token: '{{ csrf_token() }}'
                },
                success: function(recipes) {
                    $('#recipes-list').empty();
                    if (recipes.length > 0) {
                        $.each(recipes, function(index, recipe) {
                            $('#recipes-list').append('<div><h3>' + recipe.title + '</h3><p>' + recipe.description + '</p></div>');
                        });
                    } else {
                        $('#recipes-list').append('<p>Tidak ada resep ditemukan.</p>');
                    }
                }
            });
        });
    });
</script>
@endsection
