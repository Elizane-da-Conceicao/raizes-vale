<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePessoaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pessoa', function (Blueprint $table) {
            $table->increments('Pessoa_id');
            $table->string('Nome', 120)->nullable();
            $table->enum('Sexo', ['M', 'F'])->nullable();
            $table->date('Data_nascimento')->nullable();
            $table->date('Data_casamento')->nullable();
            $table->date('Data_obito')->nullable();
            $table->string('Local_nascimento', 255)->nullable();
            $table->string('Local_sepultamento', 255)->nullable();
            $table->unsignedInteger('Resumo')->nullable();
            $table->enum('Validacao', ['1', '2'])->nullable();
            $table->enum('Colonizador', ['1', '2'])->default('2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pessoa');
    }
}
