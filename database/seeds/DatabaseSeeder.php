<?php

use App\CompanyOffres;
use App\Driver;
use App\OffersDivere;
use Faker\Factory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        for ($i = 0, $ii = 10; $i < $ii; $i++) {
            CompanyOffres::create([
                'name' => $faker->name(),
                'offres' => $faker->unique()->numberBetween(10, 50),
            ]);
        }

        // $this->call(UsersTableSeeder::class);
    }
}
