<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * Get the recipes associated with the category.
     */
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'recipe_category');
    }
}
