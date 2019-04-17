<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfpredocpfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sfpredocpf', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sfpredoc_id');
            $table->integer('codUGFavorecida')->nullable();
            $table->integer('vinculacaoPgto')->nullable();
            $table->string('txtInscrA')->nullable();
            $table->integer('numClassA')->nullable();
            $table->string('txtInscrB')->nullable();
            $table->integer('numClassB')->nullable();
            $table->string('txtInscrC')->nullable();
            $table->string('txtInscrD')->nullable();
            $table->timestamps();
        });

        Schema::table('sfpredocpf', function (Blueprint $table) {
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
        Schema::dropIfExists('sfpredocpf');
    }
}
