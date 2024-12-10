<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'recipe_id'];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
    
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'recipe_ingredient', 'ingredient_id', 'recipe_id')
                    ->withPivot('quantity', 'unit');
    }
    
    
    


}
