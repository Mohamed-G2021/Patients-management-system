<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Patient;
use App\Models\User;
use Faker\Factory as Faker;

class BreastCancerTestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get all patient and doctor IDs
        $patients = Patient::pluck('id')->toArray();
        $doctors = User::pluck('id')->toArray();

        foreach (range(1, 50) as $index) {
            DB::table('breast_cancer_tests')->insert([
                'patient_id' => $faker->randomElement($patients),
                'doctor_id' => $faker->randomElement($doctors),
                'age' => $faker->numberBetween(20, 70),
                'family_history' => $faker->randomElement([
                    'negative',
                    'positive in second degree relatives (any number)',
                    'positive in one first degree relatives',
                    'positive in more than one first degree relatives'
                ]),
                'recommendations' => $faker->optional()->sentence,
                'investigation_files' => json_encode([$faker->imageUrl(), $faker->imageUrl()]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
