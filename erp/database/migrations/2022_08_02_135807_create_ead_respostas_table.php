<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEadRespostasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ead_respostas', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('comentario_id')->nullable()->unsigned();
            $table->foreign('comentario_id')->references('id')->on('ead_comentarios');
            
            $table->bigInteger('aluno_id')->nullable()->unsigned();
            $table->foreign('aluno_id')->references('id')->on('ead_alunos');
            
            $table->bigInteger('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            
            $table->text('resposta');
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
        Schema::dropIfExists('ead_respostas');
    }
}
