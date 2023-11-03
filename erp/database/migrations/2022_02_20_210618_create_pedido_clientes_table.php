<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidoClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido_clientes', function (Blueprint $table) {
            $table->id();
            $table->BigInteger("empresa_id")->unsigned();
            $table->foreign("empresa_id")->references("id")->on("empresas");
            
            $table->BigInteger("venda_id")->nullable()->unsigned();
            $table->foreign("venda_id")->references("id")->on("vendas");
            
            $table->BigInteger("status_id")->unsigned();
            $table->foreign("status_id")->references("id")->on("statuses");
            $table->text("observacao")->nullable();
            $table->string("identificador")->unique();
            $table->string("origem", 50);
            $table->date('data_pedido');
            $table->time('hora_pedido');
            $table->decimal('total',10,2);   
            
            $table->date("data_atendimento")->nullable();
            
            $table->BigInteger("cliente_id")->unsigned();            
            $table->foreign("cliente_id")->references("id")->on("clientes");
            
            
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
        Schema::dropIfExists('pedido_clientes');
    }
}
