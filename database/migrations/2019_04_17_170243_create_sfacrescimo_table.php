<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfacrescimoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sfacrescimo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('sfacrescimoable');
            $table->string('tpAcrescimo')->nullable();
            $table->decimal('vlr',17,2)->nullable();
            $table->string('numEmpe')->nullable();
            $table->integer('codSubItemEmpe')->nullable();
            $table->integer('codFontRecur')->nullable();
            $table->string('codCtgoGasto')->nullable();
            $table->string('txtInscrA')->nullable();
            $table->integer('numClassA')->nullable();
            $table->string('txtInscrB')->nullable();
            $table->integer('numClassB')->nullable();
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
        Schema::dropIfExists('sfacrescimo');
    }
}
