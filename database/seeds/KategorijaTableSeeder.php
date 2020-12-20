<?php

use Illuminate\Database\Seeder;

class KategorijaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Kategorija::class, 30)->create();
    }
}
