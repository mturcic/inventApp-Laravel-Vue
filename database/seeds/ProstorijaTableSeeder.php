<?php

use Illuminate\Database\Seeder;

class ProstorijaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Prostorija::class, 30)->create();
    }
}
