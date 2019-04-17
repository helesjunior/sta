<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfrelcomitemvalorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sfrelcomitemvalor', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('sfrelcomitemvalorable');
            $table->bigInteger('numSeqPai')->nullable();
            $table->bigInteger('numSeqItem')->nullable();
            $table->integer('codNatDespDet')->nullable();
            $table->decimal('vlr',17,2)->nullable();
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
        Schema::dropIfExists('sfrelcomitemvalor');
    }
}
