<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use App\Models\Patient;
use App\Models\User;

class GynaecologicalTestsTableSeeder extends Seeder
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
            DB::table('gynaecological_tests')->insert([
                'patient_id' => $faker->randomElement($patients),
                'doctor_id' => $faker->randomElement($doctors),
                'date_of_last_period' => $faker->date(),
                'menstrual_cycle_abnormalities' => $faker->sentence,
                'contact_bleeding' => $faker->boolean,
                'menopause' => $faker->boolean,
                'menopause_age' => $faker->numberBetween(40, 60),
                'using_of_contraception' => $faker->boolean,
                'contraception_method' => $faker->optional()->randomElement(['Pills', 'IUD', 'Injectable', 'Other']),
                'other_contraception_method' => $faker->optional()->sentence,
                'investigation_files' => json_encode([$faker->imageUrl(), $faker->imageUrl()]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
