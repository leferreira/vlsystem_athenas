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
        Schema::create('venda_balcaos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresa_id')->unsigned();            
            $table->foreign('empresa_id')->references('id')->on('empresas');
            
            $table->BigInteger('cliente_id')->nullable()->unsigned();
            $table->foreign('cliente_id')->references('id')->on('clientes');
            
            $table->BigInteger('vendedor_id')->nullable()->unsigned();
            $table->foreign('vendedor_id')->references('id')->on('vendedors');            
            
            $table->BigInteger('usuario_id')->nullable()->unsigned();
            $table->foreign('usuario_id')->references('id')->on('users');         
            
            $table->bigInteger('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses');  
            
            $table->date("data_venda"); 
            $table->decimal('valor_liquido', 10,2)->nullable();
            $table->decimal('valor_venda', 10,2)->nullable();
            $table->decimal('valor_frete', 10,2)->nullable();
            $table->decimal('desconto_valor', 10,2)->nullable();
            $table->decimal('desconto_per', 10,2)->nullable();
            $table->decimal('valor_desconto', 10,2)->nullable();           
            $table->text('observacao')->nullable();
            
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
        Schema::dropIfExists('venda_balcaos');
    }
};
