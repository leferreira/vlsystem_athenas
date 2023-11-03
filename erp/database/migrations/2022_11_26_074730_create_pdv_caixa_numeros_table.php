<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePdvCaixaNumerosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pdv_caixa_numeros', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->integer('num_caixa');
            $table->string('descricao', 50)->nullable();
            $table->string('gerar_nfce', 1)->nullable();
            $table->string('transmitir_nfce', 1)->nullable();
            $table->string('imprimir_direto_na_impressora', 1)->nullable();
            $table->string('mostrar_pdf', 1)->nullable();
            $table->string('gerar_financeiro', 1)->nullable();
            $table->string('gerar_estoque', 1)->nullable();
            $table->string('pergunta_antes_de_finalizar_venda', 1)->nullable();
            $table->string('apos_a_venda', 20)->nullable();
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
        Schema::dropIfExists('pdv_caixa_numeros');
    }
}
