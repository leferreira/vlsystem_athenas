<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTributacaoIvasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tributacao_ivas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('natureza_operacao_id')->unsigned();
            $table->foreign('natureza_operacao_id')->references('id')->on('natureza_operacaos');            
            
            $table->bigInteger('tributacao_id')->unsigned();
            $table->foreign('tributacao_id')->references('id')->on('tributacaos');            
            $table->string("cstIcms", 15)->nullable();
            $table->string("uf_origem",10)->nullable();
            $table->string("uf_destino",10)->nullable();
            $table->decimal("pIcmsIntra",10,2)->nullable();
            $table->decimal("pIcmsInter",10,2)->nullable();
            $table->decimal("pMVAST",10,2)->nullable();
            $table->decimal('pRedBCST', 10,2)->nullable();
            $table->decimal("pMVASTImportado",10,2)->nullable();
            $table->decimal("pFCPST",10,2)->nullable();            
            $table->decimal("pDifal",10,2)->nullable();
            $table->decimal("pFCPSTRet",10,2)->nullable();
            $table->integer("modBCST")->nullable();
            
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
        Schema::dropIfExists('tributacao_ivas');
    }
}
