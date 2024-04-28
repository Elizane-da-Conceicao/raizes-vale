<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamiliaColonizadoraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('familia_colonizadora', function (Blueprint $table) {
            $table->unsignedInteger('Colonizador_id');
            $table->unsignedInteger('Familia_id');
            $table->date('Data_chegada')->nullable();
            $table->string('Comentarios')->nullable();
            $table->primary(['Colonizador_id', 'Familia_id']);
            $table->foreign('Colonizador_id')->references('Pessoa_id')->on('pessoa');
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
        Schema::dropIfExists('familia_colonizadora');
    }
}
