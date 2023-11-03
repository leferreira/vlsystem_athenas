<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdemComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordem_compras', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresa_id')->unsigned();
            
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->BigInteger("status_id")->unsigned();
            $table->BigInteger("fornecedor_id")->unsigned();
            $table->BigInteger("cotacao_id")->unsigned()->nullable();
            $table->date("data_emissao");
            $table->date("data_atendimento")->nullable();
            $table->date("data_aprovacao")->nullable();
            $table->date("prazo_recebimento")->nullable();            
            $table->date("data_finalizacao")->nullable();
            $table->decimal('valor_total',10,2)->default(0);
            $table->string('avulsa',1)->default("N");
            $table->string('finalizada',1)->default("S");
            $table->string('observacao')->nullable();
            $table->BigInteger('usuario_id')->unsigned();
            $table->foreign('usuario_id')->references('id')->on('users');
            
            $table->foreign("status_id")->references("id")->on("statuses");
            $table->foreign("fornecedor_id")->references("id")->on("fornecedors");
            $table->foreign("cotacao_id")->references("id")->on("cotacaos");
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
        Schema::dropIfExists('ordem_compras');
    }
}
