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
        Schema::create('grade_produtos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            
            $table->bigInteger('produto_id')->unsigned();
            $table->foreign('produto_id')->references('id')->on('produtos');
            
            $table->bigInteger('variacao_grade_linha_id')->unsigned()->nullable();
            $table->foreign('variacao_grade_linha_id')->references('id')->on('variacao_grades');
          
            $table->bigInteger('linha_id')->unsigned()->nullable();
            $table->foreign('linha_id')->references('id')->on('item_variacao_grades');
            
            
            $table->bigInteger('variacao_grade_coluna_id')->unsigned()->nullable();
            $table->foreign('variacao_grade_coluna_id')->references('id')->on('variacao_grades');
            
            $table->string('sku', 50)->nullable();
            $table->string("descricao", 120)->nullable();
            $table->string("codigo_barra", 80)->nullable();
            
            $table->bigInteger('coluna_id')->unsigned()->nullable();
            $table->foreign('coluna_id')->references('id')->on('item_variacao_grades');
            
            
            $table->decimal("estoque", 10,2)->nullable(); 
            $table->decimal("estoque_temporario", 10,2)->nullable();
            
            $table->string("iniciou_estoque", 1)->nullable();             
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('grade_produtos');
    }
};
