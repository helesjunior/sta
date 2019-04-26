<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfrelsemitemvalorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sfrelsemitemvalor', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->nullableMorphs('sfrelsemitemvaloroutroslancable');
            $table->nullableMorphs('sfrelsemitemvaloroutroslancpatrimonialable');
            $table->nullableMorphs('sfrelsemitemvalorencargoable');
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
        Schema::dropIfExists('sfrelsemitemvalor');
    }
}
