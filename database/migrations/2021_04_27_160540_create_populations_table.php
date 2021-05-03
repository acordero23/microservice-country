<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePopulationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('population', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 150);

            $table->char('codauto', 4)->nullable();
            $table->char('cpro', 4)->nullable();
            $table->char('cnum', 4)->nullable();
            $table->char('dc', 4)->nullable();

            $table->string('zip_code', 10);
            $table->integer('county_id')->unsigned();
            $table->dateTime('creation_date');
            $table->dateTime('modification_date')->nullable();
            $table->enum('nacceso', ['publico', 'privado', 'borrador']);

            $table->foreign('county_id')->references('id')->on('county');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('population');
    }
}
