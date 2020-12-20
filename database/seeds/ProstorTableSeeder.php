<?php

use Illuminate\Database\Seeder;

class ProstorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Prostor::class, 30)->create();
    }
}
