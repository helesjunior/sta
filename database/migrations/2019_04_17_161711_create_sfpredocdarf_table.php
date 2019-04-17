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
            $table->string('codtipodarf')->nullable();
            $table->string('codrecurso')->nullable();
            $table->date('dtprdoapuracao')->nullable();
            $table->string('numref')->nullable();
            $table->string('txtprocesso')->nullable();
            $table->decimal('vlrrctabrutaacum',17,2)->nullable();
            $table->decimal('vlrpercentual',17,2)->nullable();
            $table->string('numcodbarras')->nullable();
            $table->integer('vinculacaopgto')->nullable();
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
