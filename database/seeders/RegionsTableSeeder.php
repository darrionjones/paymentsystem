<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = [
            'Ashanti',
            'Brong-Ahafo',
            'Central',
            'Eastern',
            'Greater Accra',
            'Northern',
            'Upper East',
            'Upper West',
            'Volta',
            'Western',
            'Ahafo',
            'Bono East',
            'North East',
            'Oti',
            'Savannah',
            'Western North',
        ];

        foreach ($regions as $region) {
            Region::create(['name' => $region]);
        }
    }
}
