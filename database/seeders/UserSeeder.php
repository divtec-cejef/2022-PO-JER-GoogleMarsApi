<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // admin par défaut
        DB::table('users')->insert([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@divtec.ch',
            'is_admin' => 1,
            'password' => app('hash')->make('inf3divtec$'),
        ]);
    }
}
