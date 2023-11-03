<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEadAulasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ead_aulas', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('curso_id')->unsigned();
            $table->foreign('curso_id')->references('id')->on('ead_cursos');
            $table->string('titulo', 90);
            $table->string('embed', 20)->nullable();
            $table->string('duracao', 20)->nullable();
            $table->string("slug", 20) ;
            $table->date("data_cadastro");
            
            $table->bigInteger('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas'); 
            
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
        Schema::dropIfExists('ead_aulas');
    }
}
