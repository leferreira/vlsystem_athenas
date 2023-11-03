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
        Schema::create('item_venda_recorrentes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('venda_recorrente_id')->unsigned();
            $table->foreign('venda_recorrente_id')->references('id')->on('venda_recorrentes');
            
            $table->bigInteger('produto_recorrente_id')->unsigned();
            $table->foreign('produto_recorrente_id')->references('id')->on('produto_recorrentes');
            
            $table->decimal('quantidade', 10,3);
            $table->decimal('valor', 10,2);
            $table->decimal('subtotal', 10,2);
            $table->decimal('subtotal_liquido', 10,2);
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
        Schema::dropIfExists('item_venda_recorrentes');
    }
};
