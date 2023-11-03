<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemPedidoClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_pedido_clientes', function (Blueprint $table) {
            $table->id();
            $table->BigInteger("produto_id")->unsigned();
            $table->BigInteger("pedido_id")->unsigned();        
            
            $table->integer('qtde');
            $table->decimal('valor',10,2);
            $table->decimal('subtotal',10,2);
            
            $table->foreign("produto_id")->references("id")->on("produtos");
            $table->foreign("pedido_id")->references("id")->on("pedido_clientes");
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
        Schema::dropIfExists('item_pedido_clientes');
    }
}
