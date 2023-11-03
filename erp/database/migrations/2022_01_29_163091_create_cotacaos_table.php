<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotacaos', function (Blueprint $table) {
            $table->id();
            $table->BigInteger("status_cotacao_id")->unsigned()->default(1);
            $table->date("data_abertura");
            $table->date("data_encerramento")->nullable();
            
            $table->foreign("status_cotacao_id")->references("id")->on("status_cotacaos");
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
        Schema::dropIfExists('cotacaos');
    }
}
