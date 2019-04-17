<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfdadosbasicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sfdadosbasicos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sfpadrao_id');
            $table->date('dtEmis')->nullable();
            $table->date('dtVenc')->nullable();
            $table->integer('codUgPgto')->nullable();
            $table->decimal('vlr',17,2)->nullable();
            $table->string('txtObser')->nullable();
            $table->string('txtInfoAdic')->nullable();
            $table->decimal('vlrTaxaCambio',17,2)->nullable();
            $table->string('txtProcesso')->nullable();
            $table->date('dtAteste')->nullable();
            $table->string('codCredorDevedor');
            $table->date('dtPgtoReceb')->nullable();
            $table->timestamps();
        });

        Schema::table('sfdadosbasicos', function (Blueprint $table) {
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
        Schema::dropIfExists('sfdadosbasicos');
    }
}
