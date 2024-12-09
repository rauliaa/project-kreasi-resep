<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Recipe;
use App\Models\Categorie;
use App\Models\CategorieType;
use App\Models\Ingredient;

class RecipeController extends Controller
{
    // Menampilkan daftar semua resep
    public function index(Request $request)
    {
        $recipes = Recipe::with(['categories', 'purpose'])->get();
        
        $selectedIngredients = $request->input('ingredients', []);
        $categorieTypes = CategorieType::with('categories')->get();

        if (!empty($selectedIngredients)) {
            $recipes = Recipe::where(function ($query) use ($selectedIngredients) {
                foreach ($selectedIngredients as $ingredient) {
                    $query->orWhere('ingredients', 'LIKE', '%' . $ingredient . '%');
                }
            })->get();
        }

        return view('recipes.index', compact('recipes', 'categorieTypes'));
    }


    public function show(Categorie $categorie, $id)  // Pass $id here
    {
        // Find the recipe by ID
        $recipe = Recipe::findOrFail($id);
        $recipe = Recipe::with('ingredients')->findOrFail($id);
        // Fetch the recipes related to the category
        $recipes = Recipe::where('categorie_id', $categorie->id)->get();
        $recipe = Recipe::find($id);
        $categorieTypes = CategorieType::all();
        // Check if the recipe exists
        if (!$recipe) {
            // Handle the case when the recipe is not found
            return redirect()->route('recipes.index')->with('error', 'Recipe not found');
        }

        return view('recipes.show', compact('recipes', 'categorie', 'recipe', 'categorieTypes'));
    }

    // Menampilkan formulir untuk menambahkan resep baru
    public function create()
    {   
        $ingredients = Ingredient::all();
        $categorieTypes = CategorieType::with('categories')->get();
        $ingredients = DB::table('ingredients')->orderBy('name')->get();

        $groupedIngredients = $ingredients->groupBy(function ($item) {
            return strtoupper(substr($item->name, 0, 1));
        });
        return view('recipes.create', compact('ingredients', 'categorieTypes', 'groupedIngredients'));
    }
    
    public function store(Request $request)
    {
        // Validate the input data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cook_time' => 'required|integer',
            'ingredients.*.ingredient_id' => 'required',
            'ingredients.*.quantity' => 'required|numeric',
            'ingredients.*.unit' => 'required',
            'new_ingredients' => 'nullable|array',
            'instructions' => 'required|array',
            'image' => 'nullable|image|max:2048',
            'categorie_id' => 'required|integer',
        ]);
    
        // Create a new recipe instance
        $recipe = new Recipe();
        $recipe->title = $request->input('title');
        $recipe->description = $request->input('description');
        $recipe->cook_time = $request->input('cook_time');
    
        // Convert ingredients and instructions arrays to comma-separated strings
        $recipe->ingredients = implode(',', $request->input('ingredients'));
        $recipe->instructions = implode(',', $request->input('instructions'));
    
        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('recipes', 'public');
            $recipe->image = $imagePath;
        }
    
        $recipe->categorie_id = $request->input('categorie_id');

         // Tambahkan bahan baru ke database
        if ($request->has('new_ingredients')) {
            foreach ($request->new_ingredients as $newIngredient) {
                $ingredient = \App\Models\Ingredient::firstOrCreate([
                    'name' => ucfirst($newIngredient)
                ]);
                $validatedData['ingredients'][] = $ingredient->id;
            }
        }
        
        if ($request->has('ingredients')) {
            $recipe->ingredients()->sync($validatedData['ingredients']);
        }
   

        $recipe->save();
    
        // Redirect with a success message
        return redirect()->route('recipes.index')->with('success', 'Recipe created successfully!');
    }
    

    // Show the edit form
    public function edit($id)
    {
        $recipe = Recipe::findOrFail($id);
        $categorieTypes = CategorieType::with('categories')->get();
        $categories = CategorieType::with('categories')->get(); 
        $ingredients = explode(',', $recipe->ingredient);
        $instructions = explode(',', $recipe->instructions);
        return view('recipes.edit', compact('recipe', 'categorieTypes', 'categories', 'ingredients', 'instructions'));
    }
    
    public function update(Request $request, $id)
    {
        // Validasi bahwa ingredients dan instructions adalah array
        $validated = $request->validate([
            'ingredients' => 'required|array', // Validasi array untuk bahan-bahan
            'instructions' => 'required|array', // Validasi array untuk cara memasak
        ]);
    
        // Temukan resep berdasarkan ID
        $recipe = Recipe::findOrFail($id);
    
        // Update data resep
        $recipe->title = $request->input('title');
        $recipe->description = $request->input('description');
        $recipe->cook_time = $request->input('cook_time');
        
        // Proses bahan-bahan dan langkah-langkah memasak menjadi string yang dipisah koma
        $recipe->ingredients = implode(',', $request->input('ingredients'));
        $recipe->instructions = implode(',', $request->input('instructions'));
    
        // Jika ada gambar baru, upload gambar
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('recipes', 'public');
            $recipe->image = $imagePath;
        }
    
        $recipe->categorie_id = $request->input('categorie_id');
        $recipe->save();
    
        // Redirect dengan pesan sukses
        return redirect()->route('recipes.index')->with('success', 'Recipe updated successfully!');
    }
    
    
    
    public function destroy($id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->delete();

        return redirect()->route('recipes.index');
    }

    // Menampilkan resep berdasarkan kategori
    // Menampilkan daftar kategori resep
    public function showCategories()
    {
        // Mengambil semua CategorieType beserta Categories-nya
        $categorieTypes = CategorieType::with('categories')->get();

        return view('kategori.index', compact('categorieTypes')); // Mengubah 'categories' ke 'kategori.index'
    }

    // Menampilkan resep berdasarkan kategori tertentu
    public function showByCategorie($categorieId)
    {
        // Dapatkan kategori berdasarkan ID
        $categorie = Categorie::with('recipes')->findOrFail($categorieId);

        // Ambil semua resep dalam kategori tersebut
        $recipes = $categorie->recipes;

        // Kirim data kategori dan resep ke tampilan
        return view('kategori.show', compact('recipes', 'categorie')); // Mengubah 'recipes.index' ke 'kategori.show'
    }


    // Menampilkan resep berdasarkan metode memasak
    public function showByMethod($method)
    {
        // Get the category based on the method name (assuming 'method' corresponds to a category name)
        $categorie = Categorie::where('nama', $method)->firstOrFail(); // Use Categorie model here

        // Fetch recipes related to that categorie
        $recipes = Recipe::where('categorie_id', $categorie->id)->get();
        $categorieTypes = CategorieType::with('categories')->get(); 

        // Return the view with the categorie and recipes
        return view('recipes.index', compact('categorie', 'recipes', 'categorieTypes'));
    }


    // Menampilkan resep berdasarkan jenis hidangan
    public function showByType($type)
    {
        // Fetch the categorie by the provided type (assuming 'type' corresponds to categorie id)
        $categorie = Categorie::where('nama', $type)->firstOrFail(); // Use Categorie model here

        // Fetch recipes related to that categorie
        $recipes = Recipe::where('categorie_id', $categorie->id)->get();
        $categorieTypes = CategorieType::with('categories')->get(); 

        // Return the view with the categorie and recipes
        return view('recipes.index', compact('categorie', 'recipes', 'categorieTypes'));
    }

    // Menampilkan resep berdasarkan kategori khas (makanan tradisional/internasional)
    public function showByCuisine($cuisine)
    {
        // Find the cuisine or fail if not found
        $categorie = Categorie::where('nama', $cuisine)->firstOrFail(); // Use Categorie model here

        // Fetch recipes related to that categorie
        $recipes = Recipe::where('categorie_id', $categorie->id)->get();
        $categorieTypes = CategorieType::with('categories')->get(); 

        // Return the view with the categorie and recipes
        return view('recipes.index', compact('categorie', 'recipes', 'categorieTypes'));
    }

    public function showByIngredient($ingredient)
    {
        // Find the cuisine or fail if not found
        $categorie = Categorie::where('nama', $ingredient)->firstOrFail(); // Use Categorie model here

        // Fetch recipes related to that categorie
        $recipes = Recipe::where('categorie_id', $categorie->id)->get();
        $categorieTypes = CategorieType::with('categories')->get(); 

        // Return the view with the categorie and recipes
        return view('recipes.index', compact('categorie', 'recipes', 'categorieTypes'));
    }

    // Menampilkan resep berdasarkan tujuan makanan
    public function showByPurpose($purpose)
    {
        // Find the cuisine or fail if not found
        $categorie = Categorie::where('nama', $purpose)->firstOrFail(); // Use Categorie model here

        // Fetch recipes related to that categorie
        $recipes = Recipe::where('categorie_id', $categorie->id)->get();
        $categorieTypes = CategorieType::with('categories')->get(); 

        // Return the view with the categorie and recipes
        return view('recipes.index', compact('categorie', 'recipes', 'categorieTypes'));
    }

    public function showByRecommendation($recommendation)
    {
        // Get the category based on the method name (assuming 'method' corresponds to a category name)
        $categorie = Categorie::where('nama', $recommendation)->firstOrFail(); // Use Categorie model here

        // Fetch recipes related to that categorie
        $recipes = Recipe::where('categorie_id', $categorie->id)->get();
        $categorieTypes = CategorieType::with('categories')->get(); 

        // Return the view with the categorie and recipes
        return view('recipes.index', compact('categorie', 'recipes', 'categorieTypes'));
    }


    // Menampilkan resep berdasarkan kategori umum
    public function byCategorie(Categorie $categorie)
    {
        $recipes = Recipe::where('categorie_id', $categorie->id)->get();
        return view('recipes.index', compact('recipes'));
    }

    // Menampilkan resep berdasarkan kategori yang lebih spesifik
    private function showRecipesByCategorie($categorieId)
    {
        $categorie = Categorie::findOrFail($categorieId);
        $recipes = Recipe::where('categorie_id', $categorieId)->get(); 
        return view('recipes.index', compact('categorie', 'recipes'));
    }


    // Menampilkan resep favorit
    public function favorite()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $recipe = Recipe::find($id);
        $user = auth()->user();
        $user->favorites()->attach($recipe);
        $user = auth()->user();
        $favorites = $user->favorites;
        return view('favorites.index', compact('user', 'favorites'));
    }

    // Menambahkan resep ke favorit
    public function addToFavorites($id)
    {
        $user = Auth::user();
        $recipe = Recipe::find($id);

        if ($recipe) {
            if (!$user->favorites()->where('recipe_id', $recipe->id)->exists()) {
                $user->favorites()->attach($recipe->id);
                return response()->json(['success' => true, 'message' => 'Resep berhasil ditambahkan ke favorit.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Resep sudah ada di daftar favorit.']);
            }
        }

        return response()->json(['success' => false, 'message' => 'Resep tidak ditemukan.']);
    }

    // Menampilkan halaman favorit
    public function showFavorites()
    {
        $user = Auth::user();
        $favorites = $user->favorites;
        return view('favorites.index', compact('favorites'));
    }

    // Menampilkan resep berdasarkan bahan yang tidak memiliki bahan tertentu
    public function showIngredients()
    {
        // Fetch ingredients from the database
        $ingredients = Ingredient::all();
    
        // Group ingredients by their first letter (or any other logic you need)
        $groupedIngredients = $ingredients->groupBy(function($ingredient) {
            return strtoupper(substr($ingredient->name, 0, 1)); // Group by the first letter of the name
        });
        
        $recipes = Recipe::all();
        $categorieTypes = CategorieType::with('categories')->get(); 
        // Pass the grouped ingredients to the view
        return view('Ingredients.index', compact('ingredients', 'groupedIngredients', 'recipes', 'categorieTypes'));
    }

    public function getRecipes(Request $request)
    {
        $ingredientIds = $request->ingredients;
        
        // Ambil resep yang menggunakan bahan-bahan yang dipilih
        $recipes = Recipe::whereHas('ingredients', function($query) use ($ingredientIds) {
            $query->whereIn('id', $ingredientIds);
        })->get();

        return response()->json($recipes);  // Kembalikan resep dalam format JSON
    }
    
    
    public function saveRecipe($recipeId)
    {
        $user = Auth::user(); // Get the authenticated user
        $recipe = Recipe::findOrFail($recipeId); // Find the recipe by ID

        // Add the recipe to the user's favorites if not already saved
        if (!$user->favorites->contains($recipe)) {
            $user->favorites()->attach($recipe); // Attach the recipe to the user's favorites
        }

        // Redirect back with a success message
        return redirect()->route('recipes.show', $recipeId)->with('success', 'Resep telah disimpan ke favorit.');
    }

    public function save($id)
    {
        // Menyimpan resep ke dalam daftar favorit pengguna
        $recipe = Recipe::findOrFail($id);
        Auth::user()->favorites()->attach($recipe); // Anda bisa menggunakan pivot table 'favorites'

        // Mengarahkan ke halaman resep favorit
        return redirect()->route('favorite.recipes')->with('success', 'Resep berhasil disimpan.');
    }

    public function favoriteRecipes()
    {
        $user = auth()->user(); // Get the authenticated user
        $favorites = $user->favorites; // Get the user's favorite recipes
        $recipes = Auth::user()->favorites;
        
        return view('favorites.index', compact('user', 'favorites', 'recipes')); // Pass the $user to the view
    }
    
    public function removeFavorite(Recipe $recipe)
    {
        // Assuming the user is already authenticated and the recipe is already in favorites
        $user = auth()->user();
        
        // Detach the recipe from the user's favorites
        $user->favorites()->detach($recipe);

        // Redirect back to the favorites page with a success message
        return redirect()->route('profile.favorites')->with('success', 'Resep berhasil dihapus dari favorit');
    }

    public function saveFavorite(Request $request, $recipeId)
    {
        $user = auth()->user();
        $recipe = Recipe::findOrFail($recipeId);

        // Cek apakah resep sudah ada di daftar favorit
        if ($user->favorites()->where('recipe_id', $recipeId)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Resep sudah ada di favorit Anda.'
            ]);
        }

        // Tambahkan resep ke favorit
        $user->favorites()->attach($recipeId);

        return response()->json([
            'success' => true,
            'message' => 'Resep berhasil disimpan di favorit Anda.'
        ]);
    }

    

    public function storeComment(Request $request, $recipeId)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $recipe = Recipe::findOrFail($recipeId);

        // Simpan komentar baru
        $comment = new Comment();
        $comment->user_id = auth()->user()->id;
        $comment->recipe_id = $recipe->id;
        $comment->content = $request->content;
        $comment->save();

        // Ambil data untuk dikirim kembali ke AJAX
        $userProfileImage = $comment->user->profile_image ? asset('images/profile/' . $comment->user->profile_image) : asset('images/default-profile.png');
        $userName = $comment->user->name;
        $commentContent = $comment->content;

        return response()->json([
            'userProfileImage' => $userProfileImage,
            'userName' => $userName,
            'commentContent' => $commentContent
        ]);
    }

    public function search(Request $request)
    {
        // Ambil bahan dari request
        $ingredients = $request->input('ingredients');

        // Cari resep yang cocok berdasarkan bahan
        // Anda bisa menyesuaikan ini dengan logika pencarian resep
        $recipes = Recipe::where(function($query) use ($ingredients) {
            foreach ($ingredients as $ingredient) {
                $query->orWhere('ingredients', 'LIKE', '%' . $ingredient . '%');
            }
        })->get();

        return response()->json([
            'recipes' => $recipes
        ]);
    }

    public function filterRecipes(Request $request) {
        $selectedIngredients = $request->input('ingredients', []);
    
        // Ambil semua resep dari database
        $recipes = Recipe::with('ingredients')->get();
    
        // Filter resep berdasarkan bahan yang dipilih
        $filteredRecipes = $recipes->map(function($recipe) use ($selectedIngredients) {
            $recipeIngredientIds = $recipe->ingredients->pluck('id')->toArray();
            $missingIngredients = array_diff($recipeIngredientIds, $selectedIngredients);
    
            return [
                'name' => $recipe->name,
                'ingredients' => $recipe->ingredients->pluck('name'),
                'missingIngredients' => Ingredient::whereIn('id', $missingIngredients)->pluck('name')->toArray()
            ];
        })->filter(function($recipe) {
            return count($recipe['ingredients']) > 0; // Hanya kembalikan resep yang memiliki bahan cocok
        });
    
        return response()->json($filteredRecipes);
    }
    
    public function getRecipesByIngredient($id)
    {
        // Ambil resep yang memiliki bahan tertentu
        $recipes = Recipe::whereHas('ingredients', function ($query) use ($id) {
            $query->where('ingredient_id', $id);
        })->get();

        return response()->json($recipes);
    }


}
