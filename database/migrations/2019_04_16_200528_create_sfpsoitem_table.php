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
            $table->bigInteger('numseqitem')->nullable();
            $table->boolean('indrliquidado')->nullable();
            $table->decimal('vlr',17,2)->nullable();
            $table->integer('codfontrecur')->nullable();
            $table->string('codctgogasto')->nullable();
            $table->string('txtinscra')->nullable();
            $table->integer('numclassa')->nullable();
            $table->string('txtinscrb')->nullable();
            $table->integer('numclassb')->nullable();
            $table->string('txtinscrc')->nullable();
            $table->integer('numclassc')->nullable();
            $table->string('txtinscrd')->nullable();
            $table->integer('numclassd')->nullable();
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
