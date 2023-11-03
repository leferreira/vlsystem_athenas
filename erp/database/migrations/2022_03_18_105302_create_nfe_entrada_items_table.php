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
        Schema::create('nfe_entrada_items', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('nfe_id')->unsigned();
            $table->foreign('nfe_id')->references('id')->on('nfe_entradas');
            
            $table->bigInteger('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            
            $table->decimal('fragmentacao_qtde', 10,2)->nullable()->default(0);
            $table->string('fragmentacao_unidade', 10)->nullable();
            $table->decimal('fragmentacao_valor', 10,2)->nullable()->default(0);
            $table->decimal('valor_venda', 10,2)->nullable()->default(0);
            $table->decimal('valor_custo', 10,2)->nullable()->default(0);
            
            $table->integer('produto_id')->nullable();
            $table->integer('origem')->default(0)->nullable();
            $table->integer('fornecedor_id')->nullable();
            $table->integer('categoria_id')->nullable();
            $table->integer('subcategoria_id')->nullable();
            $table->integer('subsubcategoria_id')->nullable();
            $table->string('unidade',60)->nullable();
            $table->string('cfop_prod',20)->nullable();
            
            $table->integer('numero_item')->nullable();
            $table->string('importado',1)->default("N")->nullable();
            $table->string('cProd',60)->nullable();
            $table->string('cEAN',14)->nullable();
            $table->string('xProd',120)->nullable();
            $table->string('NCM',20)->nullable();
            $table->string('CEST',20)->nullable();
            $table->string('indEscala',1)->nullable();
            $table->string('cBenef',20)->nullable();
            $table->string('NVE',20)->nullable();
            $table->string('EXTIPI',15)->nullable();
            $table->string('CFOP',10)->nullable();
            $table->string('uCom',6)->nullable();
            $table->decimal('qCom',10,2)->nullable();
            $table->decimal('vUnCom',10,2)->nullable();
            $table->decimal('vProd',10,2)->nullable();
            $table->string('cEANTrib',14)->nullable();
            $table->string('uTrib',6)->nullable();
            $table->decimal('qTrib',10,2)->nullable();
            $table->decimal('vUnTrib',10,2)->nullable();
            $table->decimal('proporcao',10,2)->nullable();
            $table->decimal('vFrete',10,2)->nullable();
            $table->decimal('vSeg',10,2)->nullable();
            $table->decimal('desconto_item',10,2)->nullable();
            $table->decimal('desconto_rateio',10,2)->nullable();
            $table->decimal('vDesc',10,2)->nullable();
            $table->decimal('vOutro',10,2)->nullable();
            $table->integer('indTot')->nullable();
            $table->string('xPed',15)->nullable();
            $table->integer('nItemPed')->nullable();
            $table->string('nFCI',36)->nullable();
            $table->string('cstIPI',40)->nullable();
            $table->string('clEnq',40)->nullable();
            $table->string('CNPJProd',40)->nullable();
            $table->string('cSelo',40)->nullable();
            $table->string('qSelo',40)->nullable();
            $table->string('cEnq',40)->nullable();
            $table->decimal('vIPI',10,2)->nullable();
            $table->decimal('vBCIPI',10,2)->nullable();
            $table->decimal('pIPI',10,2)->nullable();
            $table->decimal('qUnidIPI',10,2)->nullable();
            $table->decimal('vUnidIPI',10,2)->nullable();
            $table->integer('tipo_calc_ipi')->nullable();
            
            
            $table->string('cstCOFINS',40)->nullable();
            $table->decimal('pCOFINS',10,2)->nullable();
            $table->decimal('qBCProdConfis',10,2)->nullable();
            $table->integer('tipo_calc_cofins')->nullable();
            $table->decimal('vAliqProd_cofins',10,2)->nullable();
            $table->decimal('vBCCOFINS',10,2)->nullable();
            $table->decimal('vCOFINS',10,2)->nullable();
            $table->integer('tipo_calc_cofinsst')->nullable();
            $table->decimal('pCOFINSST',10,2)->nullable();
            $table->decimal('vBCCOFINSST',10,2)->nullable();
            $table->decimal('vCOFINSST',10,2)->nullable();
            
            $table->decimal('qBCProdConfisST',10,2)->nullable();
            $table->decimal('vAliqProd_cofinsst',10,2)->nullable();
            
            $table->decimal('estadual',10,2)->nullable();
            $table->decimal('municipal',10,2)->nullable();
            $table->decimal('nacionalfederal',10,2)->nullable();
            $table->decimal('importadosfederal',10,2)->nullable();
            $table->decimal("vTotTrib",10,2)->nullable();
            
            $table->string('cstPIS',40)->nullable();
            $table->integer('tipo_calc_pis')->nullable();
            $table->decimal('vBCPIS',10,2)->nullable();
            $table->decimal('pPIS',10,2)->nullable();
            $table->decimal('vPIS',10,2)->nullable();
            $table->decimal('qBCProdPis',10,2)->nullable();
            $table->decimal('qBCProdPisST',10,2)->nullable();
            $table->decimal('vBCPISST',10,2)->nullable();
            $table->decimal('vAliqProd_pis',10,2)->nullable();
            $table->integer('tipo_calc_pisst')->nullable();
            $table->decimal('pPISST',10,2)->nullable();
            $table->decimal('vPISST',10,2)->nullable();
            $table->decimal('vAliqProd_pisst',10,2)->nullable();
            $table->string('orig',5)->nullable();
            $table->string('cstICMS',40)->nullable();
            $table->string('modBC',10)->nullable();
            $table->decimal('vBCICMS',10,2)->nullable();
            $table->decimal('vICMSTRet',10,2)->nullable();
            $table->decimal('pICMSIntra',10,2)->nullable();
            $table->decimal('pICMS',10,2)->nullable();
            $table->decimal('vICMS',10,2)->nullable();
            $table->decimal('pFCP',10,2)->nullable();
            $table->decimal('vFCP',10,2)->nullable();
            $table->decimal('vBCFCP',10,2)->nullable();
            $table->decimal('pMVAST',10,2)->nullable();
            $table->decimal('pRedBCST',10,2)->nullable();
            $table->decimal('vBCST',10,2)->nullable();
            $table->decimal('pICMSST',10,2)->nullable();
            $table->decimal('vICMSST',10,2)->nullable();
            $table->decimal('vBCFCPST',10,2)->nullable();
            $table->decimal('pFCPST',10,2)->nullable();
            $table->decimal('vFCPST',10,2)->nullable();
            $table->decimal('vICMSDeson',10,2)->nullable();
            $table->integer('motDesICMS')->nullable();
            $table->decimal('pRedBC',10,2)->nullable();
            $table->decimal('vICMSOp',10,2)->nullable();
            $table->decimal('pDif',10,2)->nullable();
            $table->decimal('vICMSDif',10,2)->nullable();
            $table->decimal('vBCSTRet',10,2)->nullable();
            $table->decimal('pST',10,2)->nullable();
            $table->decimal('vICMSSTRet',10,2)->nullable();
            $table->decimal('vBCFCPSTRet',10,2)->nullable();
            $table->decimal('pFCPSTRet',10,2)->nullable();
            $table->decimal('vFCPSTRet',10,2)->nullable();
            $table->decimal('pRedBCEfet',10,2)->nullable();
            $table->decimal('vBCEfet',10,2)->nullable();
            $table->decimal('pICMSEfet',10,2)->nullable();
            $table->decimal('vICMSEfet',10,2)->nullable();
            $table->decimal('vICMSSubstituto',10,2)->nullable();
            $table->string('modBCST',10)->nullable();
            $table->decimal('pBCOp',10,2)->nullable();
            $table->decimal('UFST',10,2)->nullable();
            $table->decimal('vBCSTDest',10,2)->nullable();
            $table->decimal('vICMSSTDest',10,2)->nullable();
            $table->string('CSOSN',40)->nullable();
            $table->decimal('pCredSN',10,2)->nullable();
            $table->decimal('vCredICMSSN',10,2)->nullable();
            $table->decimal('vBCUFDest',10,2)->nullable();
            $table->decimal('vBCFCPUFDest',10,2)->nullable();
            $table->decimal('pFCPUFDest',10,2)->nullable();
            $table->decimal('pICMSUFDest',10,2)->nullable();
            $table->decimal('pICMSInter',10,2)->nullable();
            $table->decimal('pICMSInterPart',10,2)->nullable();
            $table->decimal('vFCPUFDest',10,2)->nullable();
            $table->decimal('vICMSUFDest',10,2)->nullable();
            $table->decimal('vICMSUFRemet',10,2)->nullable();
            $table->string('infAdProd',100)->nullable(); 
            
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
        Schema::dropIfExists('nfe_entrada_items');
    }
};
