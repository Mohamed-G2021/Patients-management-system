<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        foreach (range(1, 50) as $index) {
            DB::table('patients')->insert([
                'national_id' => $faker->unique()->numerify('###########'),
                'name' => $faker->name,
                'age' => $faker->numberBetween(18, 90),
                'phone_number' => $faker->phoneNumber,
                'patient_code' => $faker->unique()->randomNumber(5),
                'date_of_birth' => $faker->date('Y-m-d', '-20 years'),
                'address' => $faker->address,
                'marital_state' => $faker->randomElement(['Single', 'Married', 'Divorced', 'Widowed']),
                'relative_name' => $faker->optional()->name,
                'relative_phone' => $faker->optional()->phoneNumber,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
