<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCasalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('casal', function (Blueprint $table) {
            $table->increments('Casal_id');
            $table->unsignedInteger('Marido_id');
            $table->unsignedInteger('Esposa_id')->nullable();
            $table->unsignedInteger('Data_casamento')->nullable();
            $table->foreign('Marido_id')->references('Pessoa_id')->on('pessoa');
            $table->foreign('Esposa_id')->references('Pessoa_id')->on('pessoa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('casal');
    }
}
