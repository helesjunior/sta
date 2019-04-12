<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdembancariaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordembancaria', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ug');
            $table->string('gestao');
            $table->string('numero');
            $table->date('emissao');
            $table->string('tipofavorecido');
            $table->string('favorecido');
            $table->string('bancodestino');
            $table->string('agenciadestino');
            $table->string('contadestino');
            $table->string('processo');
            $table->string('tipoob');
            $table->string('observacao');
            $table->string('cancelamentoob');
            $table->string('numeroobcancelamento');
            $table->string('valor');
            $table->string('documentoorigem');
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
        Schema::dropIfExists('ordembancaria');
    }
}
