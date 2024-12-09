<?php
namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\CategorieType;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index(Request $request)
    {
        // This ensures that $request is available for use
        $ingredients = Ingredient::all();
        $recipes = Recipe::all();
        $categorieTypes = CategorieType::with('categories')->get();
    
        // Fetch the search query from the request
        $search = $request->input('search');
    
        // Get all ingredients, but filter if a search query is provided
        if ($search) {
            // Find ingredients that match the search term
            $ingredients = Ingredient::where('name', 'like', '%' . $search . '%')->get();
        } else {
            // If no search term, get all ingredients
            $ingredients = Ingredient::all();
        }
    
        // Group ingredients by the first letter
        $groupedIngredients = $ingredients->groupBy(function ($ingredient) {
            return strtoupper(substr($ingredient->name, 0, 1));
        });
    
        return view('ingredients.index', compact('ingredients', 'groupedIngredients', 'categorieTypes', 'recipes'));
    }
    

    public function search(Request $request)
    {
        $searchQuery = $request->get('search');
        $ingredients = Ingredient::where('name', 'like', '%' . $searchQuery . '%')->get();
    
        return response()->json([
            'ingredients' => $ingredients,
            'ingredientsHtml' => view('ingredients.partials.list', compact('ingredients'))->render(),
        ]);
    }
    
    public function showForm()
    {
        $ingredients = Ingredient::all();

        // Group ingredients by their first letter
        $groupedIngredients = $ingredients->groupBy(function ($ingredient) {
            return strtoupper(substr($ingredient->name, 0, 1)); // Group by the first letter of the name
        });

        return view('ingredients.form', compact('groupedIngredients'));
    }

    public function show($id)
    {
        $ingredient = Ingredient::findOrFail($id);
        $recipes = $ingredient->recipes; // Ambil semua resep yang menggunakan bahan ini

        return view('ingredients.show', compact('ingredient', 'recipes'));
    }


}