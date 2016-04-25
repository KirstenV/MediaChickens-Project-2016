<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatVragenTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vragen', function (Blueprint $table) {
              $table->increments('id');
			$table->enum('choices', array('open vragen','meerkeuzevragen','Gesloten vragen','Suggestieve vragen','Controlevragen'));
			$table->text('vraag');
			$table->text('mogelijke_antwoorden_1')->nullable();
			$table->text('mogelijke_antwoorden_2')->nullable();
			$table->text('mogelijke_antwoorden_3')->nullable();
			$table->text('mogelijke_antwoorden_4')->nullable();
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
        Schema::drop('vragen');
    }
}
