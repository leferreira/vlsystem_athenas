<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Empresa;
use App\Models\LojaConfiguracao;
use App\Models\Produto;
use App\Models\SubCategoria;
use Illuminate\Database\Seeder;

class TesteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $empresa = Empresa::where("email", "mjailton@gmail.com")->first();       
        LojaConfiguracao::create([
            'empresa_id'=> $empresa->id,
            'nome'      => 'Loja do Jailton',
            'link'      => 'mjailton.com.br',
            'rua'       => 'Rua 10',
            'numero'    => 10,
            'bairro'    => 'Cohaserma',
            'cidade'    => 'São Luís',
            'cep'       => '65072240',
            'telefone'  => '9999999999',
            'email'     => 'mjailton@gmail.com',
            'link_facebook' => '',
            'link_twiter' => '',
            'link_instagram' => '',
            'frete_gratis_valor' => 0,
            'mercadopago_public_key' => '',
            'mercadopago_access_token' => '',
            'uf' => 'MA',
        ]);
        
        $cat1 = Categoria::create(['categoria' => 'Camiseta', 'empresa_id'=>$empresa->id]);
            $sub1 =SubCategoria::create(["categoria_id" =>$cat1->id, 'subcategoria' => 'POLO', 'empresa_id'=>$empresa->id]);
            
           $prod1 = Produto::create([
                'nome'          => 'Camisa Vermelha - Algodão',
                'imagem'        => 'camisa-vermelha.png',
                'empresa_id'    => $empresa->id,                
                'unidade'       => 'UNID',
                
                'valor_venda'   => 80.00,
                'valor_custo'   => 500.00,
                
                'estoque_minimo' => 10,
                'estoque_maximo' => 10,
                'estoque_inicial'=> 10,
                'estoque_atual'  => 10,
                "origem"         =>0,
                'tipo_produto_id'=>1,
                'categoria_id'   =>$cat1->id,
                'subcategoria_id'=>$sub1->id,
                'status_id'      =>config("constantes.status.ATIVO"),
                'largura'       =>10,
                'comprimento'   =>15,
                'altura'       =>1,
                'peso_liquido'  =>0.05,
                'peso_bruto'       =>0.05,
                'produto_loja'  => 'S',
                'gtin'          => 'SEM GTIN',
                'ncm'           => '61091000',
            ]);
            
            $sub2 =SubCategoria::create(["categoria_id" =>$cat1->id, 'subcategoria' => 'Regata', 'empresa_id'=>$empresa->id]);
            $sub3 =SubCategoria::create(["categoria_id" =>$cat1->id, 'subcategoria' => 'Baby Look', 'empresa_id'=>$empresa->id]);
        
            $cat2 = Categoria::create(['categoria' => 'Camisa', 'empresa_id'=>$empresa->id]);
            $sub4 =SubCategoria::create(["categoria_id" =>$cat2->id, 'subcategoria' => 'Social', 'empresa_id'=>$empresa->id]);
            $sub5 =SubCategoria::create(["categoria_id" =>$cat2->id, 'subcategoria' => 'Xadrez', 'empresa_id'=>$empresa->id]);
            $sub6 =SubCategoria::create(["categoria_id" =>$cat2->id, 'subcategoria' => 'Esporte', 'empresa_id'=>$empresa->id]);
        
       $cat3 = Categoria::create(['categoria' => 'Bermuda', 'empresa_id'=>$empresa->id]);
            $sub7 =SubCategoria::create(["categoria_id" =>$cat3->id, 'subcategoria' => 'Saruel', 'empresa_id'=>$empresa->id]);
            $sub8 = SubCategoria::create(["categoria_id" =>$cat3->id, 'subcategoria' => 'Esporte', 'empresa_id'=>$empresa->id]);
            $sub9 =SubCategoria::create(["categoria_id" =>$cat3->id, 'subcategoria' => 'Jeans', 'empresa_id'=>$empresa->id]);
            
       $cat4 = Categoria::create(['categoria' => 'Calça', 'empresa_id'=>$empresa->id]);
            $sub10 = SubCategoria::create(["categoria_id" =>$cat4->id, 'subcategoria' => 'Legging', 'empresa_id'=>$empresa->id]);
            $sub11 =SubCategoria::create(["categoria_id" =>$cat4->id, 'subcategoria' => 'Social', 'empresa_id'=>$empresa->id]);
            $sub12 =SubCategoria::create(["categoria_id" =>$cat4->id, 'subcategoria' => 'Jeans', 'empresa_id'=>$empresa->id]);            
       
           
        
    }
}
