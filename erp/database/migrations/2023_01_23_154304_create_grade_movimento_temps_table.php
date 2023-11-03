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
        Schema::create('grade_movimento_temps', function (Blueprint $table) {
            $table->id();
            $table->BigInteger("grade_id")->unsigned()->nullable();
            $table->foreign("grade_id")->references("id")->on("grade_produtos");
            
            $table->bigInteger('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            
            
            $table->BigInteger("tipo_movimento_id")->unsigned();
            $table->foreign("tipo_movimento_id")->references("id")->on("tipo_movimentos");
            
            $table->BigInteger("produto_id")->unsigned();
            $table->foreign("produto_id")->references("id")->on("produtos");
            
            
            $table->BigInteger("orcamento_id")->unsigned()->nullable();
            $table->foreign("orcamento_id")->references("id")->on("orcamentos");
            
            $table->BigInteger("item_orcamento_id")->unsigned()->nullable();
            $table->foreign("item_orcamento_id")->references("id")->on("item_orcamentos");            
            
            $table->BigInteger("pedido_cliente_id")->unsigned()->nullable();
            $table->foreign("pedido_cliente_id")->references("id")->on("pedido_clientes");
            
            $table->BigInteger("item_pedido_cliente_id")->unsigned()->nullable();
            $table->foreign("item_pedido_cliente_id")->references("id")->on("item_pedido_clientes");
            
            $table->BigInteger("loja_pedido_id")->unsigned()->nullable();
            $table->foreign("loja_pedido_id")->references("id")->on("loja_pedidos");
            
            $table->BigInteger("item_loja_pedido_id")->unsigned()->nullable();
            $table->foreign("item_loja_pedido_id")->references("id")->on("loja_item_pedidos");          
                       
            
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
        Schema::dropIfExists('grade_movimento_temps');
    }
};
