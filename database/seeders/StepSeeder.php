<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StepSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $index) {
            DB::table('steps')->insert([
                'recipe_id' => DB::table('recipes')->inRandomOrder()->first()->id, 
                'step_number' => $index,
                'instruction' => $faker->sentence, 
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
