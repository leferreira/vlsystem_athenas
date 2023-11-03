<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinRecebimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fin_recebimentos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresa_id')->unsigned();            
            $table->foreign('empresa_id')->references('id')->on('empresas'); 
            
            $table->bigInteger('usuario_id')->unsigned();
            $table->foreign('usuario_id')->references('id')->on('users');
            
            $table->bigInteger('conta_receber_id')->unsigned();
            $table->foreign('conta_receber_id')->references('id')->on('fin_conta_recebers'); 
            
            $table->bigInteger('conta_corrente_id')->nullable()->unsigned();
            $table->foreign('conta_corrente_id')->references('id')->on('conta_correntes'); 
            
            $table->string('descricao_recebimento',60)->nullable();          

            
            $table->BigInteger('status_id')->unsigned()->default(1);
            $table->foreign("status_id")->references("id")->on("statuses");
            
            $table->BigInteger('forma_pagto_id')->unsigned()->nullable();
            $table->foreign("forma_pagto_id")->references("id")->on("forma_pagtos"); 
            
            $table->BigInteger('classificacao_financeira_id')->nullable()->unsigned();
            $table->foreign('classificacao_financeira_id')->references('id')->on('classificacao_financeiras');
            
            $table->date('data_recebimento')->nullable();
            
            $table->integer('tipo_documento')->nullable();
            $table->integer('documento_id')->nullable();
            $table->string('numero_documento',60)->nullable();
            
            $table->integer('documento')->nullable();            
            $table->decimal('valor_original',10,2)->nullable()->default(0);
            $table->decimal('valor_recebido', 10,2)->default(0);
            $table->decimal('juros',10,2)->nullable()->default(0);
            $table->decimal('multa',10,2)->nullable()->default(0);
            $table->string('observacao',90)->nullable();
            $table->decimal('desconto',10,2)->nullable();
            $table->string('origem',40)->nullable();
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
        Schema::dropIfExists('fin_recebimentos');
    }
}
