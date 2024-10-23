<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 

class PurposeSeeder extends Seeder
{
    public function run()
    {
        $purposes = [
            ['id' => 1, 'name' => 'Makanan Sehat / Diet'],
            ['id' => 2, 'name' => 'Makanan Anak'],
            ['id' => 3, 'name' => 'Cemilan'],
        ];

        DB::table('purposes')->insert($purposes);
    }
}
