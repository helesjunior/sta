<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfitemrecolhimentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sfitemrecolhimento', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('sfitemrecolhimentoable');
            $table->bigInteger('numseqitem')->nullable();
            $table->string('codrecolhedor')->nullable();
            $table->decimal('vlr',17,2)->nullable();
            $table->decimal('vlrbasecalculo',17,2)->nullable();
            $table->decimal('vlrmulta',17,2)->nullable();
            $table->decimal('vlrjuros',17,2)->nullable();
            $table->decimal('vlroutrasent',17,2)->nullable();
            $table->decimal('vlratmmultajuros',17,2)->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sfitemrecolhimento');
    }
}
