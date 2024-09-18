<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ingredient;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipe_id',
        'name',
        'quantity',
        'unit',
    ];

    /**
     * Get the recipe that owns the ingredient.
     */
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
