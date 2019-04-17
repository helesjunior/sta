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
            $table->bigInteger('numSeqItem')->nullable();
            $table->string('codRecolhedor')->nullable();
            $table->decimal('vlr',17,2)->nullable();
            $table->decimal('vlrBaseCalculo',17,2)->nullable();
            $table->decimal('vlrMulta',17,2)->nullable();
            $table->decimal('vlrJuros',17,2)->nullable();
            $table->decimal('vlrOutrasEnt',17,2)->nullable();
            $table->decimal('vlrAtmMultaJuros',17,2)->nullable();
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
