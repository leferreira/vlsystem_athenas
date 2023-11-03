<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLojaItemPacotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loja_item_pacotes', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('produto_id')->nullable()->unsigned();
            $table->foreign('produto_id')->references('id')->on('produtos');
            
            $table->BigInteger('loja_pacote_id')->nullable()->unsigned();
            $table->foreign('loja_pacote_id')->references('id')->on('loja_pacotes');
            
            $table->decimal('quantidade', 5, 2);
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
        Schema::dropIfExists('loja_item_pacotes');
    }
}
