<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfdomiciliobancarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sfdomiciliobancario', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->nullableMorphs('numdomibancfavoable');
            $table->nullableMorphs('numdomibancpgtoable');
            $table->integer('banco')->nullable();
            $table->integer('agencia')->nullable();
            $table->string('conta')->nullable();
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
        Schema::dropIfExists('sfdomiciliobancario');
    }
}
