<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePdvPagamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pdv_pagamentos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('venda_id')->unsigned();
            $table->foreign('venda_id')->references('id')->on('pdv_vendas');
            
            $table->bigInteger('caixa_id')->unsigned();
            $table->foreign('caixa_id')->references('id')->on('pdv_caixas');
            
            $table->BigInteger('forma_pagto_id')->unsigned()->nullable();
            $table->foreign("forma_pagto_id")->references("id")->on("forma_pagtos");
            
            $table->integer('num_parcela');
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
        Schema::dropIfExists('pdv_pagamentos');
    }
}
