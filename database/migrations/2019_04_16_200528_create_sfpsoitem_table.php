<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfpsoitemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sfpsoitem', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sfpso_id');
            $table->bigInteger('numSeqItem')->nullable();
            $table->boolean('indrLiquidado')->nullable();
            $table->decimal('vlr',17,2)->nullable();
            $table->integer('codFontRecur')->nullable();
            $table->string('codCtgoGasto')->nullable();
            $table->string('txtInscrA')->nullable();
            $table->integer('numClassA')->nullable();
            $table->string('txtInscrB')->nullable();
            $table->integer('numClassB')->nullable();
            $table->string('txtInscrC')->nullable();
            $table->integer('numClassC')->nullable();
            $table->string('txtInscrD')->nullable();
            $table->integer('numClassD')->nullable();
            $table->timestamps();
        });

        Schema::table('sfpsoitem', function (Blueprint $table) {
            $table->foreign('sfpso_id')->references('id')->on('sfpso')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sfpsoitem');
    }
}
