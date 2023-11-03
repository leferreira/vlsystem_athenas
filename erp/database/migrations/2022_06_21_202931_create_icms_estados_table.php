<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIcmsEstadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icms_estados', function (Blueprint $table) {
            $table->id();
            $table->string("uf_origem",10)->nullable();
            $table->string("uf_destino",10)->nullable();
            $table->decimal("aliquota_origem",10,2)->nullable();
            $table->decimal("aliquota_destino",10,2)->nullable();
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
        Schema::dropIfExists('icms_estados');
    }
}
