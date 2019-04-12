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
            $table->text('observacao');
            $table->string('cancelamentoob');
            $table->string('numeroobcancelamento');
            $table->decimal('valor',17,2);
            $table->string('documentoorigem');
//            $table->string('empenho01')->nullable();
//            $table->string('empenho02')->nullable();
//            $table->string('empenho03')->nullable();
//            $table->string('empenho04')->nullable();
//            $table->string('empenho05')->nullable();
//            $table->string('empenho06')->nullable();
//            $table->string('empenho07')->nullable();
//            $table->string('empenho08')->nullable();
//            $table->string('empenho09')->nullable();
//            $table->string('empenho10')->nullable();
//            $table->string('empenho11')->nullable();
//            $table->string('empenho13')->nullable();
//            $table->string('empenho14')->nullable();
//            $table->string('empenho15')->nullable();
//            $table->string('empenho16')->nullable();
//            $table->string('empenho17')->nullable();
//            $table->string('empenho18')->nullable();
//            $table->string('empenho19')->nullable();
//            $table->string('empenho20')->nullable();
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
