<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatReacktieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reactie', function (Blueprint $table) {
            $table->increments('id');
			$table->string('reactie_masseg', 100)->nullable();
			$table->integer('rating')->unsigned()->nullable();
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			$table->integer('projecten_id')->unsigned();
			$table->foreign('projecten_id')->references('id')->on('projecten');
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
        Schema::drop('reactie');
    }
}
