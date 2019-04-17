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
            $table->integer('codugemit');
            $table->integer('anodh')->nullable();
            $table->char('codtipodh',2)->nullable();
            $table->integer('numdh')->nullable();
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
