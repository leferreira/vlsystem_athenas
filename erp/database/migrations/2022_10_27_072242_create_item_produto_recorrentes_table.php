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
        Schema::create('item_produto_recorrentes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('produto_recorrente_id')->unsigned();
            $table->foreign('produto_recorrente_id')->references('id')->on('produto_recorrentes');
            
            $table->bigInteger('produto_id')->nullable()->unsigned();
            $table->foreign('produto_id')->references('id')->on('produtos');
            
            $table->bigInteger('servico_id')->nullable()->unsigned();
            $table->foreign('servico_id')->references('id')->on('produtos');
            
            $table->decimal('quantidade', 10,2);
            $table->decimal('valor', 10,2);
            $table->decimal('subtotal', 10,2);
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
        Schema::dropIfExists('item_produto_recorrentes');
    }
};
