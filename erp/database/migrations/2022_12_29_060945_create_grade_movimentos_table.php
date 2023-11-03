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
        Schema::create('grade_movimentos', function (Blueprint $table) {
            $table->id();
            $table->BigInteger("grade_id")->unsigned()->nullable();
            $table->foreign("grade_id")->references("id")->on("grade_produtos");
            
            $table->bigInteger('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            
            
            $table->BigInteger("tipo_movimento_id")->unsigned();
            $table->foreign("tipo_movimento_id")->references("id")->on("tipo_movimentos");
            
            $table->BigInteger("produto_id")->unsigned();
            $table->foreign("produto_id")->references("id")->on("produtos");
            
            
            $table->BigInteger("compra_id")->unsigned()->nullable();
            $table->foreign("compra_id")->references("id")->on("compras");
            
            $table->BigInteger("item_compra_id")->unsigned()->nullable();
            $table->foreign("item_compra_id")->references("id")->on("item_compras");
            
            $table->BigInteger("loja_pedido_id")->unsigned()->nullable();
            $table->foreign("loja_pedido_id")->references("id")->on("loja_pedidos");
            
            $table->BigInteger("item_loja_pedido_id")->unsigned()->nullable();
            $table->foreign("item_loja_pedido_id")->references("id")->on("loja_item_pedidos");
            
            $table->BigInteger("entrada_avulsa_id")->unsigned()->nullable();
            $table->foreign("entrada_avulsa_id")->references("id")->on("entradas");
            
            $table->BigInteger("saida_avulsa_id")->unsigned()->nullable();
            $table->foreign("saida_avulsa_id")->references("id")->on("saidas");
            
            $table->BigInteger("venda_id")->unsigned()->nullable();
            $table->foreign("venda_id")->references("id")->on("vendas");
            
            $table->BigInteger("item_venda_id")->unsigned()->nullable();
            $table->foreign("item_venda_id")->references("id")->on("item_vendas");
            
            $table->BigInteger("pdvvenda_id")->unsigned()->nullable();
            $table->foreign("pdvvenda_id")->references("id")->on("pdv_vendas");
            
            $table->BigInteger("item_pdvvenda_id")->unsigned()->nullable();
            $table->foreign("item_pdvvenda_id")->references("id")->on("pdv_item_vendas");
            
            $table->BigInteger("nfe_id")->unsigned()->nullable();
            $table->foreign("nfe_id")->references("id")->on("nves");
            
            $table->BigInteger("item_nfe_id")->unsigned()->nullable();
            $table->foreign("item_nfe_id")->references("id")->on("nfe_items");
            
            
            $table->string("ent_sai",1);
            $table->string("efetivado",1)->nullable();
            $table->string("estorno",1)->default("N");
            $table->date("data_movimento");
            $table->decimal("qtde_movimento", 10,2);
            $table->string("descricao");
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
        Schema::dropIfExists('grade_movimentos');
    }
};
