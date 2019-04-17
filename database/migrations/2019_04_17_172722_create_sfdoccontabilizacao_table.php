<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfdoccontabilizacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sfdoccontabilizacao', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sfpadrao_id');
            $table->integer('anoDocCont');
            $table->string('codTipoDocCont');
            $table->string('numDocCont');
            $table->integer('codUgEmit');
            $table->timestamps();
        });

        Schema::table('sfdoccontabilizacao', function (Blueprint $table) {
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
        Schema::dropIfExists('sfdoccontabilizacao');
    }
}
