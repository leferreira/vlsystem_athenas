<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFornecedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fornecedors', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresa_id')->unsigned();
            
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->string('razao_social', 100);
            $table->string('nome_fantasia', 80)->nullable();
            $table->string('cnpj', 19);
            $table->string('logradouro', 80);
            $table->string('numero', 10);
            $table->string('bairro', 50);
            $table->string('uf', 2);
            
            $table->string("rg_ie", 20)->nullable();
            $table->string("im", 20)->nullable();
            $table->string("tipo_contribuinte", 30)->nullable();
            
            $table->string('complemento', 50)->nullable();
            $table->string('telefone', 20)->nullable();
            $table->string('celular', 20)->nullable();
            $table->string('email', 40)->nullable();
            $table->string('cep', 10)->nullable();
            $table->string('cidade',100)->nullable();
            $table->string('ibge', 15)->nullable();
            
            
            
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
        Schema::dropIfExists('fornecedors');
    }
}
