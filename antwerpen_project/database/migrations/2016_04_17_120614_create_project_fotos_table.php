<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectFotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_fotos', function (Blueprint $table) {
           $table->increments('id');
			$table->string('project_picture');
			$table->integer('projecten_id')->unsigned();
			$table->foreign('projecten_id')->references('id')->on('projecten')->onDelete('cascade');
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
        Schema::drop('project_fotos');
    }
}
