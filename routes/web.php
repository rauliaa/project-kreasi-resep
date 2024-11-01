<?php

use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TipController;
use Illuminate\Http\Request;

// Rute untuk halaman utama (home)
Route::get('/', function () {
    return view('home');
})->name('home');

// Rute untuk halaman home setelah login
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Rute Register dan Login
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);

// Rute Logout (hanya metode POST)
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Rute untuk profile
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show')->middleware('auth');

// Rute untuk Recipe dan Subcategory
Route::resource('recipes', RecipeController::class);
Route::get('/subcategories', [SubCategoryController::class, 'index'])->name('subcategories.index');
Route::get('/subcategories/{id}', [SubCategoryController::class, 'show'])->name('subcategories.show');
Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
Route::get('/recipes/{id}', [RecipeController::class, 'show'])->name('recipes.show');
Route::get('/recipes/type/{type}', [RecipeController::class, 'byType'])->name('recipes.byType');
Route::get('/recipes/method/{method}', [RecipeController::class, 'showByMethod'])->name('recipes.byMethod');
Route::get('/recipes/by-cuisine/{cuisine}', [RecipeController::class, 'byCuisine'])->name('recipes.byCuisine');
Route::get('/recipes/by-ingredient/{ingredient}', [RecipeController::class, 'byIngredient'])->name('recipes.byIngredient');
Route::get('/recipes/purpose/{purpose}', [RecipeController::class, 'byPurpose'])->name('recipes.byPurpose');
Route::get('/recipes/recommendation/{type}', [RecipeController::class, 'byRecommendation'])->name('recipes.byRecommendation');
Route::get('/recipes/{id}/edit', [RecipeController::class, 'edit'])->name('recipes.edit');
Route::get('/recipe/{id}', [RecipeController::class, 'show'])->name('recipe.show');

// Rute untuk menambah dan menampilkan favorit
Route::post('/favorites/{id}', [FavoriteController::class, 'store'])->middleware('auth')->name('favorites.store');
Route::get('/favorites', [FavoriteController::class, 'index'])->middleware('auth')->name('favorites.index');
//Route::get('/favorite-recipes', [RecipeController::class, 'favorite'])->name('favorite.recipes')->middleware('auth'); // Keep in FavoriteController
Route::middleware(['auth'])->group(function () {
    Route::get('/favorite-recipes', [RecipeController::class, 'favorite'])->name('favorite.recipes');
});


// Rute untuk mengecek autentikasi
Route::get('/check-auth', function () {
    return response()->json(['authenticated' => auth()->check()]);
});

// Rute untuk menampilkan semua komentar/diskusi pengguna
Route::get('/user-comments', [CommentController::class, 'index'])->name('user.comments');

// Rute untuk menyimpan URL redirect setelah login
Route::post('/set-redirect-url', [LoginController::class, 'setRedirectUrl'])->name('set.redirect.url');

// rute tip
Route::resource('tips', TipController::class)->except(['edit', 'destroy', 'update']);
Route::get('/tips', [TipController::class, 'index'])->name('tips.index');
Route::get('/tips/{id}', [TipController::class, 'show'])->name('tips.show');
Route::get('/tips/create', [TipController::class, 'create'])->name('tips.create')->middleware('auth');
Route::put('/tips/{id}', [TipController::class, 'update'])->name('tips.update')->middleware('auth');
Route::get('/tips/{id}/edit', [TipController::class, 'edit'])->name('tips.edit')->middleware('auth');
Route::put('/tips/{id}', [TipController::class, 'update'])->name('tips.update')->middleware('auth');
Route::delete('/tips/{id}', [TipController::class, 'destroy'])->name('tips.destroy')->middleware('auth');

// rute bahan
Route::get('/bahan', [RecipeController::class, 'showIngredients'])->name('bahan.index');
Route::post('/recipes', [RecipeController::class, 'showRecipes'])->name('recipes.show');


