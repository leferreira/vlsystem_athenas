<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmitentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emitentes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresa_id')->unsigned();            
            $table->foreign('empresa_id')->references('id')->on('empresas');
            
            $table->bigInteger('loja_conta_corrente_id')->nullable()->unsigned();            
            $table->foreign('loja_conta_corrente_id')->references('id')->on('conta_correntes');   
            
            $table->bigInteger('loja_classificacao_financeira_id')->nullable()->unsigned();
            $table->foreign('loja_classificacao_financeira_id')->references('id')->on('classificacao_financeiras');            
            
            $table->bigInteger('pdv_conta_corrente_id')->nullable()->unsigned();
            $table->foreign('pdv_conta_corrente_id')->references('id')->on('conta_correntes'); 
            
            $table->bigInteger('pdv_classificacao_financeira_id')->nullable()->unsigned();
            $table->foreign('pdv_classificacao_financeira_id')->references('id')->on('classificacao_financeiras');
            
            $table->bigInteger('cliente_consumidor')->nullable()->unsigned();   
            $table->string('razao_social', 100)->nullable();
            $table->string('nome_fantasia', 80)->nullable();
            $table->string('cnpj', 19)->nullable();
            $table->string('ie', 20)->nullable();
            $table->string('isento', 20)->nullable();
            $table->string('iest', 20)->nullable();
            $table->string('im', 20)->nullable();
            
            $table->string('cep', 10)->nullable();
            $table->string('logradouro', 80)->nullable();            
            $table->string('numero', 10)->nullable();
            $table->string('bairro', 50)->nullable();
            $table->string('complemento', 80)->nullable();            
            $table->char('uf', 2)->nullable();
            $table->string('cidade', 30)->nullable();
            $table->string('fone', 20)->nullable();
            $table->string('ibge', 20)->nullable();            
            
            $table->string('email', 90)->nullable();
            
            $table->string('pais', 20)->nullable();       
            $table->integer('codPais')->nullable();            
            $table->integer('crt')->nullable();
            $table->string('cnae', 7)->nullable();
            $table->integer('regimepiscofins')->nullable();
            $table->string('piscofinsmonofasico', 1)->nullable();
            $table->decimal('aliquotapis',10,2)->nullable();
            $table->decimal('aliqiuotacofins',10,2)->nullable();
            $table->decimal('pCredSN',10,2)->nullable();
           
            $table->string('indIntermed',1)->nullable();
            $table->string('cnpjIntermed',15)->nullable();
            $table->string('idCadIntTran',80)->nullable();
            
            $table->string('cst_csosn_padrao', 3)->nullable();
            $table->string('cst_cofins_padrao', 3)->nullable();
            $table->string('cst_pis_padrao', 3)->nullable();
            $table->string('cst_ipi_padrao', 3)->nullable();
            
            $table->text('infAdFisco')->nullable();
            $table->text('infCpl')->nullable();
            
            //NFE
            $table->integer('ambiente_nfe')->default(2);
            $table->integer('numero_serie_nfe')->nullable();
            $table->integer('ultimo_numero_nfe')->nullable();
            $table->string('nat_op_padrao_nfe',100)->nullable();
            
            //NFCE
            $table->integer('ambiente_nfce')->default(2);
            $table->integer('numero_serie_nfce')->nullable();
            $table->integer('ultimo_numero_nfce')->nullable();
            $table->string('csc', 60)->nullable();
            $table->string('csc_id', 10)->nullable();
            $table->string('gerar_nfce', 1)->defaul('S')->nullable();
            $table->string('transmitir_nfce', 1)->defaul('S')->nullable();
            $table->string('imprimir_nfce', 1)->defaul('S')->nullable();
            $table->string('nat_op_padrao_nfce',100)->nullable();
            
            //CTE
            $table->integer('ambiente_cte')->default(2);
            $table->integer('ultimo_numero_cte')->nullable();
            
            //MDFCE
            $table->integer('ambiente_mdfe')->default(2);
            $table->integer('ultimo_numero_mdfe')->nullable();          
            
            
            
            //Responsável tecnico
            $table->string('resp_CNPJ',50)->nullable();
            $table->string('resp_xContato',50)->nullable();
            $table->string('resp_email',50)->nullable();
            $table->string('resp_fone',50)->nullable();
            $table->string('resp_CSRT',50)->nullable();
            $table->string('resp_idCSRT',50)->nullable();
            
            
            $table->string('nome_contador', 90)->nullable();
            $table->string('email_contador', 90)->nullable();
            
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
        Schema::dropIfExists('emitentes');
    }
}
