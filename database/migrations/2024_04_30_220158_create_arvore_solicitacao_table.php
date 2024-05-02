<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArvoreSolicitacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arvore_solicitacao', function (Blueprint $table) {
            $table->increments('arvore_id_solicitacao');
            $table->unsignedInteger('Descendencia_id')->nullable();
            $table->unsignedInteger('Familia_id')->nullable();
            $table->unsignedInteger('Descendencia_id_solicitacao')->nullable();
            $table->unsignedInteger('Familia_id_solicitacao')->nullable();
            $table->dateTime('Data_criacao')->nullable();
            $table->dateTime('Data_alteracao')->nullable();
            $table->enum('Validacao', ['1', '2', '3'])->nullable();
            $table->string('Motivo');
            $table->foreign('Descendencia_id')->references('Descendencia_id')->on('descendencia');
            $table->foreign('Familia_id')->references('Familia_id')->on('familia');
            $table->foreign('Descendencia_id_solicitacao')->references('Descendencia_id_solicitacao')->on('descendencia_solicitacao');
            $table->foreign('Familia_id_solicitacao')->references('Familia_id_solicitacao')->on('familia_solicitacao');
            $table->unsignedBigInteger('usuario_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arvore_solicitacao');
    }
}
