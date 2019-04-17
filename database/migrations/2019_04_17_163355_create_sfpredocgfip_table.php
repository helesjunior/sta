<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfpredocgfipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sfpredocgfip', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sfpredoc_id');
            $table->string('codRecurso')->nullable();
            $table->string('numCodBarras')->nullable();
            $table->integer('codAgencia')->nullable();
            $table->integer('numIdentGfip')->nullable();
            $table->integer('numIdRecolhimento')->nullable();
            $table->integer('codFpas')->nullable();
            $table->integer('codEntidades')->nullable();
            $table->boolean('indrSimples')->nullable();
            $table->integer('numQtdTrabalhor')->nullable();
            $table->decimal('vlrRmesFgts',17,2)->nullable();
            $table->decimal('vlrRmesCat',17,2)->nullable();
            $table->decimal('vlrMensInss',17,2)->nullable();
            $table->decimal('Vlr13SalrInss',17,2)->nullable();
            $table->decimal('vlrContSegDev',17,2)->nullable();
            $table->decimal('vlrPrevSocial',17,2)->nullable();
            $table->decimal('vlrContSegDesc',17,2)->nullable();
            $table->decimal('vlrDepContSocial',17,2)->nullable();
            $table->decimal('vlrEncargos',17,2)->nullable();
            $table->timestamps();
        });

        Schema::table('sfpredocgfip', function (Blueprint $table) {
            $table->foreign('sfpredoc_id')->references('id')->on('sfpredoc')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sfpredocgfip');
    }
}
