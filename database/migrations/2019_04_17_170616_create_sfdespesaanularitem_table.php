<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfdespesaanularitemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sfdespesaanularitem', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sfdespesaanular_id');
            $table->bigInteger('numSeqItem')->nullable();
            $table->string('numEmpe')->nullable();
            $table->integer('codSubItemEmpe')->nullable();
            $table->decimal('vlr',17,2)->nullable();
            $table->string('txtInscrA')->nullable();
            $table->integer('numClassA')->nullable();
            $table->string('txtInscrB')->nullable();
            $table->integer('numClassB')->nullable();
            $table->string('txtInscrC')->nullable();
            $table->integer('numClassC')->nullable();
            $table->timestamps();
        });

        Schema::table('sfdespesaanularitem', function (Blueprint $table) {
            $table->foreign('sfdespesaanular_id')->references('id')->on('sfdespesaanular')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sfdespesaanularitem');
    }
}
