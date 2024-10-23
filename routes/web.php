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


Route::get('/', function () {
    return view('home');
})->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show')->middleware('auth');
Route::get('/subcategories', [SubCategoryController::class, 'index'])->name('subcategories.index');
Route::get('/subcategories/{id}', [SubCategoryController::class, 'show'])->name('subcategories.show');
Route::resource('recipes', RecipeController::class);
Route::get('/recipes/type/{type}', [RecipeController::class, 'byType'])->name('recipes.byType');
Route::get('/recipes/method/{method}', [RecipeController::class, 'showByMethod'])->name('recipes.byMethod');
Route::get('/recipes/by-cuisine/{cuisine}', [RecipeController::class, 'byCuisine'])->name('recipes.byCuisine');
Route::get('/recipes/by-ingredient/{ingredient}', [RecipeController::class, 'byIngredient'])->name('recipes.byIngredient');
Route::get('/recipes/purpose/{purpose}', [RecipeController::class, 'byPurpose'])->name('recipes.byPurpose');
Route::get('/recipes/recommendation/{type}', [RecipeController::class, 'byRecommendation'])->name('recipes.byRecommendation');
Route::get('/favorite-recipes', [FavoriteController::class, 'index'])->name('favorite.recipes');
Route::post('/favorites/{recipe}', [FavoriteController::class, 'store'])->name('favorites.store');
Route::delete('/favorites/{recipe}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
Route::get('/user-comments', [CommentController::class, 'index'])->name('user.comments');
Route::get('/recipes/{id}/edit', [RecipeController::class, 'edit'])->name('recipes.edit');