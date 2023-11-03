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
        Schema::create('nfce_referenciados', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nfce_id')->unsigned();
            $table->foreign('nfce_id')->references('id')->on('nfces');
            
            $table->string('chave',50)->nullable();
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
        Schema::dropIfExists('nfce_referenciados');
    }
};
