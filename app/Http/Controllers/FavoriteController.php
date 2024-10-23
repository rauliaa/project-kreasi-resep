<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    // Menyimpan resep sebagai favorit
    public function store($recipeId)
    {
        // Mendapatkan resep berdasarkan ID
        $recipe = Recipe::findOrFail($recipeId);

        // Mengecek apakah user sudah login
        if (Auth::check()) {
            // Mengecek apakah resep sudah ada di favorit user
            $exists = Favorite::where('user_id', Auth::id())
                              ->where('recipe_id', $recipe->id)
                              ->exists();

            if (!$exists) {
                // Menambahkan resep ke favorit
                Favorite::create([
                    'user_id' => Auth::id(),
                    'recipe_id' => $recipe->id,
                ]);

                return redirect()->back()->with('success', 'Resep berhasil ditambahkan ke favorit.');
            } else {
                return redirect()->back()->with('info', 'Resep sudah ada di daftar favorit.');
            }
        }

        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    // Menghapus resep dari favorit
    public function destroy($recipeId)
    {
        // Mengecek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Mendapatkan favorit berdasarkan user dan ID resep
        $favorite = Favorite::where('user_id', Auth::id())
                            ->where('recipe_id', $recipeId)
                            ->first();

        if ($favorite) {
            $favorite->delete();
            return redirect()->back()->with('success', 'Resep berhasil dihapus dari favorit.');
        }

        return redirect()->back()->with('error', 'Resep tidak ditemukan di daftar favorit.');
    }
}
