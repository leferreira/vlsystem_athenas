<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEadCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ead_cursos', function (Blueprint $table) {
            $table->id();
            
            $table->string('curso', 100);
            $table->string('imagem', 120)->nullable();
            $table->string('duracao', 20)->nullable();
            $table->string('mercadopago', 100)->nullable();
            $table->string('pagseguro', 100)->nullable();
            $table->string("slug", 20) ;
            $table->string("foto", 95)->nullable() ;
            $table->text("descricao")->nullable() ;
            $table->decimal("valor", 10,2) ;
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
        Schema::dropIfExists('ead_cursos');
    }
}
