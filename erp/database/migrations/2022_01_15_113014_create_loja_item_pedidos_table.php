<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLojaItemPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loja_item_pedidos', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('pedido_id')->unsigned();
            $table->foreign('pedido_id')->references('id')->on('loja_pedidos');
            
            $table->BigInteger('produto_id')->unsigned();
            $table->foreign('produto_id')->references('id')->on('produtos');
            
            $table->BigInteger('cupom_desconto_id')->nullable()->unsigned();
            $table->foreign('cupom_desconto_id')->references('id')->on('cupom_descontos');
            
            $table->integer('grade_produto_id')->nullable();
            $table->string('unidade', 40)->nullable();
            $table->integer('quantidade');
            $table->decimal('valor', 10,2);
            $table->decimal('subtotal', 10,2);
            $table->decimal('subtotal_liquido', 10,2)->nullable();
            $table->decimal('desconto_percentual', 10,2)->default(0)->nullable();
            $table->decimal('desconto_por_valor', 10,2)->default(0)->nullable();
            $table->decimal('desconto_por_unidade', 10,2)->default(0)->nullable();
            $table->decimal('total_desconto_item', 10,2)->default(0)->nullable();
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
        Schema::dropIfExists('loja_item_pedidos');
    }
}
