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
            $table->bigInteger('numSeqItem')->nullable();
            $table->string('codCentroCusto')->nullable();
            $table->integer('mesReferencia')->nullable();
            $table->integer('anoReferencia')->nullable();
            $table->integer('codUgBenef')->nullable();
            $table->integer('codSIORG')->nullable();
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
