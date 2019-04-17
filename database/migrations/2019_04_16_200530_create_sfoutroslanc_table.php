<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfoutroslancTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sfoutroslanc', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sfpadrao_id');
            $table->bigInteger('numseqitem')->nullable();
            $table->string('codsit')->nullable();
            $table->boolean('indrliquidado')->nullable();
            $table->decimal('vlr',17,2)->nullable();
            $table->boolean('indrtemcontrato')->nullable();
            $table->string('txtinscra')->nullable();
            $table->integer('numclassa')->nullable();
            $table->string('txtinscrb')->nullable();
            $table->integer('numclassb')->nullable();
            $table->string('txtinscrc')->nullable();
            $table->integer('numclassc')->nullable();
            $table->string('txtinscrd')->nullable();
            $table->integer('numclassd')->nullable();
            $table->string('tpnormalestorno')->nullable();
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
        Schema::dropIfExists('sfoutroslanc');
    }
}
