<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplementoDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complemento_deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 50);
            $table->decimal('valor', 10, 2);
            
            $table->BigInteger('categoria_id')->nullable()->unsigned();
            $table->foreign('categoria_id')->references('id')->on('categoria_adicionals')->onDelete('cascade');
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
        Schema::dropIfExists('complemento_deliveries');
    }
}
