<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGestaoProspectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gestao_prospectos', function (Blueprint $table) {
            $table->id();
            $table->string('nome',80);
            $table->string('email',80);
            $table->string('senha',80);
            $table->string('celular',80);
            $table->string('conheceu',80);            
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
        Schema::dropIfExists('gestao_prospectos');
    }
}
