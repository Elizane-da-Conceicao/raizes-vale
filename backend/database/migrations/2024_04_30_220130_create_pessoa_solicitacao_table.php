<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePessoaSolicitacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pessoa_solicitacao', function (Blueprint $table) {
            $table->increments('Pessoa_id_solicitacao');
            $table->string('Nome', 120)->nullable();
            $table->enum('Sexo', ['M', 'F'])->nullable();
            $table->date('Data_nascimento')->nullable();
            $table->date('Data_casamento')->nullable();
            $table->date('Data_obito')->nullable();
            $table->string('Local_nascimento', 255)->nullable();
            $table->string('Local_sepultamento', 255)->nullable();
            $table->string('Resumo')->nullable();
            $table->enum('Colonizador', ['1', '2'])->default('2');
            $table->enum('Validacao', ['1', '2', '3'])->nullable();
            $table->string('Motivo');
            $table->date('Data_criacao')->nullable();
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
        Schema::dropIfExists('pessoa_solicitacao');
    }
}
