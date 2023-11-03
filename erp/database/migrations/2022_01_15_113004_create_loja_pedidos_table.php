<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLojaPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loja_pedidos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresa_id')->nullable()->unsigned();
            
            $table->foreign('empresa_id')->references('id')->on('empresas');
            
            $table->BigInteger('cliente_id')->nullable()->unsigned();
            $table->foreign('cliente_id')->references('id')->on('clientes');
            
            $table->BigInteger('endereco_id')->nullable()->unsigned();
            $table->foreign('endereco_id')->references('id')->on('endereco_clientes');
            
            $table->BigInteger('status_id')->nullable()->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses');
            
            $table->BigInteger('status_entrega_id')->nullable()->unsigned();
            $table->foreign('status_entrega_id')->references('id')->on('status_entregas');
            
            $table->BigInteger('status_financeiro_id')->nullable()->unsigned();
            $table->foreign('status_financeiro_id')->references('id')->on('statuses');
            
            $table->BigInteger('vendedor_id')->nullable()->unsigned();
            $table->foreign('vendedor_id')->references('id')->on('vendedors');
            
            $table->BigInteger('forma_pagto_id')->nullable()->unsigned();
            $table->foreign('forma_pagto_id')->references('id')->on('forma_pagtos');
            
            $table->BigInteger('cupom_desconto_id')->nullable()->unsigned();
            $table->foreign('cupom_desconto_id')->references('id')->on('cupom_descontos');
            
            $table->BigInteger('pdvvenda_id')->nullable()->unsigned();
            $table->integer('venda_id')->nullable()->default(0);
            
            $table->string("uuid", 100);
            $table->string("enviou_nfe", 1)->nullable();
            $table->string('codigo_rastreio', 20)->nullable()->default('');  
            
            $table->date('data_pedido')->nullable();
            $table->date('data_pagamento')->nullable();
            $table->date('data_separacao')->nullable();
            $table->date('data_envio')->nullable();
            $table->date('data_entrega')->nullable();
            
            $table->decimal('valor_liquido', 10,2)->nullable();
            $table->decimal('valor_venda', 10,2)->nullable();
            $table->decimal('valor_frete', 10,2)->nullable();
            $table->decimal('desconto_valor', 10,2)->nullable();
            $table->decimal('desconto_per', 10,2)->nullable();
            $table->decimal('valor_desconto', 10,2)->nullable();
            $table->decimal('valor_desconto_cupom', 10,2)->nullable();
            
            $table->string('tipo_frete', 10)->nullable();
            
            
            $table->integer('numero_nfe')->nullable()->default(0);
            
            $table->string('estornou_estoque', 1)->nullable();
            $table->string('observacao', 100)->nullable();
            $table->string('rand_pedido', 20)->nullable();
            
            $table->text('link_boleto')->nullable();
            $table->text('qr_code_base64')->nullable();
            $table->text('qr_code')->nullable();
            
            $table->string('transacao_id', 100)->nullable()->default('');
            
            $table->string('status_pagamento', 15)->nullable()->default('');
            $table->string('status_detalhe', 100)->nullable()->default('');
            $table->string('hash', 20)->nullable()->default('');
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
        Schema::dropIfExists('loja_pedidos');
    }
}
