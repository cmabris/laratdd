<?php

use Illuminate\Database\Seeder;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('professions')->insert([
            'title' => 'Desarrollador Back-End',
        ]);
        DB::table('professions')->insert([
            'title' => 'Desarrollador Front-End',
        ]);
        DB::table('professions')->insert([
            'title' => 'Diseñador web',
        ]);
    }
}
