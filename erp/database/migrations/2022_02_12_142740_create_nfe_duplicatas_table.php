<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNfeDuplicatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nfe_duplicatas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nfe_id')->unsigned();
            $table->foreign('nfe_id')->references('id')->on('nves');
            $table->string('tPag',5)->nullable();
            $table->string('indPag',1)->nullable();
            $table->string('nDup',50);
            $table->date('dVenc');
            $table->decimal('vDup',10,2)->nullable();
            $table->string('obs',80)->nullable();
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
        Schema::dropIfExists('nfe_duplicatas');
    }
}
