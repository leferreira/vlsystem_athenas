<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanosTable extends Migration
{
 
    public function up()
    {
        Schema::create('planos', function (Blueprint $table) {
            $table->id();
            $table->string("nome", 80);
            $table->string('url')->unique();
            $table->integer("limite_usuario")->default(1); 
            $table->string('descricao')->nullable();
            $table->integer("limite_nfe")->default(1);
            $table->integer("limite_nfce")->default(1);
            $table->integer("limite_pdv")->default(1);
            $table->decimal("valor_setup", 10,2)->nullable()->default(0);
            
            $table->String("destaque",1)->nullable()->default("N"); 
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
        Schema::dropIfExists('planos');
    }
}
