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
        Schema::create('anotacao_os', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('os_id')->unsigned();
            $table->foreign('os_id')->references('id')->on('ordem_servicos');
            
            $table->text('anotacao')->nullable();
            $table->date('data')->nullable();
            $table->time('hora')->nullable();
            
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
        Schema::dropIfExists('anotacao_os');
    }
};
