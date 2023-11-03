<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresa_id')->unsigned();
            
            $table->foreign('empresa_id')->references('id')->on('empresas');
            
            $table->BigInteger('fornecedor_id')->unsigned();
            $table->foreign('fornecedor_id')->references('id')->on('fornecedors');
            
            $table->BigInteger('transportadora_id')->nullable()->unsigned();
            $table->foreign('transportadora_id')->references('id')->on('transportadoras');
            
            $table->BigInteger('centro_custo_id')->nullable()->unsigned();
            $table->foreign('centro_custo_id')->references('id')->on('centro_custos');
            
            $table->BigInteger('usuario_id')->unsigned();
            $table->foreign('usuario_id')->references('id')->on('users');
            
            $table->BigInteger('classificacao_financeira_id')->nullable()->unsigned();
            $table->foreign('classificacao_financeira_id')->references('id')->on('classificacao_financeiras');
            
            $table->bigInteger('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses');
            
            $table->bigInteger('status_financeiro_id')->nullable()->unsigned();
            $table->foreign('status_financeiro_id')->references('id')->on('statuses');
            
            $table->date("data_compra");
            
            $table->string('enviou_estoque', 1)->nullable()->default('N');
            $table->string('enviou_nfe', 1)->nullable()->default('N');
            $table->string('enviou_financeiro', 1)->nullable()->default('N');
            
            $table->string('xml_path', 48)->nullable();
            $table->string('chave', 44)->nullable();
            $table->string('nf', 20)->nullable();
            $table->integer('numero_emissao')->nullable();
            $table->string('estado', 10)->nullable();
            
            
            
            $table->decimal('valor_total', 10,2)->nullable(); 
            $table->decimal('valor_frete', 10,2)->nullable();
            $table->decimal('valor_imposto', 10,2)->nullable();
            $table->decimal('valor_desconto', 10,2)->nullable();
            $table->decimal('taxa_desconto', 10,2)->nullable();
            $table->decimal('valor_compra', 10,2)->nullable();
            $table->integer('qtde_parcela')->nullable()->deafult();
            
            
            $table->decimal('total_seguro', 10,2)->nullable();
            $table->decimal('despesas_outras', 10,2)->nullable();
            $table->decimal('desconto_valor', 10,2)->nullable();
            $table->decimal('desconto_per', 10,2)->nullable();
            $table->decimal('total_desconto_item', 10,2)->nullable();
            
            $table->date("primeiro_vencimento")->nullable();
            $table->text('observacao')->nullable();
            $table->text('observacao_interna')->nullable();
            
            $table->integer('dfe_id')->nullable()->deafult(0);
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
        Schema::dropIfExists('compras');
    }
}
