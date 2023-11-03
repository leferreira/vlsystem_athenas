<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNfePagamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nfe_pagamentos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nfe_id')->unsigned();
            $table->foreign('nfe_id')->references('id')->on('nves');
            $table->string('tPag',5)->nullable();
            $table->decimal('vPag',10,2)->nullable();
            $table->decimal('vTroco',10,2)->nullable();
            $table->string('CNPJ',15)->nullable();
            $table->string('tBand',5)->nullable();
            $table->string('cAut',15)->nullable();
            $table->string('tpIntegra',1)->nullable();
            $table->string('indPag',1)->nullable();
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
        Schema::dropIfExists('nfe_pagamentos');
    }
}
