<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class OsteoporosisTestsTableSeeder extends Seeder
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
            DB::table('osteoporosis_tests')->insert([
                'patient_id' => $faker->randomElement($patients),
                'doctor_id' => $faker->randomElement($doctors),
                'age' => $faker->numberBetween(30, 90),
                'weight' => $faker->randomFloat(2, 40, 150),
                'current_oestrogen_use' => $faker->boolean,
                'recommendations' => $faker->optional()->sentence,
                'investigation_files' => json_encode([$faker->imageUrl(), $faker->imageUrl()]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
