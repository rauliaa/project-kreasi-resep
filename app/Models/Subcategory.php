<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Recipe;
use App\Models\Category;

class Subcategory extends Model
{
    // If you are not using the default 'id' as the primary key, specify it here.
    // protected $primaryKey = 'your_primary_key';

    // If your table name is not 'subcategories', define the table name
    // protected $table = 'your_table_name';

    // Add the fillable attributes
    protected $fillable = ['name', 'category_id'];

    // Define relationships (for example, if each subcategory belongs to a category)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // If subcategories can have many recipes, you could add:
    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }
}
