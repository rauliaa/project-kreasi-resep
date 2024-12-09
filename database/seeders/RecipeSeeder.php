<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recipe;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class RecipeSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            Recipe::create([
                'title' => $faker->sentence,
                'description' => $faker->paragraph,
                'instructions' => $faker->paragraph,
                'image' => $faker->imageUrl(640, 480, 'food', true),
                'cook_time' => $faker->numberBetween(5, 120),
                'categorie_id' => DB::table('categories')->inRandomOrder()->first()->id,
                'ingredients' => $faker->sentence,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
