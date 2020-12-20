<?php

use Illuminate\Database\Seeder;

class InventarTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Inventar::class, 30)->create();
    }
}
