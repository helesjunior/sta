<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfpredocnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sfpredocns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sfpredoc_id');
            $table->string('codCredorDevedor')->nullable();
            $table->string('codTipoBanco')->nullable();
            $table->string('codInscGen')->nullable();
            $table->timestamps();
        });

        Schema::table('sfpredocns', function (Blueprint $table) {
            $table->foreign('sfpredoc_id')->references('id')->on('sfpredoc')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sfpredocns');
    }
}
