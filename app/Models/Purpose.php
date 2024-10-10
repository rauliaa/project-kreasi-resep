<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purpose extends Model
{
    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }
}

