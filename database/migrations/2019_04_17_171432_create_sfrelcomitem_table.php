<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfrelcomitemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sfrelcomitem', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->nullableMorphs('sfrelcomitempcoable');
            $table->nullableMorphs('sfrelcomitempsoable');
            $table->bigInteger('numSeqPai')->nullable();
            $table->bigInteger('numSeqItem')->nullable();
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
        Schema::dropIfExists('sfrelcomitem');
    }
}
