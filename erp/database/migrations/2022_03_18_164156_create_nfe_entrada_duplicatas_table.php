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
        Schema::create('nfe_entrada_duplicatas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nfe_id')->unsigned();
            $table->foreign('nfe_id')->references('id')->on('nfe_entradas');
            $table->string('nDup',50)->nullable();
            $table->date('dVenc')->nullable();
            $table->decimal('vDup',10,2)->nullable();
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
        Schema::dropIfExists('nfe_entrada_duplicatas');
    }
};
