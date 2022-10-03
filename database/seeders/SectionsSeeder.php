<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionsSeeder extends Seeder
{
    public function run()
    {
        DB::table('sections')->insert([
            'nom' => 'INF',
        ]);
        DB::table('sections')->insert([
            'nom' => 'HOR',
        ]);
        DB::table('sections')->insert([
            'nom' => 'LAC',
        ]);
        DB::table('sections')->insert([
            'nom' => 'MMC',
        ]);
        DB::table('sections')->insert([
            'nom' => 'DCM',
        ]);
        DB::table('sections')->insert([
            'nom' => 'ELT',
        ]);
        DB::table('sections')->insert([
            'nom' => 'AUT',
        ]);
        DB::table('sections')->insert([
            'nom' => 'ENT',
        ]);
    }
}
