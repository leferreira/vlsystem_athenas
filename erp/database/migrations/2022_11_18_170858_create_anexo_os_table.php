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
        Schema::create('anexo_os', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('os_id')->unsigned();
            $table->foreign('os_id')->references('id')->on('ordem_servicos');
            
            $table->string('anexo', 150)->nullable();
            $table->string('url', 150)->nullable();
            $table->string('path', 150)->nullable();
            $table->string('thumb', 150)->nullable();
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
        Schema::dropIfExists('anexo_os');
    }
};
