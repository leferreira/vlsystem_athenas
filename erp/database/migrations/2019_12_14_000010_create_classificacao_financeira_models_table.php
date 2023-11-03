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
        Schema::create('classificacao_financeira_models', function (Blueprint $table) {
            $table->id();
            $table->integer("empresa_id")->nullable();
            $table->string("codigo",20);
            $table->string("descricao", 80);
            $table->string("titulo_grupo", 1)->nullable();
            $table->string("ativo", 1)->nullable();
            $table->string("receita_despesa")->nullable();
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
        Schema::dropIfExists('classificacao_financeira_models');
    }
};
