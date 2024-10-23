<?php

namespace Database\Factories;

use App\Models\Recipe;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeFactory extends Factory
{
    protected $model = Recipe::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'instructions' => $this->faker->paragraph,
            'ingredient' => $this->faker->words(5, true), 
            'cook_method' => $this->faker->randomElement(['Serba Goreng', 'Serba Rebus', 'Serba Panggang & Bakar', 'Serba Kukus', 'Serba Tumis']), 
            'image' => $this->faker->imageUrl(640, 480, 'food'),
            'prep_time' => $this->faker->numberBetween(10, 100),
            'cook_time' => $this->faker->numberBetween(10, 100),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'time' => $this->faker->numberBetween(10, 180), 
            'servings' => $this->faker->numberBetween(1, 10),
            'cuisine' => $this->faker->randomElement(['Makanan Tradisional', 'Makanan International', 'Cemilan',]), 
            'purpose_id' => null, 
            'category_id' => Category::factory(), 
            'user_id' => User::factory(), 
        ];
    }
}
