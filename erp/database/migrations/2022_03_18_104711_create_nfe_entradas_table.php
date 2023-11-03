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
        Schema::create('nfe_entradas', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('status_id')->nullable()->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses');
            
            $table->bigInteger('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            
            $table->bigInteger('fornecedor_id')->nullable()->unsigned();
            $table->foreign('fornecedor_id')->references('id')->on('fornecedors');
            
            $table->bigInteger('transportadora_id')->nullable()->unsigned();
            $table->foreign('transportadora_id')->references('id')->on('transportadoras');
            
            $table->date("data_cadastro")->nullable();
            $table->string('chave',60)->nullable();
            $table->string('recibo',40)->nullable();
            $table->string('protocolo',40)->nullable();
            $table->string('cUF',10);
            $table->string('cNF',8);
            $table->string('natOp',80);
            $table->string('modelo',2)->nullable();
            $table->string('serie',3)->nullable();
            $table->string('nNF',15)->nullable();
            $table->string('cDV',44)->nullable();
            $table->string('dhEmi',40)->nullable();
            $table->string('dhSaiEnt',40)->nullable();
            $table->integer('tpNF')->nullable();
            $table->integer('idDest')->nullable();
            $table->integer('cMunFG')->nullable();
            $table->integer('tpImp')->nullable();
            $table->integer('tpEmis')->nullable();
            $table->integer('tpAmb')->nullable();
            $table->integer('finNFe')->nullable();
            $table->integer('indFinal')->nullable();
            $table->integer('indPres')->nullable();
            $table->string('indIntermed',1)->nullable();
            $table->integer('procEmi')->nullable();
            $table->string('verProc',20)->nullable();
            $table->date('dhCont')->nullable();
            $table->string('xJust',255)->nullable();
            
            $table->decimal('vBC',10,4)->nullable();
            $table->decimal('vICMS',10,4)->nullable();
            $table->decimal('vICMSDeson',10,4)->nullable();
            $table->decimal('vFCP',10,4)->nullable();
            $table->decimal('vBCST',10,4)->nullable();
            $table->decimal('vST',10,4)->nullable();
            $table->decimal('vFCPST',10,4)->nullable();
            $table->decimal('vFCPSTRet',10,4)->nullable();
            $table->decimal('vProd',10,2)->nullable();
            $table->decimal('vFrete',10,2)->nullable();
            $table->decimal('vSeg',10,2)->nullable();
            $table->decimal('vDesc',10,2)->nullable();
            $table->decimal('vII',10,4)->nullable();
            $table->decimal('vIPI',10,4)->nullable();
            $table->decimal('vIPIDevol',10,4)->nullable();
            $table->decimal('vPIS',10,4)->nullable();
            $table->decimal('vCOFINS',10,4)->nullable();
            $table->decimal('vOutro',10,2)->nullable();
            $table->decimal('vNF',10,4)->nullable();
            $table->decimal('vTotTrib',10,4)->nullable();
            $table->decimal('vOrig',10,2)->nullable();
            $table->decimal('vLiq',10,2)->nullable();
            $table->string('nFat',10)->nullable();            
            
            $table->string('modFrete',2)->nullable();            
            
            $table->string('tPag',20)->nullable();
            $table->decimal('vPag',10,2)->nullable();
            $table->string('CNPJ_pag',20)->nullable();
            $table->string('tBand',20)->nullable();
            $table->string('cAut',20)->nullable();
            $table->string('tpIntegra',20)->nullable();
            $table->string('indPag',20)->nullable();
            
            
            $table->text('infAdFisco')->nullable();
            $table->text('infCpl')->nullable();
            
            
            
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
        Schema::dropIfExists('nfe_entradas');
    }
};
