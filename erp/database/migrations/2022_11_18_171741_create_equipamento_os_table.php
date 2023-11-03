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
        Schema::create('equipamento_os', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('os_id')->unsigned();
            $table->foreign('os_id')->references('id')->on('ordem_servicos');
            
            $table->bigInteger('equipamento_id')->unsigned();
            $table->foreign('equipamento_id')->references('id')->on('equipamentos');
            
            $table->text('defeito_declarado')->nullable();
            $table->text('defeito_encontrado', 150)->nullable();
            $table->text('solucao')->nullable();
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
        Schema::dropIfExists('equipamento_os');
    }
};
