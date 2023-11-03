<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrupoProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grupo_produtos', function (Blueprint $table) {
            $table->id();
            $table->BigInteger("empresa_id")->unsigned();
            $table->foreign("empresa_id")->references("id")->on("empresas");
            $table->string("nome", 60);
            $table->string("ncm", 40)->nullable();
            $table->string("tipo_produto", 60)->nullable();
            $table->string("origem", 40)->nullable();
            
            $table->string("nfce", 40)->nullable();
            $table->decimal("nfce_icms", 10,2)->nullable();
            $table->decimal("nfce_fcp", 10,2)->nullable();
            $table->decimal("nfce_redicms", 10,2)->nullable();
            $table->string("nfce_benefiscal", 20)->nullable();
            $table->string("nfce_mot_deson", 10)->nullable();
            
            $table->string("nfe_st_saida", 10)->nullable();
            $table->string("nfe_st_entrada", 10)->nullable();
            $table->decimal("nfe_icms", 10,2)->nullable();
            $table->decimal("nfe_redicms", 10,2)->nullable();
            $table->boolean("nfe_tem_fcp")->nullable();
            $table->decimal("nfe_fcp", 10,2)->nullable();            
            $table->string("nfe_benefiscal", 20)->nullable();
            $table->string("nfe_mot_deson", 10)->nullable();
            
            $table->string("mva_modbc_icmsst", 10)->nullable();
            $table->decimal("mva", 10,2)->nullable();
            $table->decimal("mva_reducao", 10,2)->nullable();
            
            $table->string("cest", 10)->nullable();
            
            $table->string("ipi_cst_saida", 10)->nullable();
            $table->string("ipi_mod_calc_saida", 10)->nullable();
            $table->decimal("ipi_entrada", 10,2)->nullable();
            
            $table->string("ipi_cst_entrada", 10)->nullable();
            $table->string("ipi_mod_calc_entrada", 10)->nullable();
            $table->decimal("ipi_saida", 10,2)->nullable();
            
            $table->string("cst_pis_confins_saida", 10)->nullable();
            $table->decimal("pis_saida", 10,2)->nullable();
            $table->decimal("cofins_saida", 10,2)->nullable();
            
            $table->string("cst_pis_confins_entrada", 10)->nullable();
            $table->decimal("pis_entrada", 10,2)->nullable();
            $table->decimal("cofins_entrada", 10,2)->nullable();
            
            
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
        Schema::dropIfExists('grupo_produtos');
    }
}
