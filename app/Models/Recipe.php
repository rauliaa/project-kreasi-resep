<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image',
        'prep_time',
        'cook_time',
        'servings',
    ];

    /**
     * Get the user that owns the recipe.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the ingredients for the recipe.
     */
    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }

    /**
     * Get the steps for the recipe.
     */
    public function steps()
    {
        return $this->hasMany(Step::class);
    }

    /**
     * Get the comments for the recipe.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the categories for the recipe.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'recipe_category');
    }
}
