<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanointernoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planointerno', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo')->unique(); //IT-CO-PLANO-INTERNO
            $table->string('descricao'); //IT-NO-PLANO-INTERNO
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
        Schema::dropIfExists('planointerno');
    }
}
