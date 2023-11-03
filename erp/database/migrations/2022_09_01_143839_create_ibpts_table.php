<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('ibpts', function (Blueprint $table) {
            $table->id();
            $table->string("ncm",15);
            $table->string("uf",2)->nullable();
            $table->integer("ex")->nullable();
            $table->text("descricao")->nullable();
            $table->decimal("nacionalfederal",10,2)->nullable();
            $table->decimal("importadosfederal",10,2)->nullable();
            $table->decimal("estadual",10,2)->nullable();
            $table->decimal("municipal",10,2)->nullable();
            $table->date("vigenciainicio")->nullable();
            $table->date("vigenciafim")->nullable();
            $table->string("chave",15)->nullable();
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
        Schema::dropIfExists('ibpts');
    }
};
