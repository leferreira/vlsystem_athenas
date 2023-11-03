<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_configs', function (Blueprint $table) {
            $table->id();
            $table->string('link_face')->nullable();
            $table->string('link_twiteer')->nullable();
            $table->string('link_google')->nullable();
            $table->string('link_instagram')->nullable();
            $table->string('telefone', 20)->nullable();
            $table->string('endereco', 80)->nullable();
            $table->string('tempo_medio_entrega', 10)->nullable();
            $table->string('tempo_maximo_cancelamento', 10)->nullable();
            $table->decimal('valor_entrega', 10, 2)->nullable();
            $table->string('nome_exibicao_web', 30)->nullable();
            $table->string('latitude', 10)->nullable();
            $table->string('longitude', 10)->nullable();
            $table->string('politica_privacidade', 400)->nullable();
            $table->decimal('valor_km', 10, 2)->nullable();
            $table->integer('entrega_gratis_ate')->nullable();
            $table->integer('maximo_km_entrega')->nullable();
            $table->boolean('usar_bairros')->nullable();
            
            $table->integer('maximo_adicionais')->nullable();
            $table->integer('maximo_adicionais_pizza')->nullable();
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
        Schema::dropIfExists('delivery_configs');
    }
}
