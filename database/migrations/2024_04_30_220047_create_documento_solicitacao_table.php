<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentoSolicitacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documento_solicitacao', function (Blueprint $table) {
            $table->increments('documento_id_solicitacao');
            $table->unsignedBigInteger('pessoa_id')->nullable();
            $table->unsignedBigInteger('pessoa_id_solicitacao')->nullable();
            $table->string('Descricao');
            $table->string('Caminho');
            $table->string('Motivo');
            $table->string('Tipo_arquivo');
            $table->timestamp('Data_criacao')->nullable();
            $table->timestamp('Data_alteracao')->nullable();
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
        Schema::dropIfExists('documento_solicitacao');
    }
}
