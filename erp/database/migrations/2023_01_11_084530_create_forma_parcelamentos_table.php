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
        Schema::create('forma_parcelamentos', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('administradora_cartao_id')->unsigned();
            $table->foreign('administradora_cartao_id')->references('id')->on('administradora_cartaos');
            
            $table->bigInteger('tipo_parcelamento_id')->unsigned();
            $table->foreign('tipo_parcelamento_id')->references('id')->on('tipo_parcelamentos');
            
            $table->integer("parcela_de");
            $table->integer("parcela_ate");
            
            $table->decimal("taxa", 10,2);
            $table->decimal("acrescimo", 10,2)->nullable();
            $table->decimal("desconto", 10,2)->nullable();
            $table->decimal("valor_minimo", 10,2)->nullable();
            
            
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
        Schema::dropIfExists('forma_parcelamentos');
    }
};
