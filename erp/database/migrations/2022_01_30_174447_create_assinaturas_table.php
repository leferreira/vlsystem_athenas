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
        Schema::create('assinaturas', function (Blueprint $table) {
            $table->id();
            
            $table->BigInteger('empresa_id')->nullable()->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            
            $table->BigInteger('plano_preco_id')->nullable()->unsigned();
            $table->foreign('plano_preco_id')->references('id')->on('plano_precos');            
            
            $table->BigInteger('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses');
            
            $table->bigInteger("ultima_fatura_paga")->nullable();
            $table->date("data_aquisicao");
            $table->string("eh_teste", 1);            
            $table->string("bloqueado_pelo_gestor", 1)->nullable();
            $table->string("liberado_pelo_gestor", 1)->nullable();
            $table->decimal("valor_contrato",10,2)->nullable();
            $table->date("data_cancelamento")->nullable(); 
            $table->decimal("valor_recorrente",10,2)->nullable();
            $table->integer("dias_bloqueia")->nullable();            
            
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
        Schema::dropIfExists('assinaturas');
    }
};
