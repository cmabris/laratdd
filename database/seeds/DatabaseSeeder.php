<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables(['professions', 'user_profiles', 'skill_user', 'skills', 'users', 'teams', 'logins']);

        $this->call(ProfessionSeeder::class);
        $this->call(SkillSeeder::class);
        $this->call(TeamSeeder::class);
        $this->call(UserSeeder::class);
    }

    private function truncateTables(array $tables)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
