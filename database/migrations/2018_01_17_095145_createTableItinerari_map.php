<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableItinerariMap extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itinerari_travel_map', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_itinerario');
            $table->foreign('id_itinerario')->references('id')->on('itinerari');
            $table->unsignedInteger('id_travel');
            $table->foreign('id_travel')->references('id')->on('travels');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
