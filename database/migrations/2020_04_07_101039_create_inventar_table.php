<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventar', function (Blueprint $table) {
            $table->increments('id');
            $table->string('generirani_kod')->nullable();
            $table->mediumText('naziv_inventara')->nullable();
            $table->string('slika_inventara')->nullable();
            $table->date('datum_nabave')->nullable();
            $table->bigInteger('godina_nabave')->nullable();
            $table->decimal('nabavna_vrijednost', 10, 2)->nullable();
            $table->decimal('stopa_amortizacije', 2, 2)->nullable();
            $table->bigInteger('kolicina')->nullable();
            $table->mediumText('jedinica_mjere')->nullable();
            $table->mediumText('napomena')->nullable();
            $table->mediumText('ulazna_faktura')->nullable();
            $table->mediumText('otpis_inventara')->nullable();
            $table->integer('vrsta_id')->unsigned()->index()->nullable();
            $table->integer('user_id')->unsigned()->index()->nullable();
            $table->integer('tvrtka_id')->unsigned()->index()->nullable();


            $table->timestamps();

            $table->foreign('vrsta_id')->references('id')->on('vrsta')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('tvrtka_id')->references('id')->on('tvrtka')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventar');
    }
}
