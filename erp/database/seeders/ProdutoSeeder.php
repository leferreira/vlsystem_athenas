<?php

namespace Database\Seeders;

use App\Models\Produto;
use Illuminate\Database\Seeder;

class ProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Produto::create([        
        'nome'          => 'Camisa algodão - masculina',            
        'imagem'        => 'camisa-vermelha.png',
        'empresa_id'    => 1,
        'tributacao_id' => 1,        
        'unidade'       => 'UNID',
            
        'valor_venda'   => 100.00,
        'valor_custo'   => 100.00,
        'custo_medio'   => 100.00,
        
        'estoque_minimo' => 10,
        'estoque_maximo' => 10,
        'estoque_inicial'=> 10,
        'estoque_atual'  => 10,
         
         'gtin'          => 'SEM GTIN',
         'ncm'           => '85167910',
         'cfop'          => '5102'
       ]);
        
        Produto::create([
            'nome'          => 'Short Jeans destroyed feminino',
            'imagem'        => 'short-feminino-jeans-destroyed01.png',
            'tributacao_id' => 1,
            'empresa_id'    => 1,
            'unidade'       => 'UNID',
            
            'valor_venda'   => 100.00,
            'valor_custo'   => 100.00,
            'custo_medio'   => 100.00,
            
            'estoque_minimo' => 10,
            'estoque_maximo' => 10,
            'estoque_inicial'=> 10,
            'estoque_atual'  => 10,
            
            'gtin'          => 'SEM GTIN',
            'ncm'           => '85167910',
            'cfop'          => '5102'
        ]);
        
        Produto::create([
            'nome'          => 'Calça legging',
            'imagem'        => 'calca-legging01.png',
            'tributacao_id' => 1,
            'empresa_id'    => 1,
            'unidade'       => 'UNID',
            
            'valor_venda'   => 100.00,
            'valor_custo'   => 100.00,
            'custo_medio'   => 100.00,
            
            'estoque_minimo' => 10,
            'estoque_maximo' => 10,
            'estoque_inicial'=> 10,
            'estoque_atual'  => 10,
            
            'gtin'          => 'SEM GTIN',
            'ncm'           => '85167910',
            'cfop'          => '5102'
        ]);
        
        Produto::create([
            'nome'          => 'Calça social feminino',
            'imagem'        => 'calca-social-feminino01.png',
            'tributacao_id' => 1,
            'empresa_id'    => 1,
            'unidade'       => 'UNID',
            
            'valor_venda'   => 100.00,
            'valor_custo'   => 100.00,
            'custo_medio'   => 100.00,
            
            'estoque_minimo' => 10,
            'estoque_maximo' => 10,
            'estoque_inicial'=> 10,
            'estoque_atual'  => 10,
            
            'gtin'          => 'SEM GTIN',
            'ncm'           => '85167910',
            'cfop'          => '5102'
        ]);
        
        Produto::create([
            'nome'          => 'Calça social masculino',
            'imagem'        => 'camisa-vermelha.png',
            'tributacao_id' => 1,
            'empresa_id'    => 1,
            'unidade'       => 'UNID',
            
            'valor_venda'   => 100.00,
            'valor_custo'   => 100.00,
            'custo_medio'   => 100.00,
            
            'estoque_minimo' => 10,
            'estoque_maximo' => 10,
            'estoque_inicial'=> 10,
            'estoque_atual'  => 10,
            
            'gtin'          => 'SEM GTIN',
            'ncm'           => '85167910',
            'cfop'          => '5102'
        ]);
        
        
        Produto::create([
            'nome'          => 'Conjunto academia feminino',
            'imagem'        => 'conjunto-academia-feminino.png',
            'tributacao_id' => 1,
            'empresa_id'    => 1,
            'unidade'       => 'UNID',
            
            'valor_venda'   => 100.00,
            'valor_custo'   => 100.00,
            'custo_medio'   => 100.00,
            
            'estoque_minimo' => 10,
            'estoque_maximo' => 10,
            'estoque_inicial'=> 10,
            'estoque_atual'  => 10,
            
            'gtin'          => 'SEM GTIN',
            'ncm'           => '85167910',
            'cfop'          => '5102'
        ]);
        
        Produto::create([
            'nome'          => 'Equipagem futebol',
            'imagem'        => 'equipagem-futebol-roxo.png',
            'tributacao_id' => 1,
            'empresa_id'    => 1,
            'unidade'       => 'UNID',
            
            'valor_venda'   => 100.00,
            'valor_custo'   => 100.00,
            'custo_medio'   => 100.00,
            
            'estoque_minimo' => 10,
            'estoque_maximo' => 10,
            'estoque_inicial'=> 10,
            'estoque_atual'  => 10,
            
            'gtin'          => 'SEM GTIN',
            'ncm'           => '85167910',
            'cfop'          => '5102'
        ]);
        
        Produto::create([
            'nome'          => 'Pizza',
            'imagem'        => 'pizza2.png',
            'tributacao_id' => 1,
            'empresa_id'    => 1,
            'unidade'       => 'UNID',
            
            'valor_venda'   => 26.00,
            'valor_custo'   => 26.00,
            'custo_medio'   => 26.00,
            
            'estoque_minimo' => 10,
            'estoque_maximo' => 10,
            'estoque_inicial'=> 10,
            'estoque_atual'  => 10,
            
            'gtin'          => 'SEM GTIN',
            'ncm'           => '85167910',
            'cfop'          => '5102'
        ]);
        
        Produto::create([
            'nome'          => 'Hamburguer',
            'imagem'        => 'Hamburguer.png',
            'tributacao_id' => 1,
            'empresa_id'    => 1,
            'unidade'       => 'UNID',
            
            'valor_venda'   => 26.00,
            'valor_custo'   => 26.00,
            'custo_medio'   => 26.00,
            
            'estoque_minimo' => 10,
            'estoque_maximo' => 10,
            'estoque_inicial'=> 10,
            'estoque_atual'  => 10,
            
            'gtin'          => 'SEM GTIN',
            'ncm'           => '85167910',
            'cfop'          => '5102'
        ]);
    }
}
