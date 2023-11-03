<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePdvVendasTable extends Migration
{
    
    public function up()
    {
        Schema::create('pdv_vendas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresa_id')->unsigned();            
            $table->foreign('empresa_id')->references('id')->on('empresas');            
            
            
            $table->BigInteger('caixa_id')->nullable()->unsigned();
            $table->foreign('caixa_id')->references('id')->on('pdv_caixas');
            
            $table->BigInteger('usuario_id')->unsigned();
            $table->foreign('usuario_id')->references('id')->on('users');
            
            $table->BigInteger('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses');
            
            $table->BigInteger('vendedor_id')->nullable()->unsigned();
            $table->foreign('vendedor_id')->references('id')->on('vendedors');
            
            $table->BigInteger('venda_balcao_id')->nullable()->unsigned();
            $table->foreign('venda_balcao_id')->references('id')->on('venda_balcaos');
            
            $table->BigInteger('venda_loja_id')->nullable()->unsigned();
            $table->foreign('venda_loja_id')->references('id')->on('loja_pedidos');
            
            $table->BigInteger('orcamento_id')->nullable()->unsigned();
            $table->foreign('orcamento_id')->references('id')->on('orcamentos');
            
            $table->BigInteger('venda_id')->nullable()->unsigned();
            $table->foreign('venda_id')->references('id')->on('vendas');
            
            $table->BigInteger('pedido_cliente_id')->nullable()->unsigned();
            $table->foreign('pedido_cliente_id')->references('id')->on('pedido_clientes');
            
            $table->BigInteger('cliente_id')->nullable()->unsigned();
            $table->foreign('cliente_id')->references('id')->on('clientes');
            
            $table->BigInteger('cliente_consumidor_id')->nullable()->unsigned();
            $table->foreign('cliente_consumidor_id')->references('id')->on('clientes');
            
            $table->BigInteger('os_id')->nullable()->unsigned();
            $table->foreign('os_id')->references('id')->on('ordem_servicos');
            
            $table->BigInteger('classificacao_financeira_id')->nullable()->unsigned();
            $table->foreign('classificacao_financeira_id')->references('id')->on('classificacao_financeiras');
            
            
            $table->BigInteger('cupom_desconto_id')->nullable()->unsigned();
            $table->foreign('cupom_desconto_id')->references('id')->on('cupom_descontos');
            
            $table->string('uuid',100)->nullable();
            
            $table->string('titulo',80)->nullable();
            $table->string('cliente_nome',80)->nullable();
            $table->string('cliente_cpf',20)->nullable();
            $table->string('cliente_cnpj',20)->nullable();
            
            $table->date("data_venda");
            
            $table->string('xml_path', 48)->nullable();
            $table->string('chave', 44)->nullable();
            $table->string('nfce', 20)->nullable();
            $table->integer('numero_emissao')->nullable();
            
            $table->string('estornou_estoque', 1)->default('N')->nullable();
            $table->string('forma_pagamento', 40)->nullable();
            $table->decimal('valor_frete', 10,2)->nullable();
            $table->decimal('valor_venda', 10,2)->nullable();
            $table->decimal('desconto_valor', 10,2)->nullable();
            $table->decimal('desconto_per', 10,2)->nullable();
            $table->decimal('valor_desconto', 10,2)->nullable();
            $table->decimal('valor_desconto_cupom', 10,2)->nullable();
            
            $table->decimal('acrescimo_valor', 10,2)->nullable();
            $table->decimal('acrescimo_per', 10,2)->nullable();
            $table->decimal('valor_acrescimo', 10,2)->nullable();
            
            
            
            $table->decimal('valor_liquido', 10,2)->nullable();
            
            $table->integer('qtde_parcela')->nullable()->default(1);            
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
        Schema::dropIfExists('pdv_vendas');
    }
}
