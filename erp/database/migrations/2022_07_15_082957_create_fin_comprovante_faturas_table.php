<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinComprovanteFaturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fin_comprovante_faturas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');      
            
            $table->bigInteger('planopreco_id')->unsigned()->nullable();
            $table->foreign('planopreco_id')->references('id')->on('plano_precos'); 
            
            $table->BigInteger('fatura_id')->unsigned()->nullable();
            $table->foreign("fatura_id")->references("id")->on("fin_faturas");
            
            $table->integer("forma_pagto_id")->nullable();
            $table->integer("classificacao_id")->nullable();
            $table->integer("conta_corrente_id")->nullable();
            
            $table->date('data_emissao')->nullable();
            $table->date('data_pagamento')->nullable();
            $table->string('confirmado',1)->default('N')->nullable();
            $table->decimal("valor_pago", 10,2);
            $table->string('obs',120)->nullable();
            $table->string('descricao',120)->nullable();
            $table->string('nome_arquivo',90)->nullable();
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
        Schema::dropIfExists('fin_comprovante_faturas');
    }
}
