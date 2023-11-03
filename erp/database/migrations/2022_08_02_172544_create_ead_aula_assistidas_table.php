<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEadAulaAssistidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ead_aula_assistidas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');
            
            $table->bigInteger('aula_id')->nullable()->unsigned();
            $table->foreign('aula_id')->references('id')->on('ead_aulas');
            
            $table->bigInteger('curso_id')->nullable()->unsigned();
            $table->foreign('curso_id')->references('id')->on('ead_cursos');
            
            $table->bigInteger('aluno_id')->nullable()->unsigned();
            $table->foreign('aluno_id')->references('id')->on('ead_alunos');
            
            $table->date('data_assitida')->nullable();
            $table->time('hora_assistida')->nullable();
            
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
        Schema::dropIfExists('ead_aula_assistidas');
    }
}
