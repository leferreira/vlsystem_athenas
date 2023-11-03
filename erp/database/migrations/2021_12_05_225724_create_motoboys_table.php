<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMotoboysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('motoboys', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 60)->nullable();
            $table->string('telefone1', 15)->nullable();
            $table->string('telefone2', 15)->nullable();
            $table->string('telefone3', 15)->nullable();
            $table->string('cpf', 15)->nullable();
            $table->string('rg', 15)->nullable();
            $table->string('endereco', 60)->nullable();
            $table->string('tipo_transporte', 30)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('motoboys');
    }
}
