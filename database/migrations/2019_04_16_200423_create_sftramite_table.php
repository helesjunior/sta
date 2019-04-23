<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSftramiteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sftramite', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sfdadosbasicos_id');
            $table->string('txtLocal')->nullable();
            $table->date('dtEntrada')->nullable();
            $table->date('DtSaida')->nullable();
            $table->timestamps();
        });
        Schema::table('sftramite', function (Blueprint $table) {
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
        Schema::dropIfExists('sftramite');
    }
}
