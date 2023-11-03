<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequisicaoPagamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisicao_pagamentos', function (Blueprint $table) {
            $table->id();
            $table->string('identificador', 50);
            $table->tinyInteger('status')->default(0)->comment("0 - Aguardando, 1 - Pago, 2 - Recusado");
            $table->tinyInteger('tipo_pagamento')->comment('1 - Cartão, 2 - Pix');
            $table->string("produto")->nullable();
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
        Schema::dropIfExists('requisicao_pagamentos');
    }
}
