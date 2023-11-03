<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubcategoriaTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->BigInteger('subcategoria_id')->nullable()->unsigned()->after('categoria_id');
            $table->foreign('subcategoria_id')->references('id')->on('sub_categorias');
            
            $table->BigInteger('subsubcategoria_id')->nullable()->unsigned()->after('subcategoria_id');
            $table->foreign('subsubcategoria_id')->references('id')->on('sub_sub_categorias');
            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->dropColumn('subcategoria_id');
            $table->dropColumn('subsubcategoria_id');
        });
    }
}
