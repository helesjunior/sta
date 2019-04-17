<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfdocrelacionadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sfdocrelacionado', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sfdadosbasicos_id');
            $table->integer('codUgEmit')->nullable();
            $table->string('numDocRelacionado')->nullable();
            $table->timestamps();
        });
        Schema::table('sfdocrelacionado', function (Blueprint $table) {
            $table->foreign('sfdadosbasicos_id')->references('id')->on('sfdadosbasicos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sfdocrelacionado');
    }
}
