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
        Schema::create('termo_garantias', function (Blueprint $table) {
            $table->id();
            $table->date("data_garantia")->nullable();
            $table->string("referencia_garantia", 45)->nullable();
            $table->text("texto_garantia")->nullable();
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
        Schema::dropIfExists('termo_garantias');
    }
};
