<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemOrdemComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_ordem_compras', function (Blueprint $table) {
            $table->id();
            $table->BigInteger("ordem_compra_id")->unsigned();
            $table->BigInteger("produto_id")->unsigned();
            $table->integer("qtde");
            $table->decimal('valor',10,2);
            $table->decimal('subtotal',10,2);
            
            $table->foreign("ordem_compra_id")->references("id")->on("ordem_compras");
            $table->foreign("produto_id")->references("id")->on("produtos");
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
        Schema::dropIfExists('item_ordem_compras');
    }
}
