<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class PreEclampsiaTestsTableSeeder extends Seeder
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
            DB::table('pre_eclampsia_tests')->insert([
                'patient_id' => $faker->randomElement($patients),
                'doctor_id' => $faker->randomElement($doctors),
                'history_of_pre-eclampsia' => $faker->boolean,
                'number_of_pregnancies_with_pe' => $faker->numberBetween(0, 5),
                'date_of_pregnancies_with_pe' => $faker->optional()->date(),
                'fate_of_the_pregnancy' => $faker->randomElement(['1 child', '> 1 child', 'still birth']),
                'investigation_files' => json_encode([$faker->imageUrl(), $faker->imageUrl()]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
