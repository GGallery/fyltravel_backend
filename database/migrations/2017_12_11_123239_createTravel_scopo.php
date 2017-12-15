<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelScopo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travels_scopi', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_travel');
            $table->foreign('id_travel')->references('id')->on('travels');
            $table->string('scopo');
            $table->string('icona');
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
