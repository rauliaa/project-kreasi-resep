<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Step;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    // Menampilkan daftar semua resep
    public function index()
    {
        $recipes = Recipe::with('categories')->get();
        return view('recipes.index', compact('recipes'));
    }

    public function show($id)
    {
        $recipe = Recipe::with(['ingredients', 'steps', 'comments.user', 'categories'])->findOrFail($id);
        return view('recipes.show', compact('recipe'));
    }

    // Menampilkan formulir untuk menambahkan resep baru
    public function create()
    {
        $categories = Category::all();
        return view('recipes.create', compact('categories'));
    }

    // Menyimpan resep baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ingredients' => 'required|array',
            'ingredients.*' => 'required|string',
            'steps' => 'required|array',
            'steps.*' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'prep_time' => 'required|integer',
            'cook_time' => 'required|integer',
            'servings' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $recipe = new Recipe();
        $recipe->title = $request->title;
        $recipe->prep_time = $request->prep_time;
        $recipe->cook_time = $request->cook_time;
        $recipe->servings = $request->servings;
        $recipe->description = $request->description;
        $recipe->category_id = $request->category_id;

        // Mengelola upload gambar
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images');
            $recipe->image = $path;
        }

        $recipe->save();

        // Menyimpan ingredients dan steps
        foreach ($request->ingredients as $ingredientName) {
            $ingredient = new Ingredient();
            $ingredient->name = $ingredientName;
            $ingredient->recipe_id = $recipe->id;
            $ingredient->save();
        }

        foreach ($request->steps as $stepDescription) {
            $step = new Step();
            $step->description = $stepDescription;
            $step->recipe_id = $recipe->id;
            $step->save();
        }

        return redirect()->route('recipes.index')->with('success', 'Recipe created successfully.');
    }

    // Menampilkan formulir untuk mengedit resep
    public function edit($id)
    {
        $recipe = Recipe::with('ingredients', 'steps')->findOrFail($id);
        $categories = Category::all();
        return view('recipes.edit', compact('recipe', 'categories'));
    }

    // Memperbarui resep di database
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ingredients' => 'required|array',
            'ingredients.*' => 'required|string',
            'steps' => 'required|array',
            'steps.*' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'prep_time' => 'required|integer',
            'cook_time' => 'required|integer',
            'servings' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $recipe = Recipe::findOrFail($id);
        $recipe->title = $request->title;
        $recipe->prep_time = $request->prep_time;
        $recipe->cook_time = $request->cook_time;
        $recipe->servings = $request->servings;
        $recipe->description = $request->description;
        $recipe->category_id = $request->category_id;

        // Mengelola upload gambar
        if ($request->hasFile('image')) {
            if ($recipe->image) {
                Storage::delete($recipe->image);
            }
            $path = $request->file('image')->store('images');
            $recipe->image = $path;
        }

        $recipe->save();

        // Memperbarui ingredients dan steps
        $recipe->ingredients()->delete();
        foreach ($request->ingredients as $ingredientName) {
            $ingredient = new Ingredient();
            $ingredient->name = $ingredientName;
            $ingredient->recipe_id = $recipe->id;
            $ingredient->save();
        }

        $recipe->steps()->delete();
        foreach ($request->steps as $stepDescription) {
            $step = new Step();
            $step->description = $stepDescription;
            $step->recipe_id = $recipe->id;
            $step->save();
        }

        return redirect()->route('recipes.index')->with('success', 'Recipe updated successfully.');
    }

    // Menghapus resep dari database
    public function destroy($id)
    {
        $recipe = Recipe::findOrFail($id);
        if ($recipe->image) {
            Storage::delete($recipe->image); // Hapus gambar jika ada
        }
        $recipe->delete();
        return redirect()->route('recipes.index')->with('success', 'Recipe deleted successfully.');
    }

    public function category($category)
{
    $recipes = Recipe::where('category', $category)->get();
    return view('recipes.index', compact('recipes'));
}

public function cookingMethod($method)
{
    $recipes = Recipe::where('cooking_method', $method)->get();
    return view('recipes.index', compact('recipes'));
}

public function bahan($bahan)
{
    $recipes = Recipe::where('bahan', $bahan)->get();
    return view('recipes.index', compact('recipes'));
}

public function populer()
{
    $recipes = Recipe::orderBy('views', 'desc')->take(10)->get();
    return view('recipes.index', compact('recipes'));
}

public function favorit()
{
    $recipes = Recipe::orderBy('favorites', 'desc')->take(10)->get();
    return view('recipes.index', compact('recipes'));
}

public function terbaru()
{
    $recipes = Recipe::orderBy('created_at', 'desc')->take(10)->get();
    return view('recipes.index', compact('recipes'));
}

public function teruji()
{
    $recipes = Recipe::where('is_verified', true)->get();
    return view('recipes.index', compact('recipes'));
}

// Menampilkan halaman bahan makanan
public function showIngredients() {
    $ingredients = Ingredient::all(); // Mengambil semua bahan dari database
    return view('bahan', compact('ingredients'));
}

// Mengambil resep berdasarkan bahan yang dipilih
public function getRecipesByIngredients(Request $request) {
    $ingredients = $request->input('ingredients', []);

    if (empty($ingredients)) {
        return response()->json([]);
    }

    $recipes = Recipe::whereHas('ingredients', function ($query) use ($ingredients) {
        $query->whereIn('name', $ingredients);
    })->get();

    return response()->json($recipes);
}

}
