<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfpcoitemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sfpcoitem', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sfpco_id');
            $table->bigInteger('numseqitem')->nullable();
            $table->string('numempe')->nullable();
            $table->integer('codsubitemempe')->nullable();
            $table->boolean('indrliquidado')->nullable();
            $table->decimal('vlr',17,2)->nullable();
            $table->string('txtinscra')->nullable();
            $table->integer('numclassa')->nullable();
            $table->string('txtinscrb')->nullable();
            $table->integer('numclassb')->nullable();
            $table->string('txtinscrc')->nullable();
            $table->integer('numclassc')->nullable();
            $table->timestamps();
        });

        Schema::table('sfpcoitem', function (Blueprint $table) {
            $table->foreign('sfpco_id')->references('id')->on('sfpco')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sfpcoitem');
    }
}
