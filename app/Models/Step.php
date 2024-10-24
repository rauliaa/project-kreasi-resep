<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Recipe;

class Step extends Model
{
    use HasFactory;

    protected $fillable = ['instruction', 'step_number', 'recipe_id'];

    /**
     * Get the recipe that owns the step.
     */
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
