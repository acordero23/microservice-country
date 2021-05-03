<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('state', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 150);
            $table->char('abbreviation', 3)->nullable();
            $table->integer('country_id')->unsigned();
            $table->dateTime('creation_date');
            $table->dateTime('modification_date')->nullable();
            $table->enum('nacceso', ['publico', 'privado', 'borrador']);

            $table->foreign('country_id')->references('id')->on('country');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('state');
    }
}