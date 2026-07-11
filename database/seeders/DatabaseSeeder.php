<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            LanguageSeeder::class,
            CountrySeeder::class,
            SettingSeeder::class,
            RoleSeeder::class,
            AdminSeeder::class,
            StaticPageSeeder::class,

            //
        ]);
    }
}
