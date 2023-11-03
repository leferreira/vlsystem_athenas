<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresa_id')->unsigned();            
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->string('nome', 100);
            $table->string('gtin', 20)->nullable();
            $table->string('codigo_barra', 20)->nullable();
            $table->string('sku', 50)->nullable();
            $table->string('gtin_trib', 20)->nullable();
            $table->string('imagem', 100)->nullable();                
            $table->string('uuid', 100)->nullable(); 
            $table->string('origem', 10)->nullable();
            $table->string('usa_grade', 1)->nullable();
            
            $table->Biginteger('status_id')->nullable()->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses'); 
            
            
            $table->BigInteger('tipo_produto_id')->nullable()->unsigned();
            $table->foreign('tipo_produto_id')->references('id')->on('tipo_produtos');
            
            $table->BigInteger('categoria_id')->nullable()->unsigned();
            $table->foreign('categoria_id')->references('id')->on('categorias');            
            
            
            $table->BigInteger('localizacao_id')->nullable()->unsigned();
            $table->foreign('localizacao_id')->references('id')->on('localizacaos');
            
            $table->string('unidade', 10);
            $table->string('unidade_pdv', 10)->nullable();
            
            $table->string('referencia', 50)->nullable();
            
            $table->decimal('qtde_venda', 10,2)->nullable()->default(0);
            
            $table->decimal('fragmentacao_qtde', 10,2)->nullable()->default(0);
            $table->string('fragmentacao_unidade', 10)->nullable();
            $table->decimal('fragmentacao_valor', 10,2)->nullable()->default(0);
            
            $table->decimal('valor_venda_atacado', 10,2)->nullable()->default(0);
            $table->decimal('valor_atacado_apartir', 10,2)->nullable()->default(0);
            $table->decimal('comissao', 10,2)->nullable()->default(0);
            $table->decimal('valor_maior', 10,2)->nullable()->default(0);
            $table->decimal('valor_venda', 10,2)->nullable()->default(0);
            $table->decimal('valor_custo', 10,2)->nullable()->default(0);
            $table->decimal('margem_lucro', 10,2)->nullable()->default(0);
            $table->decimal('custo_medio', 10,2)->nullable()->default(0);
            
            $table->date('validade')->nullable();
            $table->date('ultima_compra')->nullable();
            
            $table->decimal('estoque_minimo', 10,2)->nullable()->default(0);
            $table->decimal('estoque_maximo', 10,2)->nullable()->default(0);
            $table->decimal('estoque_inicial', 10,2)->nullable()->default(0);
            $table->integer('estoque_atual')->nullable()->default(0);           
            
            
            $table->string('cfop', 15)->nullable();            
            $table->string('ncm', 13)->nullable();
            $table->string('cest', 7)->nullable();
            $table->string('cbenef', 10)->nullable();
            $table->string('indescala',1)->nullable();
            $table->string('cnpjfabricante', 20)->nullable();
            
            $table->decimal('pDif', 10,2)->nullable();
            $table->decimal('pMVAST', 10,2)->nullable();
            $table->decimal('pRedBC', 10,2)->nullable();
            $table->decimal('pRedBCST', 10,2)->nullable();
            $table->decimal('pICMS', 10,2)->nullable();
            $table->decimal('pPIS', 10,2)->nullable();
            $table->decimal('pCOFINS', 10,2)->nullable();
            $table->decimal('pIPI', 10,2)->nullable();
            $table->decimal('aliquotapis', 10,2)->nullable();
            $table->decimal('aliquotacofins', 10,2)->nullable();
            $table->decimal('aliquotaipi', 10,2)->nullable();
            $table->string('tributado_icms', 1)->default("S")->nullable();
            $table->string('tributado_ipi', 1)->default("S")->nullable();
            $table->string('tributado_pis', 1)->default("S")->nullable();
            $table->string('tributado_cofins', 1)->default("S")->nullable();
            
            $table->string('unidade_tributavel', 4)->default('');
            $table->decimal('quantidade_tributavel', 10, 2)->default(0);
            
            
            //Dados da Loja
            $table->string('produto_loja',1)->default('N');
            $table->string('produto_delivery',1)->default('N');            
            $table->string('controlar_estoque',1)->default('S');
            
            
                       
            $table->text('descricao')->nullable();          
            $table->string('destaque',1)->nullable()->default('N');            
            $table->string('cep', 9)->nullable()->default('');
            
            
            $table->integer('num_volume')->nullable();
            $table->decimal('largura', 6, 2)->nullable()->default(0);
            $table->decimal('comprimento', 6, 2)->nullable()->default(0);
            $table->decimal('altura', 6, 2)->nullable()->default(0);
            $table->decimal('peso_liquido', 8, 3)->nullable()->default(0);
            $table->decimal('peso_bruto', 8, 3)->nullable()->default(0);            
       
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
        Schema::dropIfExists('produtos');
    }
}
