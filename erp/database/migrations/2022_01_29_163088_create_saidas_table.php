<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saidas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresa_id')->unsigned();            
            $table->foreign('empresa_id')->references('id')->on('empresas');
            
            $table->bigInteger('grade_produto_id')->nullable()->unsigned();
            $table->foreign('grade_produto_id')->references('id')->on('grade_produtos');
            
            $table->BigInteger("produto_id")->unsigned();
            $table->foreign("produto_id")->references("id")->on("produtos");
            
            $table->decimal("qtde_saida",10,2)->default(1);
            $table->decimal("valor_saida")->default(0);
            $table->decimal("subtotal_saida",5,2);
            $table->string("unidade")->nullable();
            $table->date("data_saida");
            $table->string("observacao")->nullable();
            $table->string("eh_grade",1)->nullable();
            
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
        Schema::dropIfExists('saidas');
    }
}
