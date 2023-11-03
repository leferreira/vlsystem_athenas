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
        Schema::create('cupom_descontos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            
            $table->bigInteger('produto_id')->unsigned()->nullable();
            $table->foreign('produto_id')->references('id')->on('produtos');
            
            $table->bigInteger('categoria_id')->unsigned()->nullable();
            $table->foreign('categoria_id')->references('id')->on('empresas');
            
            $table->string("codigo",80);
            $table->string("descricao",80);
            $table->decimal("valor_desconto",10,2)->nullable();
            $table->decimal("valor_minimo",10,2)->nullable();
            $table->decimal("desconto_por_valor",10,2)->nullable();
            $table->decimal("desconto_percentual",10,2)->nullable();
            $table->date("data_validade")->nullable();
            $table->integer("qtde_limite")->nullable();
            $table->string("ativo", 1 );
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
        Schema::dropIfExists('cupom_descontos');
    }
};
