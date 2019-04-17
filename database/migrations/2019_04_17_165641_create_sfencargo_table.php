<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfencargoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sfencargo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sfpadrao_id');
            $table->bigInteger('numSeqItem')->nullable();
            $table->string('codSit')->nullable();
            $table->boolean('indrLiquidado')->nullable();
            $table->date('dtVenc')->nullable();
            $table->date('dtPgtoReceb')->nullable();
            $table->integer('codUgPgto')->nullable();
            $table->decimal('vlr',17,2)->nullable();
            $table->integer('codUgEmpe')->nullable();
            $table->string('numEmpe')->nullable();
            $table->integer('codSubItemEmpe')->nullable();
            $table->string('txtInscrA')->nullable();
            $table->integer('numClassA')->nullable();
            $table->string('txtInscrB')->nullable();
            $table->integer('numClassB')->nullable();
            $table->string('txtInscrC')->nullable();
            $table->integer('numClassC')->nullable();
            $table->timestamps();
        });

        Schema::table('sfencargo', function (Blueprint $table) {
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
        Schema::dropIfExists('sfencargo');
    }
}
