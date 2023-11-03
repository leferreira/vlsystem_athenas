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
        Schema::create('tecnicos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->string('nome', 100);
            $table->string('cpf', 19)->nullable();
            $table->string("rg", 20)->nullable();
            
            $table->string('uuid', 100)->nullable();
            $table->string('logradouro', 80);
            $table->string('senha', 30)->nullable();
            $table->string('numero', 10);
            $table->string('bairro', 50);
            $table->string('uf', 2);
            $table->string('complemento', 50)->nullable();
            $table->string('telefone', 20)->nullable();
            $table->string('celular', 20)->nullable();
            $table->string('email', 40)->nullable();
            $table->string('cep', 10)->nullable();
            $table->string('ibge', 15)->nullable();
            $table->string('cidade',100)->nullable();
            
            $table->date("nascimento")->nullable();
            
            $table->bigInteger('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses');
            
            $table->string('password',100)->nullable();
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
        Schema::dropIfExists('tecnicos');
    }
};
