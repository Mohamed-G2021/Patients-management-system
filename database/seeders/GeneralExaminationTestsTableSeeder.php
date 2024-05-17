<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeneralExaminationTestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        
        // Get all patient and doctor IDs
        $patients = Patient::pluck('id')->toArray();
        $doctors = User::pluck('id')->toArray();

        foreach (range(1, 50) as $index) {
            DB::table('general_examination_tests')->insert([
                'patient_id' => $faker->randomElement($patients),
                'doctor_id' => $faker->randomElement($doctors),
                'height' => $faker->randomFloat(2, 100, 200),
                'pulse' => $faker->numberBetween(60, 100),
                'weight' => $faker->randomFloat(2, 40, 150),
                'random_blood_sugar' => $faker->randomFloat(2, 70, 300),
                'blood_pressure' => $faker->randomElement(['120/80', '130/90', '140/100']),
                'investigation_files' => json_encode([$faker->imageUrl(), $faker->imageUrl()]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
