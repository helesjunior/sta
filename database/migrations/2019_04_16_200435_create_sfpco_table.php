<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfpcoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sfpco', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sfpadrao_id');
            $table->bigInteger('numSeqItem')->nullable();
            $table->string('codSit')->nullable();
            $table->integer('codUgEmpe')->nullable();
            $table->boolean('indrTemContrato')->nullable();
            $table->string('txtInscrD')->nullable();
            $table->integer('numClassD')->nullable();
            $table->string('txtInscrE')->nullable();
            $table->integer('numClassE')->nullable();
            $table->timestamps();
        });

        Schema::table('sfpco', function (Blueprint $table) {
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
        Schema::dropIfExists('sfpco');
    }
}
