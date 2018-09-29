<?php

use Illuminate\Database\Seeder;

class RestaurantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Restaurant::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        factory(App\Restaurant::class, 3)->create();
    }
}
