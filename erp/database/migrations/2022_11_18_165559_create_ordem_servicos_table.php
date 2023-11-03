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
        Schema::create('ordem_servicos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            
            $table->bigInteger('cliente_id')->unsigned();
            $table->foreign('cliente_id')->references('id')->on('clientes');
            
            $table->bigInteger('vendedor_id')->nullable()->unsigned();
            $table->foreign('vendedor_id')->references('id')->on('vendedors');
            
            $table->bigInteger('tecnico_id')->nullable()->unsigned();
            $table->foreign('tecnico_id')->references('id')->on('tecnicos');
            
            $table->bigInteger('usuario_id')->nullable()->unsigned();
            $table->foreign('usuario_id')->references('id')->on('users');
            
            $table->bigInteger('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses');
            
            $table->bigInteger('equipamento_id')->nullable()->unsigned();
            $table->foreign('equipamento_id')->references('id')->on('equipamentos');
            
            $table->bigInteger('status_financeiro_id')->unsigned();
            $table->foreign('status_financeiro_id')->references('id')->on('statuses');
            
            $table->bigInteger('garantia_id')->nullable()->unsigned();
            $table->foreign('garantia_id')->references('id')->on('termo_garantias');
            
            $table->BigInteger('classificacao_financeira_id')->nullable()->unsigned();
            $table->foreign('classificacao_financeira_id')->references('id')->on('classificacao_financeiras');
            
            $table->date("data_abertura")->nullable();
            $table->date("previsao_entrega")->nullable();
            $table->date("data_final")->nullable();
            $table->integer("garantia")->nullable();
            $table->text("descricao_produto")->nullable();
            $table->text("defeito")->nullable();
            $table->text("laudo_tecnico")->nullable();
            $table->text("observacoes")->nullable();
            
            $table->decimal("valor_os",10,2)->nullable();
            $table->decimal("valor_total_produto",10,2)->nullable();
            $table->decimal("valor_total_servico",10,2)->nullable();
            $table->decimal('valor_frete', 10,2)->nullable();
            $table->decimal('desconto_valor', 10,2)->nullable();
            $table->decimal('desconto_per', 10,2)->nullable();
            $table->decimal("valor_desconto",10,2)->nullable();
            $table->decimal("valor_liquido",10,2)->nullable();
            $table->decimal("taxa_diversa",10,2)->nullable();
            
            $table->integer('qtde_parcela')->nullable();
            
            
            
            
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
        Schema::dropIfExists('ordem_servicos');
    }
};
