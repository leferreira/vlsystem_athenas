<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNfeTransportesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nfe_transportes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nfe_id')->unique()->unsigned();
            $table->foreign('nfe_id')->references('id')->on('nves');
            $table->integer('modFrete')->nullable();
            $table->string('transp_xNome',100);
            $table->string('transp_IE',20)->nullable();
            $table->string('transp_xEnder',100);
            $table->string('transp_xMun',100);
            $table->string('transp_UF',2);
            $table->string('transp_CNPJ',20)->nullable();
            $table->string('transp_CPF',20)->nullable();
            $table->string('transp_vagao',20)->nullable();
            $table->string('transp_balsa',20)->nullable();            
            $table->string('transp_placa',100)->nullable();
            $table->string('UF_placa',20)->nullable();
            $table->string('RNTC',100)->nullable();          
            
            $table->integer('qVol')->nullable();
            $table->string('esp',40)->nullable();
            $table->string('marca',40)->nullable();
            $table->string('nVol',40)->nullable();
            $table->string('pesoL',40)->nullable();
            $table->string('pesoB',40)->nullable();
            $table->string('nLacre',40)->nullable();
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
        Schema::dropIfExists('nfe_transportes');
    }
}
