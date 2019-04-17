<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfcompensacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sfcompensacao', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sfpadrao_id');
            $table->bigInteger('numSeqItem')->nullable();
            $table->string('codSit')->nullable();
            $table->decimal('vlr',17,2)->nullable();
            $table->string('txtInscrA')->nullable();
            $table->integer('numClassA')->nullable();
            $table->timestamps();
        });

        Schema::table('sfcompensacao', function (Blueprint $table) {
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
        Schema::dropIfExists('sfcompensacao');
    }
}
