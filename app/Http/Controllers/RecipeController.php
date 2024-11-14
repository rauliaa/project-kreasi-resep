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
        
        if (!empty($selectedIngredients)) {
            $recipes = Recipe::where(function ($query) use ($selectedIngredients) {
                foreach ($selectedIngredients as $ingredient) {
                    $query->orWhere('ingredients', 'LIKE', '%' . $ingredient . '%');
                }
            })->get();
        }

        return view('recipes.index', compact('recipes'));
    }


    public function show(Categorie $categorie, $id)  // Pass $id here
    {
        // Find the recipe by ID
        $recipe = Recipe::findOrFail($id);

        // Fetch the recipes related to the category
        $recipes = Recipe::where('categorie_id', $categorie->id)->get();

        // Check if the recipe exists
        if (!$recipe) {
            // Handle the case when the recipe is not found
            return redirect()->route('recipes.index')->with('error', 'Recipe not found');
        }

        return view('recipes.show', compact('recipes', 'categorie', 'recipe'));
    }

    // Menampilkan formulir untuk menambahkan resep baru
    public function create()
    {
        // Mengambil semua kategori
        $categories = Categorie::all();

        return view('recipes.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'instructions' => 'required|string',
            'ingredient' => 'required|string',
            'cook_time' => 'nullable|integer',
            'image' => 'nullable|image',
            'cara_memasak_id' => 'required|exists:categories,id',
            'jenis_hidangan_id' => 'required|exists:categories,id',
            'kategori_khas_id' => 'required|exists:categories,id',
            'bahan_utama_id' => 'required|exists:categories,id',
            'tujuan_makanan_id' => 'required|exists:categories,id',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('recipes', 'public');
        } else {
            $imagePath = null;
        }

        // Create the recipe
        Recipe::create([
            'title' => $request->title,
            'description' => $request->description,
            'instructions' => $request->instructions,
            'ingredient' => $request->ingredient,
            'cook_time' => $request->cook_time,
            'image' => $imagePath,
            'cara_memasak_id' => $request->cara_memasak_id,
            'jenis_hidangan_id' => $request->jenis_hidangan_id,
            'kategori_khas_id' => $request->kategori_khas_id,
            'bahan_utama_id' => $request->bahan_utama_id,
            'tujuan_makanan_id' => $request->tujuan_makanan_id,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('recipes.index')->with('success', 'Recipe created successfully');
    }


    


   // Fungsi untuk menampilkan form edit resep
   public function edit($id)
   {
       $recipe = Recipe::findOrFail($id);
   
       // Check if ingredients and instructions are already arrays; if not, decode them.
       $recipe->ingredients = is_string($recipe->ingredients) ? json_decode($recipe->ingredients) : $recipe->ingredients;
       $recipe->instructions = is_string($recipe->instructions) ? json_decode($recipe->instructions) : $recipe->instructions;
   
       $categories = Categorie::all();
   
       return view('recipes.edit', compact('recipe', 'categories'));
   }
   


   // Fungsi untuk mengupdate resep
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cook_time' => 'nullable|integer',
            'image' => 'nullable|url',
            'categorie_id' => 'required|exists:categories,id',
            'ingredients' => 'required|array',
            'instructions' => 'required|array',
        ]);

        $recipe = Recipe::findOrFail($id);

        // Update recipe data with JSON-encoded instructions and ingredients
        $recipe->title = $request->title;
        $recipe->description = $request->description;
        $recipe->cook_time = $request->cook_time;
        $recipe->image = $request->image;
        $recipe->categorie_id = $request->categorie_id;
        $recipe->ingredients = json_encode($request->ingredients);
        $recipe->instructions = json_encode($request->instructions);
        $recipe->save();

        return redirect()->route('recipes.show', $recipe->id)->with('success', 'Recipe updated successfully!');
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

        // Return the view with the categorie and recipes
        return view('recipes.index', compact('categorie', 'recipes'));
    }


    // Menampilkan resep berdasarkan jenis hidangan
    public function showByType($type)
    {
        // Fetch the categorie by the provided type (assuming 'type' corresponds to categorie id)
        $categorie = Categorie::where('nama', $type)->firstOrFail(); // Use Categorie model here

        // Fetch recipes related to that categorie
        $recipes = Recipe::where('categorie_id', $categorie->id)->get();

        // Return the view with the categorie and recipes
        return view('recipes.index', compact('categorie', 'recipes'));
    }

    // Menampilkan resep berdasarkan kategori khas (makanan tradisional/internasional)
    public function showByCuisine($cuisine)
    {
        // Find the cuisine or fail if not found
        $categorie = Categorie::where('nama', $cuisine)->firstOrFail(); // Use Categorie model here

        // Fetch recipes related to that categorie
        $recipes = Recipe::where('categorie_id', $categorie->id)->get();

        // Return the view with the categorie and recipes
        return view('recipes.index', compact('categorie', 'recipes'));
    }

    public function showByIngredient($ingredient)
    {
        // Find the cuisine or fail if not found
        $categorie = Categorie::where('nama', $ingredient)->firstOrFail(); // Use Categorie model here

        // Fetch recipes related to that categorie
        $recipes = Recipe::where('categorie_id', $categorie->id)->get();

        // Return the view with the categorie and recipes
        return view('recipes.index', compact('categorie', 'recipes'));
    }

    // Menampilkan resep berdasarkan tujuan makanan
    public function showByPurpose($purpose)
    {
        // Find the cuisine or fail if not found
        $categorie = Categorie::where('nama', $purpose)->firstOrFail(); // Use Categorie model here

        // Fetch recipes related to that categorie
        $recipes = Recipe::where('categorie_id', $categorie->id)->get();

        // Return the view with the categorie and recipes
        return view('recipes.index', compact('categorie', 'recipes'));
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
    public function showIngredients(Request $request)
    {
        $recipes = Recipe::whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('ingredients')
                ->join('ingredient_recipe', 'ingredients.id', '=', 'ingredient_recipe.ingredient_id')
                ->whereRaw('recipes.id = ingredient_recipe.recipe_id');
        })->paginate(15);

        $total = $recipes->total();
        $ingredientName = $request->input('ingredient');
        $ingredients = Ingredient::all();

        return view('ingredients.index', compact('recipes', 'total', 'ingredientName', 'ingredients'));
    }
}
