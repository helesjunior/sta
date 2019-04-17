<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfpredocdarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sfpredocdar', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sfpredoc_id');
            $table->string('codRecurso')->nullable();
            $table->string('mesReferencia')->nullable();
            $table->string('anoReferencia')->nullable();
            $table->integer('codUgTmdrServ')->nullable();
            $table->integer('numNf')->nullable();
            $table->string('txtSerieNf')->nullable();
            $table->integer('numSubSerieNf')->nullable();
            $table->integer('codMuniNf')->nullable();
            $table->date('dtEmisNf')->nullable();
            $table->decimal('vlrNf',17,2)->nullable();
            $table->decimal('numAliqNf',17,2)->nullable();
            $table->timestamps();
        });

        Schema::table('sfpredocdar', function (Blueprint $table) {
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
        Schema::dropIfExists('sfpredocdar');
    }
}
