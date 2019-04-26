<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSfpredocgruTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sfpredocgru', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sfpredoc_id');
            $table->string('codRecurso')->nullable();
            $table->string('numCodBarras')->nullable();
            $table->integer('codUgFavorecida')->nullable();
            $table->string('codRecolhedor')->nullable();
            $table->bigInteger('numReferencia')->nullable();
            $table->integer('mesCompet')->nullable();
            $table->integer('anoCompet')->nullable();
            $table->string('txtProcesso')->nullable();
            $table->decimal('vlrDocumento',17,2)->nullable();
            $table->decimal('vlrDesconto',17,2)->nullable();
            $table->decimal('vlrOutrDeduc',17,2)->nullable();
            $table->integer('codRecolhimento')->nullable();
            $table->timestamps();
        });

        Schema::table('sfpredocgru', function (Blueprint $table) {
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
        Schema::dropIfExists('sfpredocgru');
    }
}
