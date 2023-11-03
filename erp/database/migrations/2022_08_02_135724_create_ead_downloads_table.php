<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEadDownloadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ead_downloads', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('curso_id')->nullable()->unsigned();
            $table->foreign('curso_id')->references('id')->on('ead_alunos');
            
            $table->bigInteger('aula_id')->nullable()->unsigned();
            $table->foreign('aula_id')->references('id')->on('ead_aulas');
            
            $table->string('titulo', 90)->nullable();
            $table->string('path', 90)->nullable();
            $table->string('duracao', 20)->nullable();
            
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
        Schema::dropIfExists('ead_downloads');
    }
}
