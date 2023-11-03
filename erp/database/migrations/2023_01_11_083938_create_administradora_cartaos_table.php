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
        Schema::create('administradora_cartaos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            
            $table->bigInteger('conta_corrente_id')->nullable()->unsigned();
            $table->foreign('conta_corrente_id')->references('id')->on('conta_correntes');
            
            $table->bigInteger('classificacao_financeira_id')->unsigned();
            $table->foreign('classificacao_financeira_id')->references('id')->on('classificacao_financeiras');
            
            $table->bigInteger('plano_conta_taxa_id')->unsigned();
            $table->foreign('plano_conta_taxa_id')->references('id')->on('classificacao_financeiras');
            
            $table->bigInteger('operadora_cartao_id')->unsigned();
            $table->foreign('operadora_cartao_id')->references('id')->on('operadora_cartaos');
            $table->string("descricao", 100);
            $table->integer('dias_para_recebimento')->nullable();
            $table->integer('parcela_recebe_diferenca')->nullable();            
            
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
        Schema::dropIfExists('administradora_cartaos');
    }
};
