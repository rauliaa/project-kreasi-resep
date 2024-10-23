<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Recipe;

class Purpose extends Model
{
    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }
}

