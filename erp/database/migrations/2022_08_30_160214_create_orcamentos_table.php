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
        Schema::create('orcamentos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('venda_id')->nullable()->unsigned();
            $table->foreign('venda_id')->references('id')->on('vendas');
            
            $table->BigInteger('vendedor_id')->nullable()->unsigned();
            $table->foreign('vendedor_id')->references('id')->on('vendedors');
            
            $table->bigInteger('empresa_id')->unsigned();            
            $table->foreign('empresa_id')->references('id')->on('empresas');
            
            $table->BigInteger('cliente_id')->unsigned();
            $table->foreign('cliente_id')->references('id')->on('clientes');
            
            $table->BigInteger('usuario_id')->nullable()->unsigned();
            $table->foreign('usuario_id')->references('id')->on('users');
            
            $table->date("data_orcamento");   
            $table->date("data_atendimento")->nullable();
            
            $table->bigInteger('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses');
            
            
            $table->string('forma_pagamento', 40)->nullable();
            $table->string('tPag', 15)->nullable();
            
            $table->decimal('valor_frete', 10,2)->nullable();
            $table->decimal('total_seguro', 10,2)->default(0)->nullable();
            $table->decimal('despesas_outras', 10,2)->default(0)->nullable();
            $table->decimal('valor_desconto', 10,2)->nullable();
            $table->decimal('valor_liquido', 10,2)->nullable();
            $table->decimal('total_desconto_item', 10,2)->default(0)->nullable();
            $table->decimal('valor_orcamento', 10,2)->nullable();
            $table->decimal('desconto_valor', 10,2)->nullable();
            $table->decimal('desconto_per', 10,2)->nullable();
            $table->integer('qtde_parcela')->nullable();
     
            $table->text('observacao')->nullable();
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
        Schema::dropIfExists('orcamentos');
    }
};
