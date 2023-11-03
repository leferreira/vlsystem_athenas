<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresa_id')->unsigned();
            
            $table->foreign('empresa_id')->references('id')->on('empresas');
            
            $table->BigInteger('tabela_preco_id')->nullable()->unsigned();
            $table->foreign('tabela_preco_id')->references('id')->on('tabela_precos');
            
            $table->BigInteger('cliente_id')->unsigned();
            $table->foreign('cliente_id')->references('id')->on('clientes');
            
            $table->BigInteger('vendedor_id')->nullable()->unsigned();
            $table->foreign('vendedor_id')->references('id')->on('vendedors');
            
            $table->BigInteger('frete_id')->nullable()->unsigned();
            $table->foreign('frete_id')->references('id')->on('fretes');
            
            $table->BigInteger('transportadora_id')->nullable()->unsigned();
            $table->foreign('transportadora_id')->references('id')->on('transportadoras');
            
            $table->BigInteger('centro_custo_id')->nullable()->unsigned();
            $table->foreign('centro_custo_id')->references('id')->on('centro_custos');
            
            $table->BigInteger('usuario_id')->nullable()->unsigned();
            $table->foreign('usuario_id')->references('id')->on('users');
            
            
            $table->BigInteger('classificacao_financeira_id')->nullable()->unsigned();
            $table->foreign('classificacao_financeira_id')->references('id')->on('classificacao_financeiras');
            
            $table->date("data_venda");
            
            $table->string('enviou_estoque', 1)->default('N');
            $table->string('enviou_nfe', 1)->default('N');
            $table->string('enviou_financeiro', 1)->default('N');
            
            $table->string('xml_path', 48)->nullable();
            $table->string('chave', 44)->nullable();
            $table->BigInteger('nfe_id')->nullable();
            $table->integer('numero_emissao')->nullable();
            
            $table->bigInteger('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses');
            
            $table->bigInteger('status_financeiro_id')->unsigned();
            $table->foreign('status_financeiro_id')->references('id')->on('statuses');
            
            $table->string('estornou_estoque', 1)->nullable();
            $table->string('forma_pagamento', 40)->nullable();
            $table->string('tPag', 15)->nullable();            
            $table->decimal('valor_total', 10,2)->nullable();
            $table->decimal('valor_frete', 10,2)->nullable();
            $table->decimal('valor_imposto', 10,2)->nullable();
            $table->decimal('total_seguro', 10,2)->default(0)->nullable();
            
            $table->decimal('despesas_outras', 10,2)->default(0)->nullable();
            $table->decimal('desconto_valor', 10,2)->nullable();
            $table->decimal('desconto_per', 10,2)->nullable();
            $table->decimal('valor_desconto', 10,2)->nullable();
            $table->decimal('total_desconto_item', 10,2)->default(0)->nullable();            
            $table->decimal('valor_venda', 10,2)->nullable();
            $table->decimal('valor_liquido', 10,2)->nullable();
            
            
            $table->integer('qtde_parcela')->deafult(1)->nullable();
            $table->date("primeiro_vencimento")->nullable();
            $table->text('observacao')->nullable();
            $table->text('observacao_interna')->nullable();
            
            $table->integer('pedido_loja_id')->default(0);
            $table->integer('orcamento_id')->nullable()->default(0);
            
            $table->string('bandeira_cartao', 2)->nullable();
            $table->string('cnpj_cartao', 18)->nullable();
            $table->string('cAut_cartao', 20)->nullable();
            $table->string('descricao_pag_outros', 80)->nullable();
            
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
        Schema::dropIfExists('vendas');
    }
}
