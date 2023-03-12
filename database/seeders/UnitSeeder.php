<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units = [
            'MIPA',
            'FTEKNIK',
            'FEB',
            'HUKUM',
            'FISIPOL',
            'ILMU BUDAYA',
            'PERIKANAN',
            'FAPERTA',
            'FAHUTAN',
            'FARMASI',
            'KEDOKTERAN',
            'KESMAS',
            'FKIP'
        ];

        foreach ($units as $unit) {
            Unit::create(['name' => $unit]);
        }
    }
}
