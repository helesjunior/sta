<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCredorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credor', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipofornecedor'); //IT-CO-TIPO-CREDOR
            $table->string('cpf_cnpj_idgener')->unique(); //IT-CO-CREDOR
            $table->string('nome'); //IT-NO-CREDOR
            $table->string('uf'); //IT-CO-UF-CREDOR
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
        Schema::dropIfExists('credor');
    }
}
