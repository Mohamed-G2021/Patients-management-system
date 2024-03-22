<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class UterineCancerTestsTableSeeder extends Seeder
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
            DB::table('uterine_cancer_tests')->insert([
                'patient_id' => $faker->randomElement($patients),
                'doctor_id' => $faker->randomElement($doctors),
                'lynch_syndrome' => $faker->randomElement(['+ve', '-ve']),
                'irregular_bleeding' => $faker->boolean,
                'tvs_perimetrium_result' => $faker->optional()->sentence,
                'tvs_myometrium_result' => $faker->optional()->sentence,
                'tvs_endometrium_result' => $faker->optional()->sentence,
                'biopsy_result' => $faker->optional()->sentence,
                'biopsy_comment' => $faker->optional()->sentence,
                'tvs_perimetrium_comment' => $faker->optional()->sentence,
                'tvs_myometrium_comment' => $faker->optional()->sentence,
                'tvs_endometrium_comment' => $faker->optional()->sentence,
                'investigation_files' => json_encode([$faker->imageUrl(), $faker->imageUrl()]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
