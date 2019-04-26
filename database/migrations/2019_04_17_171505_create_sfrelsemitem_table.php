<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfrelsemitemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sfrelsemitem', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->nullableMorphs('sfrelsemitemcreditoable');
            $table->nullableMorphs('sfrelsemitemencargoable');
            $table->nullableMorphs('sfrelsemitemdeducaoable');
            $table->bigInteger('numSeqItem')->nullable();
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
        Schema::dropIfExists('sfrelsemitem');
    }
}
