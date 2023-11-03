<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTributacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tributacaos', function (Blueprint $table) {
            $table->id();
           
            $table->bigInteger('empresa_id')->unsigned();            
            $table->foreign('empresa_id')->references('id')->on('empresas');
            
            $table->bigInteger('natureza_operacao_id')->unsigned();
            $table->foreign('natureza_operacao_id')->references('id')->on('natureza_operacaos');
            
            $table->string('descricao',90);
            $table->string('cfop',10);
            $table->string('cfop_fora',10)->nullable();
            $table->string('cfop_fora_consumidor_final',10)->nullable();
            $table->string('cfop_exportacao',10)->nullable();
            $table->string('padrao',1)->default('N');                       
            $table->string('cstIPI',20);
            $table->string('clEnq',150)->nullable();
            $table->string('CNPJProd',25)->nullable();
            $table->string('cSelo',25)->nullable();
            $table->string('qSelo',25)->nullable();
            $table->string('cEnq',25)->nullable();
            $table->integer('tipo_calc_ipi')->nullable();
            $table->decimal('pIPI',15,2)->nullable();
            $table->decimal('vUnidIPI',15,2)->nullable();
            $table->decimal('qUnidIPI',15,2)->nullable();
            
            $table->string('cstPIS',10);
            $table->integer('tipo_calc_pis')->nullable();
            $table->decimal('pPIS',10,2)->nullable();
            $table->decimal('vAliqProd_pis',10,2)->nullable();
            $table->integer('tipo_calc_pisst')->nullable();
            $table->decimal('pPISST',10,2)->nullable();
            $table->decimal('vAliqProd_pisst',10,2)->nullable();
            
            $table->string('cstCOFINS',25);
            $table->integer('tipo_calc_cofins',)->nullable();
            $table->decimal('pCOFINS',15,2)->nullable();
            $table->decimal('vAliqProd_cofins',15,2)->nullable();
            $table->integer('tipo_calc_cofinsst',)->nullable();
            $table->decimal('pCOFINSST',10,2)->nullable();
            $table->decimal('vAliqProd_cofinsst',15,2)->nullable();            
            
            $table->string('cstICMS',20);
            $table->integer('modBC')->nullable();
            $table->decimal('vBCICMS',10,2)->nullable();            
            $table->decimal('pICMS',15,2)->nullable();
            $table->integer('modBCST')->nullable();
            $table->decimal('pMVAST',15,2)->nullable();
            $table->decimal('pRedBCST',15,2)->nullable();
            $table->string('preco_unit_Pauta_ST',15,2)->nullable();
            $table->decimal('pICMSST',15,2)->nullable();
            $table->decimal('pRedBC',15,2)->nullable();
            $table->integer('motDesICMS')->nullable();
            $table->decimal('pBCOp',15,2)->nullable();
            $table->string('UFST',20)->nullable();
            $table->decimal('pCredSN',15,2)->nullable();
            $table->decimal('pFCP',15,2)->nullable();
            $table->decimal('vICMSSubstituto',15,2)->nullable();
            $table->decimal('pFCPST',15,2)->nullable();     
            $table->decimal('pFCPSTRet',15,2)->nullable();
            $table->decimal('pDif',15,2)->nullable();
            
            $table->string('uso_consumo',1)->nullable();  
            
            //vbc icms         
            
            $table->string('vbc_somente_produto',1)->default('N')->nullable();
            $table->string('vbc_frete',1)->default('S')->nullable(); 
            $table->string('vbc_ipi',1)->default('S')->nullable(); 
            $table->string('vbc_outros',1)->default('S')->nullable(); 
            $table->string('vbc_seguro',1)->default('S')->nullable(); 
            $table->string('vbc_desconto',1)->default('S')->nullable();
            
            $table->string('ipi_somente_produto',1)->default('N')->nullable();
            $table->string('ipi_frete',1)->default('S')->nullable();
            $table->string('ipi_outros',1)->default('S')->nullable();
            $table->string('ipi_seguro',1)->default('S')->nullable();
            $table->string('ipi_desconto',1)->default('S')->nullable();
            
            $table->string('pis_somente_produto',1)->default('N')->nullable();
            $table->string('pis_frete',1)->default('S')->nullable();
            $table->string('pis_ipi',1)->default('S')->nullable();
            $table->string('pis_outros',1)->default('S')->nullable();
            $table->string('pis_seguro',1)->default('S')->nullable();
            $table->string('pis_desconto',1)->default('S')->nullable();
            
            $table->string('cofins_somente_produto',1)->default('N')->nullable();
            $table->string('cofins_frete',1)->default('S')->nullable();
            $table->string('cofins_ipi',1)->default('S')->nullable();
            $table->string('cofins_outros',1)->default('S')->nullable();
            $table->string('cofins_seguro',1)->default('S')->nullable();
            $table->string('cofins_desconto',1)->default('S')->nullable();
            
            $table->string('cst900_icms',1)->default('N')->nullable();
            $table->string('cst900_redbc',1)->default('N')->nullable();
            $table->string('cst900_credisn',1)->default('N')->nullable();
            $table->string('cst900_st',1)->default('N')->nullable();
            $table->string('cst900_redbcst',1)->default('N')->nullable();
            
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
        Schema::dropIfExists('tributacaos');
    }
}
