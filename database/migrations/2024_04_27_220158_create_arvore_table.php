<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArvoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arvore', function (Blueprint $table) {
            $table->unsignedInteger('Descendencia_id');
            $table->unsignedInteger('Familia_id');
            $table->dateTime('Data_criacao')->nullable();
            $table->dateTime('Data_alteracao')->nullable();
            // Definindo a chave primária composta
            $table->primary(['Descendencia_id', 'Familia_id']);
            $table->foreign('Descendencia_id')->references('Descendencia_id')->on('descendencia');
            $table->foreign('Familia_id')->references('Familia_id')->on('familia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arvore');
    }
}
