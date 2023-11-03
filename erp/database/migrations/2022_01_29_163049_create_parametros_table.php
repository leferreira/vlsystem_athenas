<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParametrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parametros', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresa_id')->unsigned();            
            $table->foreign('empresa_id')->references('id')->on('empresas');
    
         
            //geral
            $table->integer("num_paginacao")->default(2)->nullable();
            $table->decimal("margem_lucro")->default(0)->nullable();
            $table->decimal("estoque_minimo_padrao")->default(0)->nullable();
            $table->decimal("estoque_maximo_padrao")->default(0)->nullable();
            $table->string("permitir_estoque_negativo", 1)->nullable();
            $table->integer("num_casas_decimais")->nullable();
                      
            
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
        Schema::dropIfExists('parametros');
    }
}
