<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class RecipeSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Menyiapkan kategori yang ada di database
        $categories = [
            'Makanan Pembuka',
            'Makanan Utama',
            'Makanan Pendamping',
            'Makanan Penutup'
        ];

        // Menyiapkan masakan yang ada
        $cuisines = [
            'Makanan International',
            'Makanan Traditional',
            'Makanan Cepat Saji'
        ];

        // Mendapatkan ID purpose dari database
        $purposeIds = DB::table('purposes')->pluck('id')->toArray();

        for ($i = 0; $i < 10; $i++) {
            Recipe::create([
                'title' => $faker->sentence,
                'description' => $faker->paragraph,
                'instructions' => $faker->paragraph,
                'image' => $faker->imageUrl(),
                'prep_time' => $faker->numberBetween(5, 120),
                'cook_time' => $faker->numberBetween(5, 120),
                'price' => $faker->numberBetween(1, 100),
                'time' => $faker->numberBetween(1, 10),
                'servings' => $faker->numberBetween(1, 10),
                'category_id' => DB::table('categories')->inRandomOrder()->first()->id,
                'user_id' => User::inRandomOrder()->first()->id,
                'cuisine' => $faker->randomElement($cuisines),
                'purpose_id' => $faker->randomElement($purposeIds),
                'ingredient' => $faker->sentence, 
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
