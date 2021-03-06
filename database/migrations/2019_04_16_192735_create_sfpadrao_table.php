<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfpadraoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sfpadrao', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('codUgEmit');
            $table->integer('anoDH')->nullable();
            $table->char('codTipoDH',2)->nullable();
            $table->integer('numDH')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sfpadrao');
    }
}
