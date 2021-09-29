<?php

namespace Database\Seeders;

use App\Models\EducationSeeder as ModelsEducationSeeder;
use Illuminate\Database\Seeder;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $educations = [
            'ბაკალავრი',
            'მაგისტრატურა',
            'დოქტურანტურა'
        ];

        foreach($educations as $education) {
            ModelsEducationSeeder::create([
                'name' => $education
            ]);
        }
    }
}
