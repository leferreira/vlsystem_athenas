<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinContaPagarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fin_conta_pagars', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            
            $table->bigInteger('usuario_id')->nullable()->unsigned();
            $table->foreign('usuario_id')->references('id')->on('users');
            
            $table->string('descricao',60)->nullable();
            
            $table->BigInteger('fornecedor_id')->unsigned();
            $table->foreign("fornecedor_id")->references("id")->on("fornecedors");
            
            $table->BigInteger('despesa_id')->nullable()->unsigned();
            $table->foreign("despesa_id")->references("id")->on("fin_despesas");
            
            $table->BigInteger('fatura_id')->nullable()->unsigned();
            $table->foreign("fatura_id")->references("id")->on("fin_faturas");
            
            $table->BigInteger('status_id')->unsigned();
            $table->foreign("status_id")->references("id")->on("statuses");
            
            $table->BigInteger('compra_id')->unsigned()->nullable();
            $table->foreign("compra_id")->references("id")->on("compras");
            
            $table->BigInteger('centro_custo_id')->nullable()->unsigned();
            $table->foreign('centro_custo_id')->references('id')->on('centro_custos');  
            
            $table->BigInteger('nfe_id')->unsigned()->nullable();
            $table->foreign("nfe_id")->references("id")->on("nves");
            
            $table->integer('num_parcela')->nullable();
            $table->integer('ult_parcela')->nullable();
            
            $table->date('data_emissao')->nullable();
            $table->date('data_vencimento');
            $table->string('origem',20)->nullable();
            $table->string('observacao',90)->nullable();
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
        Schema::dropIfExists('fin_conta_pagars');
    }
}
