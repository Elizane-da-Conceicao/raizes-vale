<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamiliaColonizadoraSolicitacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('familia_colonizadora_solicitacao', function (Blueprint $table) {
            $table->increments('Familia_colonizadora_id_solicitacao');
            $table->unsignedInteger('Colonizador_id')->nullable();
            $table->unsignedInteger('Familia_id')->nullable();
            $table->unsignedInteger('Colonizador_id_solicitacao')->nullable();
            $table->unsignedInteger('Familia_id_solicitacao')->nullable();
            $table->date('Data_chegada')->nullable();
            $table->string('Comentarios')->nullable();
            $table->string('Motivo');
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
        Schema::dropIfExists('familia_colonizadora_solicitacao');
    }
}
