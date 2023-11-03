<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntradasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entradas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresa_id')->unsigned();            
            $table->foreign('empresa_id')->references('id')->on('empresas');
            
            $table->bigInteger('grade_produto_id')->nullable()->unsigned();
            $table->foreign('grade_produto_id')->references('id')->on('grade_produtos');
            
            $table->BigInteger("produto_id")->unsigned();
            $table->decimal("qtde_entrada",10,2)->default(1);
            $table->decimal("valor_entrada")->default(0);
            $table->decimal("subtotal_entrada",10,2);
            $table->string("unidade")->nullable();
            $table->date("data_entrada");            
            $table->string("observacao")->nullable();
            $table->string("eh_grade",1)->nullable();
            $table->foreign("produto_id")->references("id")->on("produtos");
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
        Schema::dropIfExists('entradas');
    }
}
