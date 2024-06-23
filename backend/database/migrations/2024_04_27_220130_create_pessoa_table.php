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
            $table->increments('pessoa_id');
            $table->string('Nome');
            $table->char('Sexo', 1);
            $table->date('Data_nascimento')->nullable();
            $table->date('Data_casamento')->nullable();
            $table->date('Data_obito')->nullable();
            $table->string('Local_nascimento')->nullable();
            $table->string('Local_sepultamento')->nullable();
            $table->timestamp('Data_criacao')->useCurrent();
            $table->boolean('Colonizador')->default(false);
            $table->integer('Usuario_id');
            $table->text('Resumo')->nullable();
            $table->boolean('Validado')->default(false);
            $table->string('Motivo')->nullable();
            $table->string('Religiao')->nullable();
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
