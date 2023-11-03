<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNfeAutorizadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nfe_autorizados', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('nfe_id')->unsigned();
            $table->foreign('nfe_id')->references('id')->on('nves');            
            
            $table->string('aut_contato',50)->nullable();
            $table->string('aut_cnpj',20);
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
        Schema::dropIfExists('nfe_autorizados');
    }
}
