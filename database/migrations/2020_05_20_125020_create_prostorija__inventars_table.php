<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProstorijaInventarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prostorija__inventar', function (Blueprint $table) {
            $table->integer('prostorija_id')->unsigned()->index();
            $table->foreign('prostorija_id')->references('id')->on('prostorija')->onDelete('cascade');
            $table->integer('inventar_id')->unsigned()->index();
            $table->foreign('inventar_id')->references('id')->on('inventar')->onDelete('cascade');
            
            $table->timestamps();
            $table->primary(['prostorija_id', 'inventar_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::dropIfExists('prostorija__inventar');
    }
}
