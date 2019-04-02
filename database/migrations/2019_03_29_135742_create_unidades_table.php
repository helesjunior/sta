<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo')->unique(); //IT-CO-UNIDADE-GESTORA
            $table->string('cnpj'); //IT-NU-CGC
            $table->string('funcao'); //IT-IN-FUNCAO-UG
            $table->string('nome'); //IT-NO-UNIDADE-GESTORA
            $table->string('uf'); //IT-CO-UF
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
        Schema::dropIfExists('unidades');
    }
}
