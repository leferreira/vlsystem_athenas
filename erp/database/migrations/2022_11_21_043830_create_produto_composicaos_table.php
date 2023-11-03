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
        Schema::create('produto_composicaos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("produto_pai_id")->unsigned();
            $table->foreign("produto_pai_id")->references("id")->on("produtos");
            
            $table->bigInteger("produto_filho_id")->unsigned();
            $table->foreign("produto_filho_id")->references("id")->on("produtos");
            
            $table->decimal("qtde",10,2);
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('produto_composicaos');
    }
};
