<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use App\Models\Patient;
use App\Models\User;

class ObstetricTestsTableSeeder extends Seeder
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
            DB::table('obstetric_tests')->insert([
                'patient_id' => $faker->randomElement($patients),
                'doctor_id' => $faker->randomElement($doctors),
                'gravidity' => $faker->numberBetween(0, 10),
                'parity' => $faker->numberBetween(0, 10),
                'abortion' => $faker->numberBetween(0, 5),
                'notes' => $faker->optional()->sentence,
                'investigation_files' => $faker->optional()->imageUrl(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
