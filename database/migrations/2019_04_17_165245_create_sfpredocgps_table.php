<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfpredocgpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sfpredocgps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sfpredoc_id');
            $table->string('codRecurso')->nullable();
            $table->string('txtProcesso')->nullable();
            $table->string('mesCompet')->nullable();
            $table->string('anoCompet')->nullable();
            $table->boolean('indrAdiant13')->nullable();
            $table->timestamps();
        });

        Schema::table('sfpredocgps', function (Blueprint $table) {
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
        Schema::dropIfExists('sfpredocgps');
    }
}
