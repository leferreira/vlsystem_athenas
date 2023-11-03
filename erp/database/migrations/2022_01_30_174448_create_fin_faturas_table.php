<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinFaturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fin_faturas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            
            $table->bigInteger('assinatura_id')->unsigned();
            $table->foreign('assinatura_id')->references('id')->on('assinaturas');
            
            $table->string('descricao',80)->nullable();
            $table->string('observacao',80)->nullable();            
            
            
            $table->BigInteger('status_id')->unsigned()->nullable();
            $table->foreign("status_id")->references("id")->on("statuses");            
            
            $table->bigInteger('recebimento_id')->nullable()->unsigned();
            $table->foreign('recebimento_id')->references('id')->on('gestao_recebimentos');
            
            $table->integer("num_fatura")->nullable();
            $table->date('data_emissao')->nullable();
            $table->date('data_pagamento')->nullable();
            $table->date('data_cancelamento')->nullable();
            $table->date('data_vencimento');
            $table->decimal('valor',10,2)->nullable()->default(0);
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
        Schema::dropIfExists('fin_faturas');
    }
}
