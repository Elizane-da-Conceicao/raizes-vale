<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDescendenciaSolicitacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descendencia_solicitacao', function (Blueprint $table) {
            $table->increments('Descendencia_id_solicitacao');
            $table->unsignedInteger('Filho_id')->nullable();
            $table->unsignedInteger('Casal_id')->nullable();
            $table->unsignedInteger('Filho_id_solicitacao')->nullable();
            $table->unsignedInteger('Casal_id_solicitacao')->nullable();
            $table->date('Data_criacao')->nullable();
            $table->string('Motivo');
            $table->foreign('Filho_id')->references('Pessoa_id')->on('pessoa');
            $table->foreign('Casal_id')->references('Casal_id')->on('casal');
            $table->foreign('Filho_id_solicitacao')->references('Pessoa_id_solicitacao')->on('pessoa_solicitacao');
            $table->foreign('Casal_id_solicitacao')->references('Casal_id_solicitacao')->on('casal_solicitacao');
            $table->enum('Validacao', ['1', '2', '3'])->nullable();
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
        Schema::dropIfExists('descendencia_solicitacao');
    }
}
