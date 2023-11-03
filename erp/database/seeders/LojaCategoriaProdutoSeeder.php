<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LojaCategoriaProduto;

class LojaCategoriaProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LojaCategoriaProduto::create(['empresa_id'=>1, 'nome' => 'Camisetas']);
        LojaCategoriaProduto::create(['empresa_id'=>1, 'categoria_pai'=>1, 'nome' => 'Polo']);
        LojaCategoriaProduto::create(['empresa_id'=>1, 'categoria_pai'=>1, 'nome' => 'Regata']);
        LojaCategoriaProduto::create(['empresa_id'=>1,'categoria_pai'=>1, 'nome' => 'Baby Look']);
        LojaCategoriaProduto::create(['empresa_id'=>1,'categoria_pai'=>1, 'nome' => 'T-Shirt']);
        
        LojaCategoriaProduto::create(['empresa_id'=>1,'nome' => 'Camisas']);
        LojaCategoriaProduto::create(['empresa_id'=>1,'categoria_pai'=>6, 'nome' => 'Social']);
        LojaCategoriaProduto::create(['empresa_id'=>1,'categoria_pai'=>6, 'nome' => 'Xadrez']);
        LojaCategoriaProduto::create(['empresa_id'=>1,'categoria_pai'=>6, 'nome' => 'Esporte']);
        LojaCategoriaProduto::create(['empresa_id'=>1,'categoria_pai'=>6, 'nome' => 'Com Gola']);
        LojaCategoriaProduto::create(['empresa_id'=>1,'categoria_pai'=>6, 'nome' => 'Moleton']);
        
        LojaCategoriaProduto::create(['empresa_id'=>1,'nome' => 'Calças']);
        LojaCategoriaProduto::create(['empresa_id'=>1,'categoria_pai'=>12, 'nome' => 'Social']);
        LojaCategoriaProduto::create(['empresa_id'=>1,'categoria_pai'=>12, 'nome' => 'Esporte']);
        LojaCategoriaProduto::create(['empresa_id'=>1,'categoria_pai'=>12, 'nome' => 'Jeans']);
        LojaCategoriaProduto::create(['empresa_id'=>1,'categoria_pai'=>12, 'nome' => 'Tactel']);
        LojaCategoriaProduto::create(['empresa_id'=>1,'categoria_pai'=>12, 'nome' => 'Legging']);
        
        LojaCategoriaProduto::create(['empresa_id'=>1,'nome' => 'Bermudas']);
        LojaCategoriaProduto::create(['empresa_id'=>1,'categoria_pai'=>18, 'nome' => 'Saruel']);
        LojaCategoriaProduto::create(['empresa_id'=>1,'categoria_pai'=>18, 'nome' => 'Esporte']);
        LojaCategoriaProduto::create(['empresa_id'=>1,'categoria_pai'=>18, 'nome' => 'Jeans']);
        LojaCategoriaProduto::create(['empresa_id'=>1,'categoria_pai'=>18, 'nome' => 'Tactel']);
        LojaCategoriaProduto::create(['empresa_id'=>1,'categoria_pai'=>18, 'nome' => 'Legging']);
    }
}
