<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use App\Models\Patient;
use App\Models\User;


class CervixCancerTestsTableSeeder extends Seeder
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
            DB::table('cervix_cancer_tests')->insert([
                'patient_id' => $faker->randomElement($patients),
                'doctor_id' => $faker->randomElement($doctors),
                'hpv_vaccine' => $faker->boolean,
                'via_test_result' => $faker->randomElement(['Negative', 'Positive', 'Indeterminate']),
                'via_test_comment' => $faker->optional()->sentence,
                'pap_smear_result' => $faker->randomElement(['Normal', 'Abnormal']),
                'pap_smear_comment' => $faker->optional()->sentence,
                'recommendations' => $faker->optional()->sentence,
                'investigation_files' => json_encode([$faker->imageUrl(), $faker->imageUrl()]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
