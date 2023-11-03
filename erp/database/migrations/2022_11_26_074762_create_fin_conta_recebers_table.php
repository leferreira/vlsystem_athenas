<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinContaRecebersTable extends Migration
{
    public function up()
    {
        Schema::create('fin_conta_recebers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresa_id')->unsigned();            
            $table->foreign('empresa_id')->references('id')->on('empresas');
            
            $table->bigInteger('usuario_id')->nullable()->unsigned();
            $table->foreign('usuario_id')->references('id')->on('users');
            
            $table->string('descricao',60)->nullable();
            
            $table->BigInteger('cliente_id')->unsigned();
            $table->foreign("cliente_id")->references("id")->on("clientes");
            
            $table->BigInteger('status_id')->unsigned();
            $table->foreign("status_id")->references("id")->on("statuses");
            
            $table->BigInteger('venda_id')->unsigned()->nullable();
            $table->foreign("venda_id")->references("id")->on("vendas");
            
            $table->BigInteger('pdvduplicata_id')->unsigned()->nullable();
            $table->foreign("pdvduplicata_id")->references("id")->on("pdv_duplicatas");
            
            $table->BigInteger('loja_pedido_id')->unsigned()->nullable();
            $table->foreign("loja_pedido_id")->references("id")->on("loja_pedidos");
            
            $table->BigInteger('cobranca_id')->unsigned()->nullable();
            $table->foreign("cobranca_id")->references("id")->on("cobrancas");
            
            $table->BigInteger('centro_custo_id')->nullable()->unsigned();
            $table->foreign('centro_custo_id')->references('id')->on('centro_custos');   
            
            $table->BigInteger('forma_pagto_id')->nullable()->unsigned();
            $table->foreign('forma_pagto_id')->references('id')->on('forma_pagtos');
            
            $table->BigInteger('nfe_id')->unsigned()->nullable();
            $table->foreign("nfe_id")->references("id")->on("nves");
            
            $table->integer('num_parcela')->nullable();
            $table->integer('ult_parcela')->nullable();
            
            $table->date('data_emissao')->nullable();
            $table->date('data_previsao')->nullable();            
            $table->date('data_vencimento');     
            $table->string('origem',20)->nullable();
            $table->string('observacao',60)->nullable();
            $table->decimal('valor', 10,2)->default(0);
            
            $table->decimal('total_juros', 10,2)->nullable();
            $table->decimal('total_multa', 10,2)->nullable();
            $table->decimal('total_desconto', 10,2)->nullable();
            $table->decimal('total_liquido', 10,2)->nullable();
            $table->decimal('total_recebido', 10,2)->nullable();
            $table->decimal('total_restante', 10,2)->nullable();
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
        Schema::dropIfExists('fin_conta_recebers');
    }
}
