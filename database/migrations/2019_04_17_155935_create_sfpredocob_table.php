<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfpredocobTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sfpredocob', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sfpredoc_id');
            $table->string('codcredordevedor')->nullable();
            $table->string('codnumlista')->nullable();
            $table->string('txtcit')->nullable();
            $table->integer('codrecogru')->nullable();
            $table->integer('codugragru')->nullable();
            $table->string('numragru')->nullable();
            $table->integer('codrecdarf')->nullable();
            $table->integer('numrefdarf')->nullable();
            $table->integer('codcontrepas')->nullable();
            $table->string('codevntbacen')->nullable();
            $table->integer('codfinalidade')->nullable();
            $table->string('txtctrloriginal')->nullable();
            $table->decimal('vlrtaxacambio')->nullable();
            $table->string('txtprocesso')->nullable();
            $table->integer('coddevolucaospb')->nullable();
            $table->timestamps();
        });

        Schema::table('sfpredocob', function (Blueprint $table) {
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
        Schema::dropIfExists('sfpredocob');
    }
}
