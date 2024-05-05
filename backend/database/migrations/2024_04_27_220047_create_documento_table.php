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
            $table->unsignedBigInteger('pessoa_id');
            $table->string('Descricao');
            $table->string('Caminho');
            $table->string('Tipo_arquivo');
            $table->timestamp('Data_criacao')->nullable();
            $table->timestamp('Data_alteracao')->nullable();
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
