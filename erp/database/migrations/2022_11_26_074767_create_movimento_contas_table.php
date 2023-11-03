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
        Schema::create('movimento_contas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("conta_id")->unsigned();
            $table->foreign("conta_id")->references("id")->on("conta_correntes");
            
            $table->bigInteger('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            
            $table->bigInteger('sangria_id')->nullable()->unsigned();
            $table->foreign('sangria_id')->references('id')->on('pdv_sangrias');
            
            $table->bigInteger('fatura_id')->nullable()->unsigned();
            $table->foreign('fatura_id')->references('id')->on('fin_faturas');
            
            $table->bigInteger('despesa_id')->nullable()->unsigned();
            $table->foreign('despesa_id')->references('id')->on('fin_despesas');
            
            $table->bigInteger('recebimento_id')->nullable()->unsigned();
            $table->foreign('recebimento_id')->references('id')->on('fin_recebimentos');
            
            $table->bigInteger('pagamento_id')->nullable()->unsigned();
            $table->foreign('pagamento_id')->references('id')->on('fin_pagamentos');
            
            $table->bigInteger('classificacao_financeira_id')->nullable()->unsigned();
            $table->foreign('classificacao_financeira_id')->references('id')->on('classificacao_financeiras');
            
            $table->BigInteger('usuario_id')->nullable()->unsigned();
            $table->foreign('usuario_id')->references('id')->on('users');
            
            $table->string("documento", 150)->nullable();
            $table->string("origem", 100)->nullable();
            $table->date("data_emissao")->nullable();
            $table->date("data_compensacao")->nullable();
            $table->string("tipo_movimento")->nullable();//D-Débito / C- Crédito
            $table->string("historico", 250)->nullable();
            $table->decimal("valor",10,2);
            
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
        Schema::dropIfExists('movimento_contas');
    }
};
