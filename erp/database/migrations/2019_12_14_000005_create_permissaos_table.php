<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissaos', function (Blueprint $table) {
            $table->id();
            /*$table->bigInteger('modulo_id')->nullable()->unsigned();
            $table->foreign('modulo_id')->references('id')->on('modulos');*/
            $table->string('tipo', 20)->nullable();
            $table->string('permissao', 90);
            $table->text('descricao', 100);
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
        Schema::dropIfExists('permissaos');
    }
}
