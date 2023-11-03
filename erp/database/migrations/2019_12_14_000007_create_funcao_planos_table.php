<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuncaoPlanosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcao_planos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('funcao_id')->unsigned();
            $table->bigInteger('plano_id')->unsigned();
            
            $table->foreign('funcao_id')->references('id')->on('funcaos');
            $table->foreign('plano_id')->references('id')->on('planos');
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
        Schema::dropIfExists('funcao_planos');
    }
}
