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
        Schema::create('duplicatas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('venda_id')->unsigned()->nullable();
            $table->foreign('venda_id')->references('id')->on('vendas');
            
            $table->bigInteger('orcamento_id')->unsigned()->nullable();
            $table->foreign('orcamento_id')->references('id')->on('orcamentos');
            
            $table->string('tPag',5)->nullable();
            $table->string('indPag',1)->nullable();
            $table->string('nDup',50);
            $table->date('dVenc');
            $table->decimal('vDup',10,2)->nullable();
            $table->string('obs',80)->nullable();
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
        Schema::dropIfExists('duplicatas');
    }
};
