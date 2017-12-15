<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTravelConsigliatoaMap extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travels_consigliatoa_map', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_consigliatoa');
            $table->foreign('id_consigliatoa')->references('id')->on('travels_consigliatoa');
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
