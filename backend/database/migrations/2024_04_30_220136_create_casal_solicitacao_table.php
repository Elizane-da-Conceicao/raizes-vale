<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCasalSolicitacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('casal_solicitacao', function (Blueprint $table) {
            $table->increments('Casal_id_solicitacao');
            $table->unsignedInteger('Marido_id')->nullable();
            $table->unsignedInteger('Esposa_id')->nullable();
            $table->unsignedInteger('Marido_id_solicitacao')->nullable();
            $table->unsignedInteger('Esposa_id_solicitacao')->nullable();
            $table->date('Data_casamento')->nullable();
            $table->string('Motivo');
            $table->foreign('Marido_id')->references('Pessoa_id')->on('pessoa');
            $table->foreign('Esposa_id')->references('Pessoa_id')->on('pessoa');
            $table->foreign('Marido_id_solicitacao')->references('Pessoa_id_solicitacao')->on('pessoa_solicitacao');
            $table->foreign('Esposa_id_solicitacao')->references('Pessoa_id_solicitacao')->on('pessoa_solicitacao');
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
        Schema::dropIfExists('casal_solicitacao');
    }
}
