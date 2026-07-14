<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    public function run(): void
    {
        $states = json_decode(file_get_contents(database_path('seeders/data/states.json')), true);
        $countries = Country::pluck('id', 'code')->toArray();

        foreach ($states as $state) {
            $countryCode = strtolower($state['country_code']);

            if (isset($countries[$countryCode])) {
                State::create([
                    'country_id' => $countries[$countryCode],
                    'country_code' => $countryCode,
                    'name' => $state['name'],
                    'native' => $state['native'],
                    'iso2' => $state['iso2'],
                    'iso3166_2' => $state['iso3166_2'],
                    'latitude' => $state['latitude'],
                    'longitude' => $state['longitude'],
                    'timezone' => $state['timezone'],
                ]);
            }
        }
    }
}
