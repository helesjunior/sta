<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfpredocdarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sfpredocdar', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sfpredoc_id');
            $table->string('codrecurso')->nullable();
            $table->string('mesreferencia')->nullable();
            $table->string('anoreferencia')->nullable();
            $table->integer('codugtmdrserv')->nullable();
            $table->integer('numnf')->nullable();
            $table->string('txtserienf')->nullable();
            $table->integer('numsubserienf')->nullable();
            $table->integer('codmuninf')->nullable();
            $table->date('dtemisnf')->nullable();
            $table->decimal('vlrnf',17,2)->nullable();
            $table->decimal('numaliqnf',17,2)->nullable();
            $table->timestamps();
        });

        Schema::table('sfpredocdar', function (Blueprint $table) {
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
        Schema::dropIfExists('sfpredocdar');
    }
}
