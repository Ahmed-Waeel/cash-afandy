<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = json_decode(file_get_contents(database_path('seeders/data/countries.json')), true);

        foreach ($countries as $code => $country) {
            Country::create([
                'code' => strtolower($code),
                'name' => $country['name'],
                'native' => $country['native'],
                'phone' => $country['phone'],
                'continent' => $country['continent'],
                'capital' => $country['capital'],
                'currency' => $country['currency'],
                'languages' => $country['languages'],
            ]);
        }
    }
}
