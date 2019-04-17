<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfcentrocustoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sfcentrocusto', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sfpadrao_id');
            $table->bigInteger('numSeqItem');
            $table->string('codCentroCusto');
            $table->integer('mesReferencia');
            $table->integer('anoReferencia');
            $table->integer('codUgBenef');
            $table->integer('codSIORG');
            $table->timestamps();
        });

        Schema::table('sfcentrocusto', function (Blueprint $table) {
            $table->foreign('sfpadrao_id')->references('id')->on('sfpadrao')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sfcentrocusto');
    }
}
