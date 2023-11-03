<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNaturezaOperacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('natureza_operacaos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');  
            
            $table->string('descricao',80);
            $table->string('tipo',1);
            $table->integer('finNFe');
            $table->string('indPres');
            $table->string('devolucao');
            $table->integer('padrao')->nullable();
            
            $table->text('obs')->nullable();
            $table->text('infAdFisco')->nullable();
            
                      
            
            
            //ICMS
            $table->string('cstIcms')->nullable();
            $table->string('cfop')->nullable();
            $table->integer('modBC')->nullable();
            $table->decimal('pICMS',10,2)->nullable();
            $table->decimal('pRedBC',10,2)->nullable();
            $table->integer('modBCST')->nullable();
            $table->decimal('vBCST',10,2)->nullable();
            $table->decimal('pICMSST',10,2)->nullable();
            $table->decimal('pMVAST',10,2)->nullable();
            $table->decimal('pRedBCST',10,2)->nullable();
            $table->decimal('vICMSSubstituto',10,2)->nullable();
            $table->decimal('pFCP',10,2)->nullable();
            $table->decimal('pFCPST',10,2)->nullable();
            $table->decimal('pFCPSTRet',10,2)->nullable();
            $table->decimal('pDif',10,2)->nullable();
            $table->string('obsExICMS',90)->nullable();
            $table->string('infAdFiscoRegraICMS',90)->nullable();
            
            //IPI
            $table->string('cstIpi')->nullable();
            $table->decimal('pIPI',10,2)->nullable();
            $table->decimal('vBCIPI',10,2)->nullable();
            $table->integer('tipo_calc_ipi')->nullable();
            $table->string('CNPJProd',20)->nullable();
            $table->string('cSelo',60)->nullable();
            $table->string('qSelo',12)->nullable();
            $table->string('cEnq',3)->nullable();            
            $table->decimal('qUnidIPI',10,2)->nullable();
            $table->decimal('vUnidIPI',10,2)->nullable();
            
            //PIS
            $table->string('cstPis')->nullable();
            $table->integer('tipo_calc_pis')->nullable();
            $table->decimal('pPIS',10,2)->nullable();
            $table->decimal('vBCPIS',10,2)->nullable();
            $table->decimal('vAliqProd_pis',10,2)->nullable();
            $table->decimal('pPISST',10,2)->nullable();
            $table->decimal('vAliqProd_pisst',10,2)->nullable();
            
            //COFINS 
            $table->string('cstCofins')->nullable();
            $table->integer('tipo_calc_cofins')->nullable();            
            $table->decimal('pCOFINS',10,2)->nullable();
            $table->decimal('vAliqProd_cofins',10,2)->nullable();            
            $table->decimal('pCOFINSST',10,2)->nullable();
            $table->integer('tipo_calc_cofinsst')->nullable(); 
            $table->decimal('vAliqProd_cofinsst',10,2)->nullable(); 
            $table->string('obsExCOFINS',90)->nullable();
            $table->string('infAdFiscoRegraCOFINS',90)->nullable();
            
            
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
        Schema::dropIfExists('natureza_operacaos');
    }
}
