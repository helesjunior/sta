<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfdocorigemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sfdocorigem', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sfdadosbasicos_id');
            $table->string('codIdentEmit')->nullable();
            $table->date('dtEmis')->nullable();
            $table->string('numDocOrigem')->nullable();
            $table->decimal('vlr',17,2)->nullable();
            $table->timestamps();
        });
        Schema::table('sfdocorigem', function (Blueprint $table) {
            $table->foreign('sfdadosbasicos_id')->references('id')->on('sfdadosbasicos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sfdocorigem');
    }
}
