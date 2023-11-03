<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEadMatriculasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ead_matriculas', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas'); 
            
            $table->bigInteger('curso_id')->nullable()->unsigned();
            $table->foreign('curso_id')->references('id')->on('ead_cursos');
            
            $table->bigInteger('aluno_id')->nullable()->unsigned();
            $table->foreign('aluno_id')->references('id')->on('ead_alunos');
            
            $table->date('data_matricula')->nullable();
            $table->time('hora_matricula')->nullable();
            
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
        Schema::dropIfExists('ead_matriculas');
    }
}
