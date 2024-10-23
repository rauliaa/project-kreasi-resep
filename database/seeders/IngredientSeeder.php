<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 
use Faker\Factory as Faker;

class IngredientSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Buat loop untuk membuat beberapa ingredients
        foreach (range(1, 50) as $index) {
            DB::table('ingredients')->insert([
                'name' => $faker->word,
                'quantity' => $faker->randomFloat(2, 1, 100),
                'ingredient' => $faker->sentence, 
                'recipe_id' => DB::table('recipes')->inRandomOrder()->first()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
