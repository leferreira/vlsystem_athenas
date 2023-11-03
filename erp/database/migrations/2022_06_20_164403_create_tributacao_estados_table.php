<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTributacaoEstadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tributacao_estados', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('natureza_operacao_id')->unsigned();
            $table->foreign('natureza_operacao_id')->references('id')->on('natureza_operacaos');
            
            $table->bigInteger('estado_id')->unsigned()->nullable();
            $table->foreign('estado_id')->references('id')->on('estados');
            
            $table->bigInteger('tributacao_id')->unsigned();
            $table->foreign('tributacao_id')->references('id')->on('tributacaos');
            
            $table->bigInteger('tributacao_contribuinte_id')->unsigned();
            $table->foreign('tributacao_contribuinte_id')->references('id')->on('tipo_contribuintes');            
       
            $table->string("cst",10)->nullable();
            $table->string("cfop",10)->nullable();
            $table->decimal("pICMS",10,2)->nullable();
            $table->decimal("pFCP",10,2)->nullable();
            
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
        Schema::dropIfExists('tributacao_estados');
    }
}
