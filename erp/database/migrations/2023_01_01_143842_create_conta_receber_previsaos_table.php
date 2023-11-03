<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conta_receber_previsaos', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('conta_receber_id')->unsigned()->nullable();
            $table->foreign("conta_receber_id")->references("id")->on("fin_conta_recebers");
            
            $table->date('data_previsao')->nullable();
            $table->string('historico',120)->nullable();
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
        Schema::dropIfExists('conta_receber_previsaos');
    }
};
