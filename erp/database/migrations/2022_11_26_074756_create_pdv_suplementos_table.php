<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePdvSuplementosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pdv_suplementos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('caixa_id')->unsigned();
            $table->foreign('caixa_id')->references('id')->on('pdv_caixas');
            
            $table->bigInteger('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            
            $table->BigInteger('usuario_id')->unsigned()->nullable();
            $table->foreign("usuario_id")->references("id")->on("users");
            
            $table->string('descricao',90)->nullable();
            $table->decimal('valor', 10,2);
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
        Schema::dropIfExists('pdv_suplementos');
    }
}
