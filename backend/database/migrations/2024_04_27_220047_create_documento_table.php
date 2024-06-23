<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documento', function (Blueprint $table) {
            $table->increments('documento_id');
            $table->integer('pessoa_id');
            $table->string('Descricao');
            $table->string('Caminho');
            $table->string('Tipo_arquivo');
            $table->timestamp('Data_criacao')->useCurrent();
            $table->timestamp('Data_alteracao')->nullable();
            $table->boolean('Validado')->default(false);
            $table->string('Motivo')->nullable();
            $table->integer('Usuario_id');
            $table->boolean('Privado')->default(false);

            // Chave estrangeira para a tabela pessoa
            $table->foreign('pessoa_id')->references('Pessoa_id')->on('pessoa');

            // Índice para a coluna Validado
            $table->index('Validado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documento');
    }
}
