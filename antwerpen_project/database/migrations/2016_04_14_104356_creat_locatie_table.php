<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatLocatieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locatie', function (Blueprint $table) {
            $table->increments('id');
			$table->string('straat_naam');
			$table->integer('poscode')->unsigned()->nullable();
			$table->integer('huisnummer')->unsigned()->nullable();
			$table->double('position_latitude')->nullable();
			$table->double('position_longitude')->nullable();
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
        Schema::drop('locatie');
    }
}
