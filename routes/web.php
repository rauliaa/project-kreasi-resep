<?php

use App\Http\Controllers\{
    RecipeController, CategorieController, CommentController, FavoriteController,
    Auth\LoginController, SearchController, Auth\RegisterController,
    HomeController, CategoriTypeController, ProfileController, TipController, IngredientController
};
use Illuminate\Support\Facades\Route;

// Home routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Register and Login routes
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Profile route with auth middleware
Route::middleware('auth')->get('/profile', [ProfileController::class, 'show'])->name('profile.show');

// Recipes routes
Route::prefix('recipes')->name('recipes.')->group(function () {
    Route::get('/', [RecipeController::class, 'index'])->name('index');
    Route::middleware('auth')->group(function () {
        Route::get('/create', [RecipeController::class, 'create'])->name('create');
        Route::post('/', [RecipeController::class, 'store'])->name('store');
        Route::get('/{recipe}/edit', [RecipeController::class, 'edit'])->name('edit');
        Route::delete('/{recipe}', [RecipeController::class, 'destroy'])->name('destroy'); 
        Route::put('/{recipe}', [RecipeController::class, 'update'])->name('update');
    });

    Route::get('/{recipe}', [RecipeController::class, 'show'])->name('show');
    Route::get('/by-type/{type}', [RecipeController::class, 'showByType'])->name('byType');
    Route::get('/by-recommendation/{recommendation}', [RecipeController::class, 'showByRecommendation'])->name('byRecommendation');
    Route::get('/by-method/{method}', [RecipeController::class, 'showByMethod'])->name('byMethod');
    Route::get('/by-cuisine/{cuisine}', [RecipeController::class, 'showByCuisine'])->name('byCuisine');
    Route::get('/by-ingredient/{ingredient}', [RecipeController::class, 'showByIngredient'])->name('byIngredient');
    Route::get('/by-purpose/{purpose}', [RecipeController::class, 'showByPurpose'])->name('byPurpose');
    Route::get('/favorite/recipes', [FavoriteController::class, 'index'])->name('favorite.recipes');
});

// Categories and Subcategories routes
Route::prefix('kategori')->name('kategori.')->group(function () {
    Route::get('/', [CategorieController::class, 'index'])->name('index');
    Route::get('/{categorie}', [CategorieController::class, 'show'])->name('show');
});

// Favorites routes (auth required)
Route::middleware('auth')->prefix('favorites')->name('favorites.')->group(function () {
    // Add a recipe to favorites
    Route::post('/{id}', [FavoriteController::class, 'store'])->name('store');
    
    // View all favorites
    Route::get('/', [FavoriteController::class, 'index'])->name('index');
    
    // Specific route to view favorite recipes
    Route::get('/recipes', [FavoriteController::class, 'index'])->name('recipes');
});

Route::get('/favorite/recipes', [FavoriteController::class, 'index'])->name('favorite.recipes');
Route::get('/favorite/recipes', [FavoriteController::class, 'index'])->middleware('auth')->name('favorite.recipes');
Route::get('/profile/favorites', [ProfileController::class, 'favorites'])->name('profile.favorites');
Route::post('/recipes/{recipe}/save', [RecipeController::class, 'saveRecipe'])->name('recipes.save');
Route::get('recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');
Route::post('/recipes/{id}/save', [RecipeController::class, 'save'])->name('recipes.save');
Route::get('/favorite-recipes', [RecipeController::class, 'favoriteRecipes'])->name('favorites.index');
Route::delete('/profile/favorite/{recipe}', [ProfileController::class, 'removeFavorite'])->name('profile.favorite.remove');
Route::get('/profile/favorites', [ProfileController::class, 'favorites'])->name('favorites.index');
Route::get('/profile/favorites', [ProfileController::class, 'favorites'])->name('favorites.index')->middleware('auth');
Route::get('/profile/favorites', [ProfileController::class, 'favorites'])->name('profile.favorites');
Route::post('/recipes/save-favorite/{recipeId}', [RecipeController::class, 'saveFavorite'])->name('recipes.save.favorite');


// Auth check and redirect URL setting
Route::get('/check-auth', fn() => response()->json(['authenticated' => auth()->check()]));
Route::post('/set-redirect-url', [LoginController::class, 'setRedirectUrl'])->name('set.redirect.url');

// User comments route
Route::get('/user-comments', [CommentController::class, 'index'])->name('user.comments');
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
// Route dengan middleware auth
Route::middleware('auth')->group(function () {
    Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::get('/recipes/{recipeId}/comments/create', [CommentController::class, 'create'])->name('comments.create');
    Route::post('/recipes/{recipeId}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/comments/{id}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{id}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
});


// Tips routes with auth middleware
Route::resource('tips', TipController::class)->except(['edit', 'destroy', 'update']);
Route::middleware('auth')->prefix('tips')->name('tips.')->group(function () {
    Route::get('/{tip}/edit', [TipController::class, 'edit'])->name('edit');
    Route::put('/{tip}', [TipController::class, 'update'])->name('update');
    Route::delete('/{tip}', [TipController::class, 'destroy'])->name('destroy');
});

// Ingredient route
Route::get('/ingredients', [RecipeController::class, 'showIngredients'])->name('ingredients.index');
Route::get('/ingredients/{ingredient}', [IngredientController::class, 'show'])->name('ingredients.show');
Route::get('ingredients/search', [IngredientsController::class, 'search'])->name('ingredients.search');
Route::get('/ingredients', [RecipeController::class, 'showIngredients']);
Route::post('/get-recipes', [RecipeController::class, 'getRecipes'])->name('get.recipes');


// Auth check and redirect URL setting
Route::get('/check-auth', fn() => response()->json(['authenticated' => auth()->check()]));
Route::post('/set-redirect-url', [LoginController::class, 'setRedirectUrl'])->name('set.redirect.url');