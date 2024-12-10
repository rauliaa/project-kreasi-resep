@extends('layouts.resep')

@section('title', 'Create Recipe')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Create New Recipe</h2>

    <!-- Display validation errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form to create a new recipe -->
    <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Recipe Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
        </div>

        <!-- Pilihan Ingredients dari daftar yang dikelompokkan -->
        <div class="mb-3">
            <label for="ingredients" class="form-label">Ingredients</label>
            <input type="text" id="search-box" class="form-control mb-2" placeholder="Cari bahan atau tambah baru...">
            <button type="button" id="add-new-ingredient-btn" class="btn btn-sm btn-success" style="display: none;">
                Tambahkan "<span id="new-ingredient-text"></span>"
            </button>
            <div class="ingredient-list" style="max-height: 400px; overflow-y: auto;">
                @foreach ($groupedIngredients as $letter => $ingredientsGroup)
                    <div class="mb-3 ingredient-group" data-letter="{{ $letter }}">
                        <h5 class="fw-bold">{{ $letter }}</h5>
                        <div class="row">
                            @foreach($ingredientsGroup as $ingredient)
                                <div class="col-12 mb-2">
                                    <div class="form-check d-flex align-items-center">
                                        <!-- Checkbox Bahan -->
                                        <input class="form-check-input me-2 ingredient-checkbox" type="checkbox" 
                                            name="ingredients[{{ $ingredient->id }}][selected]" 
                                            value="1" id="ingredient-{{ $ingredient->id }}">

                                        <!-- Label Nama Bahan -->
                                        <label class="form-check-label me-3" for="ingredient-{{ $ingredient->id }}">
                                            {{ $ingredient->name }}
                                        </label>

                                        <!-- Input Quantity -->
                                        <input type="number" class="form-control form-control-sm me-2 quantity-input" 
                                            name="ingredients[{{ $ingredient->id }}][quantity]" 
                                            placeholder="Qty" min="0" step="0.1" style="width: 80px;" disabled>

                                        <!-- Input Unit -->
                                        <input type="text" class="form-control form-control-sm unit-input" 
                                            name="ingredients[{{ $ingredient->id }}][unit]" 
                                            placeholder="Unit" style="width: 100px;" disabled>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="form-group">
            <label for="instructions">Instructions</label>
            <textarea class="form-control" id="instructions" name="instructions[]" rows="5" placeholder="Enter each step on a new line" required>{{ old('instructions') }}</textarea>
        </div>


        <div class="mb-3">
            <label for="cook_time" class="form-label">Cook Time (minutes)</label>
            <input type="number" name="cook_time" id="cook_time" class="form-control" value="{{ old('cook_time') }}" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Recipe Image</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        <!-- Category selection -->
        <div class="form-group">
            <label for="categorie">Category</label>
            <select name="categorie_id" class="form-control" required>
                @foreach($categorieTypes as $type)
                    <optgroup label="{{ $type->nama }}">
                        @foreach($type->categories as $categorie)
                            <option value="{{ $categorie->id }}">{{ $categorie->nama }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Create Recipe</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
$('#search-box').on('input', function() {
    let searchQuery = $(this).val().toLowerCase().trim();
    let anyMatch = false;

    // Jika input kosong, reset
    if (searchQuery === '') {
        $('#add-new-ingredient-btn').hide();
        $('.ingredient-group, .form-check').show();
        $('.ingredient-list').find('.text-muted').remove();
        return;
    }

    // Filter bahan
    $('.ingredient-group').each(function() {
        let group = $(this);
        let foundInGroup = false;

        group.find('.form-check').each(function() {
            let ingredientName = $(this).find('label').text().toLowerCase();
            if (ingredientName.includes(searchQuery)) {
                $(this).show();
                foundInGroup = true;
            } else {
                $(this).hide();
            }
        });

        if (foundInGroup) {
            group.show();
            anyMatch = true;
        } else {
            group.hide();
        }
    });

    // Jika tidak ada bahan yang cocok, tampilkan tombol tambah
    if (!anyMatch) {
        $('#new-ingredient-text').text(searchQuery);
        $('#add-new-ingredient-btn').show();
    } else {
        $('#add-new-ingredient-btn').hide();
    }
});
$('#add-new-ingredient-btn').on('click', function() {
    let newIngredient = $('#search-box').val().trim();

    if (newIngredient) {
        let firstLetter = newIngredient[0].toUpperCase();
        let groupContainer = $(`.ingredient-group[data-letter='${firstLetter}']`);

        // Jika grup sudah ada, tambahkan ke dalam grup
        if (groupContainer.length) {
            groupContainer.find('.row').append(`
                <div class="col-12 mb-1">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="new_ingredients[]" value="${newIngredient}" checked>
                        <label class="form-check-label">${newIngredient}</label>
                    </div>
                </div>
            `);
        } 
        // Jika grup belum ada, buat grup baru
        else {
            $('.ingredient-list').append(`
                <div class="mb-3 ingredient-group" data-letter="${firstLetter}">
                    <h5 class="fw-bold">${firstLetter}</h5>
                    <div class="row">
                        <div class="col-12 mb-1">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="new_ingredients[]" value="${newIngredient}" checked>
                                <label class="form-check-label">${newIngredient}</label>
                            </div>
                        </div>
                    </div>
                </div>
            `);
        }

        // Reset input dan sembunyikan tombol
        $('#search-box').val('');
        $('#add-new-ingredient-btn').hide();
    }
});
$(document).on('change', '.ingredient-checkbox', function() {
    let isChecked = $(this).is(':checked');
    let quantityInput = $(this).closest('.form-check').find('.quantity-input');
    let unitInput = $(this).closest('.form-check').find('.unit-input');

    // Aktifkan atau nonaktifkan input berdasarkan checkbox
    if (isChecked) {
        quantityInput.prop('disabled', false);
        unitInput.prop('disabled', false);
    } else {
        quantityInput.prop('disabled', true).val('');
        unitInput.prop('disabled', true).val('');
    }
});
</script>
@endsection
