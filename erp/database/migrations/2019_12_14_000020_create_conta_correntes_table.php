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
        Schema::create('conta_correntes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("banco_id")->unsigned();
            $table->foreign("banco_id")->references("id")->on("bancos");
            
            $table->bigInteger('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            
            $table->bigInteger('tipo_conta_corrente_id')->unsigned();
            $table->foreign('tipo_conta_corrente_id')->references('id')->on('tipo_conta_correntes');
            
            $table->string("descricao", 100);
            $table->string("agencia", 20);
            $table->string("conta", 40);
            $table->string("pix", 100)->nullable();
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
        Schema::dropIfExists('conta_correntes');
    }
};
