<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuncaoPermissaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcao_permissao', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('permissao_id')->unsigned();
            $table->bigInteger('funcao_id')->unsigned();
            
            $table->foreign('permissao_id')->references('id')->on('permissaos')->onDelete('cascade');
            $table->foreign('funcao_id')->references('id')->on('funcaos')->onDelete('cascade');            
            $table->integer('menu_id')->nullable();
            $table->integer('submenu_id')->nullable();
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
        Schema::dropIfExists('funcao_permissao');
    }
}
