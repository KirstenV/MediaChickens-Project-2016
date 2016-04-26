<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatFasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fases', function (Blueprint $table) {
            $table->increments('id');
			$table->string('titel');
			$table->text('beschrijving')->nullable();
			$table->enum('fases', array('open fase','in progress','fase afgesloten'));
			$table->string('fases_picture')->nullable()->default('fases_picture_default.jpg');
			$table->integer('projecten_id')->unsigned();
			$table->foreign('projecten_id')->references('id')->on('projecten');
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
        Schema::drop('fases');
    }
}
