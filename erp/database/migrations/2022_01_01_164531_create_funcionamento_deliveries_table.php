<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuncionamentoDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionamento_deliveries', function (Blueprint $table) {
            $table->id();
            $table->boolean('ativo');
            $table->string('dia');
            $table->string('inicio_expediente', 5);
            $table->string('fim_expediente', 5);
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
        Schema::dropIfExists('funcionamento_deliveries');
    }
}
