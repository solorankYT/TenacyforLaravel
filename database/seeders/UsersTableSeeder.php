<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'institution' => 'UPLB',
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'password' => bcrypt('password'), 
                'email_verified_at' => now(), 
                'remember_token' => null, 
                'created_at' => now(), 
                'updated_at' => now(), 
            ],
            [
                'institution' => 'UPM',
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'institution' => 'UPM',
                'name' => 'Mark Johnson',
                'email' => 'mark.johnson@example.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
