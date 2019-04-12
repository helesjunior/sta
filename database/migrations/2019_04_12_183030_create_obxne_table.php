<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObxneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obxne', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ordembancaria_id');
            $table->string('numeroempenho');
            $table->timestamps();
        });

        Schema::table('obxne', function (Blueprint $table) {
            $table->foreign('ordembancaria_id')->references('id')->on('ordembancaria')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('obxne');
    }
}
