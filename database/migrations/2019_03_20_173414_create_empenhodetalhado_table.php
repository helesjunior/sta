<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpenhodetalhadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empenhodetalhado', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ug');
            $table->string('gestao');
            $table->string('numeroli');
            $table->string('numitem');
            $table->string('subitem');
            $table->decimal('quantidade',17,5)->default(0);
            $table->decimal('valorunitario', 17, 2)->default(0);
            $table->decimal('valortotal', 17,2)->default(0);
            $table->string('descricao');
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
        Schema::dropIfExists('empenhodetalhado');
    }
}
