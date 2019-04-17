<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfpsoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sfpso', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sfpadrao_id');
            $table->bigInteger('numSeqItem')->nullable();
            $table->string('CodSit')->nullable();
            $table->string('txtInscrE')->nullable();
            $table->integer('numClassE')->nullable();
            $table->string('txtInscrF')->nullable();
            $table->integer('numClassF')->nullable();
            $table->timestamps();
        });

        Schema::table('sfpso', function (Blueprint $table) {
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
        Schema::dropIfExists('sfpso');
    }
}
