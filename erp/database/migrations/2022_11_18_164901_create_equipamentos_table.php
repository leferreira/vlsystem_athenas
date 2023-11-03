<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipamentos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cliente_id')->unsigned();
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->string("equipamento",150)->nullable();
            $table->string("num_serie",80)->nullable();
            $table->string("modelo", 80)->nullable();
            $table->string("cor", 45)->nullable();
            $table->text("descricao")->nullable();
            $table->string("tensao", 45)->nullable();
            $table->string("potencia", 45)->nullable();
            $table->string("voltagem", 45)->nullable();
            $table->date("data_fabricacao")->nullable();
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
        Schema::dropIfExists('equipamentos');
    }
};
