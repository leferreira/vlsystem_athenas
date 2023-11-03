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
        Schema::create('mercado_pago_transacaos', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('empresa_id')->nullable()->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            
            $table->bigInteger('cobranca_id')->nullable()->unsigned();
            $table->foreign('cobranca_id')->references('id')->on('cobrancas');
            
            $table->bigInteger('fatura_id')->nullable()->unsigned();
            $table->foreign('fatura_id')->references('id')->on('fin_faturas');
            
            $table->bigInteger('loja_pedido_id')->nullable()->unsigned();
            $table->foreign('loja_pedido_id')->references('id')->on('loja_pedidos');
            
            $table->bigInteger('pdv_venda_id')->nullable()->unsigned();
            $table->foreign('pdv_venda_id')->references('id')->on('pdv_vendas');
            
            $table->string("transacao_id", 50)->nullable();
            $table->string("status", 50)->nullable();
            $table->string("descricao", 50)->nullable();
            $table->string("data_criacao", 50)->nullable();
            $table->string("data_ultima_modificacao", 50)->nullable();
            $table->string("data_expiracao", 50)->nullable();
            $table->string("data_aprovacao", 50)->nullable();
            $table->decimal("valor", 10,2)->nullable();
            $table->string("metodo_pagamento", 50)->nullable();
            $table->string("referencia_externa", 50)->nullable();            
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
        Schema::dropIfExists('mercado_pago_transacaos');
    }
};
