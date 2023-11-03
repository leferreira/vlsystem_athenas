<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLojaBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loja_banners', function (Blueprint $table) {
            $table->id();
            
            
            $table->bigInteger('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            
            $table->bigInteger('produto_id')->nullable()->unsigned();
            $table->foreign('produto_id')->references('id')->on('produtos');
            
            $table->bigInteger('loja_pacote_id')->nullable()->unsigned();
            $table->foreign('loja_pacote_id')->references('id')->on('loja_pacotes');
            
            $table->bigInteger('status_id')->nullable()->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->string('path', 100);
            $table->string('titulo', 20);
            $table->string('descricao', 100)->nullable();
            $table->integer('ordem')->nullable();
            
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
        Schema::dropIfExists('loja_banners');
    }
}
