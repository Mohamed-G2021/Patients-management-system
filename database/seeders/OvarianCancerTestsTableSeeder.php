<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class OvarianCancerTestsTableSeeder extends Seeder
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
            DB::table('ovarian_cancer_tests')->insert([
                'patient_id' => $faker->randomElement($patients),
                'doctor_id' => $faker->randomElement($doctors),
                'breast_cancer_history' => $faker->boolean,
                'relatives_with_ovarian_cancer' => $faker->boolean,
                'gene_mutation_or_lynch_syndrome' => $faker->boolean,
                'tvs_result' => $faker->optional()->sentence,
                'tvs_comment' => $faker->optional()->sentence,
                'ca-125_result' => $faker->optional()->sentence,
                'ca-125_comment' => $faker->optional()->sentence,
                'recommendations' => $faker->optional()->sentence,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
