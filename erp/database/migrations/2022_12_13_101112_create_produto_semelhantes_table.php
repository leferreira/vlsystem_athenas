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
        Schema::create('produto_semelhantes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('produto_principal_id')->unsigned()->nullable();
            $table->foreign('produto_principal_id')->references('id')->on('produtos');  
            
            $table->bigInteger('produto_semelhante_id')->unsigned()->nullable();
            $table->foreign('produto_semelhante_id')->references('id')->on('produtos'); 
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
        Schema::dropIfExists('produto_semelhantes');
    }
};
