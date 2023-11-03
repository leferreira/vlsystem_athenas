<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemPedidoDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_pedido_deliveries', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('pedido_id')->unsigned();
            $table->foreign('pedido_id')->references('id')->on('pedido_deliveries');
            
            $table->BigInteger('produto_id')->unsigned();
            $table->foreign('produto_id')->references('id')->on('produtos');
            
            $table->BigInteger('tamanho_id')->nullable()->unsigned();
            $table->foreign('tamanho_id')->references('id')->on('tamanho_pizzas')->onDelete('cascade');
            
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
            
            $table->string('observacao', 150)->nullable();
            
            
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
        Schema::dropIfExists('item_pedido_deliveries');
    }
}
