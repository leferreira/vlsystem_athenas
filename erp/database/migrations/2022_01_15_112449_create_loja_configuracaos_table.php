<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLojaConfiguracaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loja_configuracaos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresa_id')->unsigned();
            
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->string('nome', 100)->nullable();
            $table->string('link', 100)->nullable();
            $table->string('logo', 200)->nullable();
            $table->string('rua', 100)->nullable();
            $table->string('numero', 10)->nullable();
            $table->string('bairro', 100)->nullable();
            $table->string('cidade', 100)->nullable();
            $table->string('uf', 2)->nullable();
            $table->string('url', 150)->nullable();
            
            $table->string('cep', 20)->nullable();
            $table->string('telefone', 25)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('link_facebook', 120)->nullable();
            $table->string('link_twiter', 120)->nullable();
            $table->string('link_instagram', 120)->nullable();
            $table->decimal('frete_gratis_valor', 10, 2)->nullable();
            $table->string('funcionamento', 120)->nullable();
            $table->string('latitude', 10)->nullable();
            $table->string('longitude', 10)->nullable();
            $table->text('politica_privacidade')->nullable();
            $table->text('src_mapa')->nullable();
            $table->string('cor_principal', 8)->nullable();
            $table->string('tema_ecommerce', 30)->nullable();
            $table->string('token', 30)->nullable();
            
            $table->string('google_api', 40)->nullable()->default('');
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
        Schema::dropIfExists('loja_configuracaos');
    }
}
