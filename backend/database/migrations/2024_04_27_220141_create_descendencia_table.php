<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDescendenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descendencia', function (Blueprint $table) {
            $table->increments('Descendencia_id');
            $table->unsignedInteger('Filho_id');
            $table->unsignedInteger('Casal_id');
            $table->date('Data_criacao')->nullable();
            $table->foreign('Filho_id')->references('Pessoa_id')->on('pessoa');
            $table->foreign('Casal_id')->references('Casal_id')->on('casal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('descendencia');
    }
}
