<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfpredocdarfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sfpredocdarf', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sfpredoc_id');
            $table->string('codTipoDARF')->nullable();
            $table->string('codRecurso')->nullable();
            $table->date('dtPrdoApuracao')->nullable();
            $table->string('numRef')->nullable();
            $table->string('txtProcesso')->nullable();
            $table->decimal('vlrRctaBrutaAcum',17,2)->nullable();
            $table->decimal('vlrPercentual',17,2)->nullable();
            $table->string('numCodBarras')->nullable();
            $table->integer('vinculacaoPgto')->nullable();
            $table->timestamps();
        });

        Schema::table('sfpredocdarf', function (Blueprint $table) {
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
        Schema::dropIfExists('sfpredocdarf');
    }
}
