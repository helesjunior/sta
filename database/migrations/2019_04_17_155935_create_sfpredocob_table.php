<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfpredocobTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sfpredocob', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sfpredoc_id');
            $table->string('codTipoOB')->nullable();
            $table->string('codCredorDevedor')->nullable();
            $table->string('codNumLista')->nullable();
            $table->string('txtCit')->nullable();
            $table->integer('codRecoGru')->nullable();
            $table->integer('codUgRaGru')->nullable();
            $table->string('numRaGru')->nullable();
            $table->integer('codRecDarf')->nullable();
            $table->integer('numRefDarf')->nullable();
            $table->integer('codContRepas')->nullable();
            $table->string('codEvntBacen')->nullable();
            $table->integer('codFinalidade')->nullable();
            $table->string('txtCtrlOriginal')->nullable();
            $table->decimal('vlrTaxaCambio',17,2)->nullable();
            $table->string('txtProcesso')->nullable();
            $table->integer('codDevolucaoSPB')->nullable();
            $table->timestamps();
        });

        Schema::table('sfpredocob', function (Blueprint $table) {
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
        Schema::dropIfExists('sfpredocob');
    }
}
