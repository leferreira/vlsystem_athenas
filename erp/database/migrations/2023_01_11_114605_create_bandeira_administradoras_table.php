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
        Schema::create('bandeira_administradoras', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('administradora_cartao_id')->unsigned();
            $table->foreign('administradora_cartao_id')->references('id')->on('administradora_cartaos');
            
            $table->bigInteger('bandeira_id')->unsigned();
            $table->foreign('bandeira_id')->references('id')->on('bandeiras');
            
            $table->string("descricao", 100);
            
            $table->bigInteger('tipo_parcelamento_id')->unsigned();
            $table->foreign('tipo_parcelamento_id')->references('id')->on('tipo_parcelamentos');            
           
            $table->bigInteger('forma_pagto_id')->unsigned();
            $table->foreign('forma_pagto_id')->references('id')->on('forma_pagtos');
            
            
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
        Schema::dropIfExists('bandeira_administradoras');
    }
};
