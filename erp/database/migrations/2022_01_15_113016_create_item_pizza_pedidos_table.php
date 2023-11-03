<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemPizzaPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_pizza_pedidos', function (Blueprint $table) {
            $table->id();
            
            $table->BigInteger('item_pedido')->unsigned();
            $table->foreign('item_pedido')->references('id')->on('item_pedido_deliveries')->onDelete('cascade');
            
            $table->BigInteger('sabor_id')->unsigned();
            $table->foreign('sabor_id')->references('id')->on('produtos')->onDelete('cascade');          
            
            
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
        Schema::dropIfExists('item_pizza_pedidos');
    }
}
