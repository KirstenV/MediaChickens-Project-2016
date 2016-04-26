<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocatieProjetenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locatie_projecten', function (Blueprint $table) {
               $table->increments('id');
			$table->integer('projecten_id')->unsigned();
			$table->foreign('projecten_id')->references('id')->on('projecten');
			$table->integer('locatie_id')->unsigned();
			$table->foreign('locatie_id')->references('id')->on('locatie');
			$table->softDeletes();
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
        Schema::drop('locatie_projecten');
    }
}
