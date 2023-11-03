<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNfeReferenciadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nfe_referenciados', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('nfe_id')->unsigned();
            $table->foreign('nfe_id')->references('id')->on('nves');
            
            $table->string('tipo_nota_referenciada',10)->nullable();
            $table->string('ref_NFe',50)->nullable();
            $table->string('ref_ano_mes',10)->nullable();
            $table->string('ref_num_nf',50)->nullable();
            $table->string('ref_serie',10)->nullable(); 
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
        Schema::dropIfExists('nfe_referenciados');
    }
}
