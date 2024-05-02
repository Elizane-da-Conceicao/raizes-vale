<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamiliaSolicitacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('familia_solicitacao', function (Blueprint $table) {
            $table->increments('Familia_id_solicitacao');
            $table->string('Nome', 255)->nullable();
            $table->dateTime('Data_criacao')->nullable();
            $table->dateTime('Data_alteracao')->nullable();
            $table->text('Resumo')->nullable();
            $table->string('Motivo');
            $table->enum('Validacao', ['1', '2', '3'])->nullable();
            $table->unsignedInteger('Colonizador')->nullable();
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
        Schema::dropIfExists('familia_solicitacao');
    }
}
