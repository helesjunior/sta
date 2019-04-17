<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfparcelaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sfparcela', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sfcronbaixapatrimonial_id');
            $table->bigInteger('numParcela')->nullable();
            $table->date('dtPrevista')->nullable();
            $table->decimal('vlr',17,2)->nullable();
            $table->timestamps();
        });

        Schema::table('sfparcela', function (Blueprint $table) {
            $table->foreign('sfcronbaixapatrimonial_id')->references('id')->on('sfcronbaixapatrimonial')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sfparcela');
    }
}
