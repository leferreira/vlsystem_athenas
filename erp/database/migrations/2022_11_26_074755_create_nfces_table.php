<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNfcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nfces', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('venda_id')->nullable()->unsigned();
            $table->foreign('venda_id')->references('id')->on('vendas');
            
            $table->bigInteger('pdvvenda_id')->nullable()->unsigned();
            $table->foreign('pdvvenda_id')->references('id')->on('pdv_vendas');
            
            $table->bigInteger('status_id')->nullable()->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses');
            
            $table->bigInteger('natureza_operacao_id')->nullable()->unsigned();
            $table->foreign('natureza_operacao_id')->references('id')->on('natureza_operacaos');
            
            $table->BigInteger('classificacao_financeira_id')->nullable()->unsigned();
            $table->foreign('classificacao_financeira_id')->references('id')->on('classificacao_financeiras');
            
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
            $table->string('cnpjIntermed',15)->nullable();
            $table->string('idCadIntTran',80)->nullable();
            $table->integer('procEmi')->nullable();
            $table->string('verProc',20)->nullable();
            $table->date('dhCont')->nullable();
            
            $table->string('xJust',255)->nullable();
            
            $table->decimal('vProd_liquido',10,2)->nullable();
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
            $table->decimal('desconto_itens',10,2)->nullable();
            $table->decimal('desconto_nota',10,2)->nullable();
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
            
            $table->decimal('estadual',10,2)->nullable();
            $table->decimal('municipal',10,2)->nullable();
            $table->decimal('nacionalfederal',10,2)->nullable();
            $table->decimal('importadosfederal',10,2)->nullable();
            
            $table->string('em_xNome',60)->nullable();
            $table->string('em_xFant',60)->nullable();
            $table->string('em_IE',14)->nullable();
            $table->string('em_IEST',14)->nullable();
            $table->string('em_IM',15)->nullable();
            $table->string('em_CNAE',7)->nullable();
            $table->integer('em_CRT')->nullable();
            $table->string('em_CNPJ',18)->nullable();
            $table->string('em_CPF',30)->nullable();
            $table->string('em_xLgr',60)->nullable();
            $table->string('em_nro',60)->nullable();
            $table->string('em_xCpl',60)->nullable();
            $table->string('em_xBairro',60)->nullable();
            $table->string('em_cMun',10)->nullable();
            $table->string('em_xMun',60)->nullable();
            $table->string('em_UF',2)->nullable();
            $table->string('em_CEP',8)->nullable();
            $table->string('em_cPais',11)->nullable();
            $table->string('em_xPais',60)->nullable();
            $table->string('em_fone',14)->nullable();
            $table->string('em_EMAIL',60)->nullable();
            $table->string('em_SUFRAMA',40)->nullable();
            $table->dateTime('atualizacao')->nullable();
            
            $table->string('modFrete',2)->nullable();
            
            
            $table->string('tPag',20)->nullable();
            $table->decimal('vPag',10,2)->nullable();
            $table->string('CNPJ_pag',20)->nullable();
            $table->string('tBand',20)->nullable();
            $table->string('cAut',20)->nullable();
            $table->string('tpIntegra',20)->nullable();
            $table->string('indPag',20)->nullable();
            
            
            $table->string('infAdFisco',100)->nullable();
            $table->string('infCpl',150)->nullable();
            
            $table->bigInteger('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            
            $table->string('resp_CNPJ',50)->nullable();
            $table->string('resp_xContato',50)->nullable();
            $table->string('resp_email',50)->nullable();
            $table->string('resp_fone',50)->nullable();
            $table->string('resp_CSRT',50)->nullable();
            $table->string('resp_idCSRT',50)->nullable();
            
            $table->string('cliente_cpf',20)->nullable();
            $table->string('cliente_nome',100)->nullable();
            $table->string('cliente_cnpj',40)->nullable();
            $table->string('indIEDest',10)->nullable();
            
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
        Schema::dropIfExists('nfces');
    }
}
