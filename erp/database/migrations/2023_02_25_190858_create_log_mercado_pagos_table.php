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
        Schema::create('log_mercado_pagos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            
            $table->BigInteger('loja_pedido_id')->unsigned()->nullable();
            $table->foreign("loja_pedido_id")->references("id")->on("loja_pedidos");
            
            $table->BigInteger('pdv_venda_id')->unsigned()->nullable();
            $table->foreign("pdv_venda_id")->references("id")->on("pdv_vendas");
            
            $table->BigInteger('cobranca_id')->unsigned()->nullable();
            $table->foreign("cobranca_id")->references("id")->on("cobrancas");
            
            $table->BigInteger('fatura_id')->unsigned()->nullable();
            $table->foreign("fatura_id")->references("id")->on("fin_faturas");           
           
            $table->bigInteger('cliente_id')->nullable()->unsigned();
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->string("transacao", 80)->nullable();
            $table->string("forma_pagto", 80)->nullable();
            $table->text("link_boleto")->nullable();
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
        Schema::dropIfExists('log_mercado_pagos');
    }
};
