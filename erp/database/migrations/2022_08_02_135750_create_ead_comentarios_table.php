<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEadComentariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ead_comentarios', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('curso_id')->nullable()->unsigned();
            $table->foreign('curso_id')->references('id')->on('ead_cursos');
            
            $table->bigInteger('aula_id')->nullable()->unsigned();
            $table->foreign('aula_id')->references('id')->on('ead_aulas');
            
            $table->bigInteger('aluno_id')->nullable()->unsigned();
            $table->foreign('aluno_id')->references('id')->on('ead_alunos');
            
            $table->text('comentario');
            $table->date('data')->nullable();
            $table->time('hora')->nullable();
            
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
        Schema::dropIfExists('ead_comentarios');
    }
}
