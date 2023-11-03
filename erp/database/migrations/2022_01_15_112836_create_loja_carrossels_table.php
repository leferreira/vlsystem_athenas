<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLojaCarrosselsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loja_carrossels', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresa_id')->unsigned();
            
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->string('titulo', 30);
            $table->string('descricao', 200);
            $table->string('link_acao', 200);
            $table->string('nome_botao', 20);
            $table->string('img', 40);
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
        Schema::dropIfExists('loja_carrossels');
    }
}
