<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BadgesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // INF

        DB::table('badges')->insert([
            'nom' => 'CSS 1',
            'prix' => '50',
            'section_id' => '1',
        ]);
        DB::table('badges')->insert([
            'nom' => 'CSS 2',
            'prix' => '50',
            'section_id' => '1',
        ]);
        DB::table('badges')->insert([
            'nom' => 'CSS 3',
            'prix' => '50',
            'section_id' => '1',
        ]);
        DB::table('badges')->insert([
            'nom' => 'CSS 4',
            'prix' => '50',
            'section_id' => '1',
        ]);
        DB::table('badges')->insert([
            'nom' => 'CSS 5',
            'prix' => '50',
            'section_id' => '1',
        ]);
        DB::table('badges')->insert([
            'nom' => 'CSS 6',
            'prix' => '50',
            'section_id' => '1',
        ]);
        DB::table('badges')->insert([
            'nom' => 'Cryptage 1',
            'prix' => '200',
            'section_id' => '1',
        ]);
        DB::table('badges')->insert([
            'nom' => 'Cryptage 2',
            'prix' => '200',
            'section_id' => '1',
        ]);
        DB::table('badges')->insert([
            'nom' => 'Cryptage 3',
            'prix' => '200',
            'section_id' => '1',
        ]);
        DB::table('badges')->insert([
            'nom' => 'Programmation 1',
            'prix' => '200',
            'section_id' => '1',
        ]);
        DB::table('badges')->insert([
            'nom' => 'Programmation 2',
            'prix' => '200',
            'section_id' => '1',
        ]);
        DB::table('badges')->insert([
            'nom' => 'Programmation 3',
            'prix' => '200',
            'section_id' => '1',
        ]);
        DB::table('badges')->insert([
            'nom' => 'Terminal',
            'prix' => '200',
            'section_id' => '1',
        ]);
        DB::table('badges')->insert([
            'nom' => 'HTML',
            'prix' => '200',
            'section_id' => '1',
        ]);
        DB::table('badges')->insert([
            'nom' => 'Réseau',
            'prix' => '200',
            'section_id' => '1',
        ]);

        // HOR

        DB::table('badges')->insert([
            'nom' => 'Pont',
            'prix' => '200',
            'section_id' => '2',
        ]);
        DB::table('badges')->insert([
            'nom' => 'Horloge',
            'prix' => '200',
            'section_id' => '2',
        ]);

        //LAC

        DB::table('badges')->insert([
            'nom' => 'Poire',
            'prix' => '200',
            'section_id' => '3',
        ]);

        // MMC

        DB::table('badges')->insert([
            'nom' => 'Masse et volume',
            'prix' => '200',
            'section_id' => '4',
        ]);
        DB::table('badges')->insert([
            'nom' => 'Anneaux',
            'prix' => '200',
            'section_id' => '4',
        ]);

        // DCM

        DB::table('badges')->insert([
            'nom' => 'Vaisseau',
            'prix' => '200',
            'section_id' => '5',
        ]);

        // ELT

        DB::table('badges')->insert([
            'nom' => 'Reaction',
            'prix' => '200',
            'section_id' => '6',
        ]);
        DB::table('badges')->insert([
            'nom' => 'Courant',
            'prix' => '200',
            'section_id' => '6',
        ]);

        // AUT

        DB::table('badges')->insert([
            'nom' => 'Flipper',
            'prix' => '200',
            'section_id' => '7',
        ]);
        DB::table('badges')->insert([
            'nom' => 'CNC',
            'prix' => '200',
            'section_id' => '7',
        ]);

        // Entreprises

        DB::table('badges')->insert([
            'nom' => 'Entreprise 1',
            'prix' => '150',
            'section_id' => '8',
        ]);
        DB::table('badges')->insert([
            'nom' => 'Entreprise 2',
            'prix' => '150',
            'section_id' => '8',
        ]);
        DB::table('badges')->insert([
            'nom' => 'Entreprise 3',
            'prix' => '150',
            'section_id' => '8',
        ]);
        DB::table('badges')->insert([
            'nom' => 'Entreprise 4',
            'prix' => '150',
            'section_id' => '8',
        ]);
        DB::table('badges')->insert([
            'nom' => 'Entreprise 5',
            'prix' => '150',
            'section_id' => '8',
        ]);
        DB::table('badges')->insert([
            'nom' => 'Entreprise 6',
            'prix' => '150',
            'section_id' => '8',
        ]);
        DB::table('badges')->insert([
            'nom' => 'Entreprise 7',
            'prix' => '150',
            'section_id' => '8',
        ]);
        DB::table('badges')->insert([
            'nom' => 'Entreprise 8',
            'prix' => '150',
            'section_id' => '8',
        ]);
        DB::table('badges')->insert([
            'nom' => 'Entreprise 9',
            'prix' => '150',
            'section_id' => '8',
        ]);
        DB::table('badges')->insert([
            'nom' => 'Entreprise 10',
            'prix' => '150',
            'section_id' => '8',
        ]);
    }
}


