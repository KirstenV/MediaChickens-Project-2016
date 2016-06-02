<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReactionOnReview extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reaction_on_review', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reactie_masseg', 100)->nullable();
            $table->integer('reactie_id')->unsigned()->nullable();;
            $table->foreign('reactie_id')->references('id')->on('reactie')->onDelete('cascade');
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
        Schema::drop('reaction_on_review');
    }
}
