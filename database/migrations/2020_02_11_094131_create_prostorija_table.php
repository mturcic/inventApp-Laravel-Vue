<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProstorijaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prostorija', function (Blueprint $table) {
            $table->increments('id');
            $table->mediumText('naziv_prostorije')->nullable();
            $table->integer('prostor_id')->unsigned()->index()->nullable();
            
            $table->timestamps();

            $table->foreign('prostor_id')->references('id')->on('prostor')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prostorija');
    }
}
