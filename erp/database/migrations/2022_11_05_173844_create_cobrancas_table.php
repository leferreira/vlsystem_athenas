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
        Schema::create('cobrancas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('venda_recorrente_id')->unsigned();
            $table->foreign('venda_recorrente_id')->references('id')->on('venda_recorrentes');          
            
            $table->bigInteger('cliente_id')->unsigned();
            $table->foreign('cliente_id')->references('id')->on('clientes');
            
            $table->bigInteger('status_id')->nullable()->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses');
            
            $table->bigInteger('tipo_cobranca_id')->nullable()->unsigned();
            $table->foreign('tipo_cobranca_id')->references('id')->on('tipo_cobrancas');
            
            
            $table->bigInteger('status_financeiro_id')->nullable()->unsigned();
            $table->foreign('status_financeiro_id')->references('id')->on('statuses');
            
            
            $table->string('uuid',100)->nullable();
            $table->string('obs',100)->nullable();
            $table->string('descricao',100)->nullable();
            $table->decimal('valor', 10,2);
            $table->date("data_cadastro");
            $table->date("data_vencimento");
            $table->date("data_pagamento")->nullable();            
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
        Schema::dropIfExists('cobrancas');
    }
};
