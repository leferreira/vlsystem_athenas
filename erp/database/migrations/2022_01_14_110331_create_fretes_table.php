<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFretesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fretes', function (Blueprint $table) {
            $table->id();
            $table->string('placa', 9)->nullable();
            $table->string('uf', 2)->nullable();
            $table->decimal('valor', 10, 2);
            $table->integer('modfrete');
            $table->integer('qtdVolumes')->nullable();
            $table->string('numeracaoVolumes', 20)->nullable();
            $table->string('especie', 20)->nullable();
            $table->decimal('peso_liquido', 8, 3)->nullable();
            $table->decimal('peso_bruto', 8, 3)->nullable();
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
        Schema::dropIfExists('fretes');
    }
}
