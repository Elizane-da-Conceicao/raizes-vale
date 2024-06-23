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
            $table->integer('Documento_id');
            $table->integer('pessoa_id');
            $table->string('Descricao');
            $table->string('Caminho');
            $table->string('Tipo_arquivo');
            $table->timestamp('Data_criacao')->useCurrent();
            $table->timestamp('Data_alteracao')->nullable();
            $table->integer('Validacao');
            $table->string('Motivo')->nullable();
            $table->integer('usuario_id');
            $table->boolean('privado')->default(false);

            // Chave estrangeira para a tabela documento
            $table->foreign('Documento_id')->references('documento_id')->on('documento');

            // Chave estrangeira para a tabela pessoa
            $table->foreign('pessoa_id')->references('Pessoa_id')->on('pessoa');

            // Índice para a coluna Validacao
            $table->index('Validacao');
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
