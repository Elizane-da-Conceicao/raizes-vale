<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->increments('usuario_id');
            $table->string('Nome', 120);
            $table->string('CPF', 14)->nullable();
            $table->string('Email', 255);
            $table->dateTime('data_criacao')->nullable();
            $table->dateTime('data_alteracao')->nullable();
            $table->enum('administrador', ['1', '2'])->nullable()->default('2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario');
    }
}
