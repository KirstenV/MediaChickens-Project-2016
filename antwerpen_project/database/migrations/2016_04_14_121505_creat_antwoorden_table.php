<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatAntwoordenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antwoorden', function (Blueprint $table) {
            $table->increments('id');
			$table->text('antwoorden')->nullable();
			$table->integer('vragen_id')->unsigned();
			$table->foreign('vragen_id')->references('id')->on('vragen');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
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
        Schema::drop('antwoorden');
    }
}
