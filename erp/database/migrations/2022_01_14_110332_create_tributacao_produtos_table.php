<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTributacaoProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tributacao_produtos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('natureza_operacao_id')->unsigned();
            $table->foreign('natureza_operacao_id')->references('id')->on('natureza_operacaos');
            
            $table->bigInteger('produto_id')->unsigned();
            $table->foreign('produto_id')->references('id')->on('produtos');
            
            $table->bigInteger('tributacao_id')->unsigned();
            $table->foreign('tributacao_id')->references('id')->on('tributacaos');
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
        Schema::dropIfExists('tributacao_produtos');
    }
}
