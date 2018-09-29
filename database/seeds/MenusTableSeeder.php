<?php

use App\Menu;
use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = \Faker\Factory::create();

        for ($i = 1; $i <= 3; $i++) {
            for($j = 1; $j <= 12; $j++) {
                Menu::create([
                    'id' => $j,
                    'restaurant_id' => $i,
                    'name' => $faker->lastName,
                    'price' => 12.99
                ]);
            }
        }
    }
}
