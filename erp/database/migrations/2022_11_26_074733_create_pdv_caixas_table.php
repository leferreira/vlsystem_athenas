<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePdvCaixasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pdv_caixas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            
            $table->bigInteger('caixanumero_id')->unsigned();
            $table->foreign('caixanumero_id')->references('id')->on('pdv_caixa_numeros');
            
            $table->date("data_abertura");
            $table->time("hora_abertura");
            $table->decimal("valor_abertura",10,2)->nullable();
            
            $table->date("data_fechamento")->nullable();
            $table->time("hora_fechamento")->nullable();
            $table->decimal("valor_fechamento",10,2)->nullable();            
            
            $table->decimal("dinheiro_gaveta",10,2)->nullable();
            $table->decimal("valor_vendido",10,2)->nullable();
            $table->decimal("valor_quebra",10,2)->nullable();
            $table->decimal("valor_sangria",10,2)->nullable();
            $table->decimal("valor_suplemento",10,2)->nullable();
            $table->decimal("total_em_caixa",10,2)->nullable();            
            
            $table->bigInteger('usuario_abriu_id')->unsigned();
            $table->foreign('usuario_abriu_id')->references('id')->on('users');
            
            $table->bigInteger('usuario_fechou_id')->nullable()->unsigned();
            $table->foreign('usuario_fechou_id')->references('id')->on('users');
            
            $table->bigInteger('gerente_abriu_id')->nullable()->unsigned();
            $table->foreign('gerente_abriu_id')->references('id')->on('users');
           
            $table->bigInteger('gerente_fechou_id')->nullable()->unsigned();
            $table->foreign('gerente_fechou_id')->references('id')->on('users');
            
            $table->bigInteger('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses');
            
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
        Schema::dropIfExists('pdv_caixas');
    }
}
