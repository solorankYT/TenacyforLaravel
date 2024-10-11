<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstitutionsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('institutions')->insert([
            [
                'institution' => 'UPLB',
                'effective_date' => '2024-01-01',
            ],
            [
                'institution' => 'UPM',
                'effective_date' => '2024-01-01',
            ],
            [
                'institution' => 'UPD',
                'effective_date' => '2024-01-01',
            ],
           
        ]);
    }
}
