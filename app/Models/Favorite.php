<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Recipe; 
use App\Models\User;

class Favorite extends Model
{
    protected $fillable = ['user_id', 'recipe_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
