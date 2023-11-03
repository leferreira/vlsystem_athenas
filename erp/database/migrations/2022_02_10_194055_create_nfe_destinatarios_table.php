<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNfeDestinatariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nfe_destinatarios', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('nfe_id')->unique()->unsigned();
            $table->foreign('nfe_id')->references('id')->on('nves');
            
            $table->string('dest_xNome',60)->nullable();
            $table->string('dest_IE',14)->nullable();
            $table->string('dest_indIEDest',20)->nullable();
            $table->string('dest_ISUF',20)->nullable();
            $table->string('dest_IM',15)->nullable();
            $table->string('dest_email',60)->nullable();
            $table->string('dest_CNPJ',14)->nullable();
            $table->string('dest_CPF',15)->nullable();
            $table->string('dest_idEstrangeiro',20)->nullable();
            $table->string('dest_xLgr',60)->nullable();
            $table->string('dest_nro',60)->nullable();
            $table->string('dest_xCpl',60)->nullable();
            $table->string('dest_xBairro',60)->nullable();
            $table->string('dest_cMun',20)->nullable();
            $table->string('dest_xMun',60)->nullable();
            $table->string('dest_UF',2)->nullable();
            $table->string('dest_CEP',8)->nullable();
            $table->string('dest_cPais',20)->nullable();
            $table->string('dest_xPais',60)->nullable();
            $table->string('dest_fone',14)->nullable();
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
        Schema::dropIfExists('nfe_destinatarios');
    }
}
