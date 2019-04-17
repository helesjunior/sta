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
            $table->bigInteger('numseqitem')->nullable();
            $table->string('codsit')->nullable();
            $table->integer('codugempe')->nullable();
            $table->boolean('indrtemcontrato')->nullable();
            $table->string('txtinscrd')->nullable();
            $table->integer('numclassd')->nullable();
            $table->string('txttnscre')->nullable();
            $table->integer('numclasse')->nullable();
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
