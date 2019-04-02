<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpenhosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empenhos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ug');
            $table->string('gestao');
            $table->string('numero');
            $table->string('numero_ref');
            $table->date('emissao');
            $table->string('tipofavorecido');
            $table->string('favorecido');
            $table->string('observacao');
            $table->string('fonte');
            $table->string('naturezadespesa');
            $table->string('planointerno');
            $table->string('num_lista');
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
        Schema::dropIfExists('empenhos');
    }
}
