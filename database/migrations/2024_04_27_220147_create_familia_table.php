<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamiliaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('familia', function (Blueprint $table) {
            $table->increments('Familia_id');
            $table->string('Nome', 255)->nullable();
            $table->dateTime('Data_criacao')->nullable();
            $table->dateTime('Data_alteracao')->nullable();
            $table->text('Resumo')->nullable();
            $table->unsignedInteger('Colonizador')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('familia');
    }
}
