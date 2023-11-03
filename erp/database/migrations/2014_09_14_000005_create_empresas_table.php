<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            
            $table->string('razao_social', 100);
            $table->string('cpf_cnpj', 19)->nullable();
            $table->string('email', 90)->unique();
            $table->string('logo', 150)->nullable();
            $table->uuid('pasta');
            $table->uuid('uuid');
            
            $table->string('configurado', 1)->nullable();
            $table->string('mostrar_pendencia', 1)->default("S")->nullable();
            $table->string('cep', 10)->nullable();
            $table->string('logradouro', 80)->nullable();
            $table->string('numero', 10)->nullable();
            $table->string('bairro', 50)->nullable();
            $table->string('complemento', 80)->nullable();
            $table->char('uf', 2)->nullable();
            $table->string('cidade', 30)->nullable();
            $table->string('fone', 20)->nullable();  
            $table->string('celular', 20)->nullable();
           
            $table->bigInteger('status_id')->nullable()->unsigned();            
            $table->foreign('status_id')->references('id')->on('statuses');
            
            $table->bigInteger('status_assinatura_id')->nullable()->unsigned();
            $table->foreign('status_assinatura_id')->references('id')->on('statuses');
            
            //dados do plano           
            
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
        Schema::dropIfExists('empresas');
    }
}
