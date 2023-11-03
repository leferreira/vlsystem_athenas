<?php
namespace App\Service;

use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\GradeMovimento;
use App\Models\GradeProduto;
use App\Models\ItemVariacaoGrade;
use App\Models\LojaConfiguracao;
use App\Models\Produto;
use App\Models\SubCategoria;
use App\Models\VariacaoGrade;
use App\Models\Vendedor;
use App\Models\Fornecedor;

class TesteService
{
    public static function gerarLoja(){
        $empresa = auth()->user()->empresa;
        $variacao1 = VariacaoGrade::create(['variacao' => 'Cor']);
            $item1 = ItemVariacaoGrade::Create(["variacao_grade_id" => $variacao1->id,  "valor"=>"Vermelho"]);
            $item2 = ItemVariacaoGrade::Create(["variacao_grade_id" => $variacao1->id,  "valor"=>"Verde"]);

        $variacao2 = VariacaoGrade::create(['variacao' => 'Tamanho']);
            $item4 = ItemVariacaoGrade::Create(["variacao_grade_id" => $variacao2->id,  "valor"=>"37"]);
            $item5 = ItemVariacaoGrade::Create(["variacao_grade_id" => $variacao2->id,  "valor"=>"38"]);
            $item6 = ItemVariacaoGrade::Create(["variacao_grade_id" => $variacao2->id,  "valor"=>"39"]);

        LojaConfiguracao::where("empresa_id", $empresa->id)->update([
            'nome'      => 'Loja do Jailton',
            'link'      => 'mjailton.com.br',
            'logo'      => 'teste/img/logo.png',
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
            'uf' => 'MA',
        ]);

        $cat1 = Categoria::create(['categoria' => 'Camiseta']);
        $sub1 =SubCategoria::create(["categoria_id" =>$cat1->id, 'subcategoria' => 'Algodão']);

        $prod1 = Produto::create([
            'nome'          => 'Camisa Algodão',
            'imagem'        => 'teste/produtos/camisa-vermelha.png',
            'unidade'       => 'UNID',
            'valor_venda'   => 80.00,
            'valor_custo'   => 50.00,
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
            'usa_grade'  => 'S',
            'sku'           => 'CAM001',
            'codigo_barra'  => '7810101000001',
            'gtin'          => 'SEM GTIN',
            'ncm'           => '61091000',
        ]);

         self::gerarGrade($prod1->id, $variacao1->id, $variacao2->id );
         self::inserirEstoqueGrade($prod1->id);



        $prod2 = Produto::create([
            'nome'          => 'Camisa Polo',
            'imagem'        => 'teste/produtos/camisa-azul.png',
            'unidade'       => 'UNID',
            'valor_venda'   => 45.00,
            'valor_custo'   => 50.00,
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
            'usa_grade'  => 'S',
            'sku'           => 'CAM002',
            'codigo_barra'  => '7810101000002',
            'gtin'          => 'SEM GTIN',
            'ncm'           => '61091000',
        ]);

        self::gerarGrade($prod2->id, $variacao1->id, $variacao2->id );
        self::inserirEstoqueGrade($prod2->id);

        $sub2 =SubCategoria::create(["categoria_id" =>$cat1->id, 'subcategoria' => 'T-Shirt']);
        $prod3 = Produto::create([
            'nome'          => 'Camisa TShirt ',
            'imagem'        => 'teste/produtos/camiseta-thirt-01.png',
            'unidade'       => 'UNID',
            'valor_venda'   => 40.00,
            'valor_custo'   => 50.00,
            'estoque_minimo' => 10,
            'estoque_maximo' => 10,
            'estoque_inicial'=> 10,
            'estoque_atual'  => 10,
            "origem"         =>0,
            'tipo_produto_id'=>1,
            'categoria_id'   =>$cat1->id,
            'subcategoria_id'=>$sub2->id,
            'status_id'      =>config("constantes.status.ATIVO"),
            'largura'       =>10,
            'comprimento'   =>15,
            'altura'       =>1,
            'peso_liquido'  =>0.05,
            'peso_bruto'       =>0.05,
            'produto_loja'  => 'S',
            'usa_grade'  => 'S',
            'sku'           => 'CAM003',
            'codigo_barra'  => '7810101000003',
            'gtin'          => 'SEM GTIN',
            'ncm'           => '61091000',
        ]);

        self::gerarGrade($prod3->id, $variacao1->id, $variacao2->id );
        self::inserirEstoqueGrade($prod3->id);

        $sub3 =SubCategoria::create(["categoria_id" =>$cat1->id, 'subcategoria' => 'Longa']);
        $prod4 = Produto::create([
            'nome'          => 'Camisa Manga Longa Feminina ',
            'imagem'        => 'teste/produtos/camisa-manga-longa-femino01.png',
            'unidade'       => 'UNID',
            'valor_venda'   => 90.00,
            'valor_custo'   => 50.00,
            'estoque_minimo' => 10,
            'estoque_maximo' => 10,
            'estoque_inicial'=> 10,
            'estoque_atual'  => 10,
            "origem"         =>0,
            'tipo_produto_id'=>1,
            'categoria_id'   =>$cat1->id,
            'subcategoria_id'=>$sub3->id,
            'status_id'      =>config("constantes.status.ATIVO"),
            'largura'       =>10,
            'comprimento'   =>15,
            'altura'       =>1,
            'peso_liquido'  =>0.05,
            'peso_bruto'       =>0.05,
            'produto_loja'  => 'S',
            'usa_grade'     => 'S',
            'sku'           => 'CAM004',
            'codigo_barra'  => '7810101000004',
            'gtin'          => 'SEM GTIN',
            'ncm'           => '61091000',
        ]);

        self::gerarGrade($prod4->id, $variacao1->id, $variacao2->id );
        self::inserirEstoqueGrade($prod4->id);

        $cat2 = Categoria::create(['categoria' => 'Bermuda']);
        $sub4 =SubCategoria::create(["categoria_id" =>$cat2->id, 'subcategoria' => 'Jeans']);
        $prod5 = Produto::create([
            'nome'          => 'Short Feminino Jeans',
            'imagem'        => 'teste/produtos/short-feminino-jeans-destroyed01.png',
            'unidade'       => 'UNID',
            'valor_venda'   => 90.00,
            'valor_custo'   => 50.00,
            'estoque_minimo' => 10,
            'estoque_maximo' => 10,
            'estoque_inicial'=> 10,
            'estoque_atual'  => 10,
            "origem"         =>0,
            'tipo_produto_id'=>1,
            'categoria_id'   =>$cat2->id,
            'subcategoria_id'=>$sub4->id,
            'status_id'      =>config("constantes.status.ATIVO"),
            'largura'       =>10,
            'comprimento'   =>15,
            'altura'       =>1,
            'peso_liquido'  =>0.05,
            'peso_bruto'       =>0.05,
            'produto_loja'  => 'S',
            'usa_grade'     => 'S',
            'sku'           => 'CAM005',
            'codigo_barra'  => '7810101000005',
            'gtin'          => 'SEM GTIN',
            'ncm'           => '61091000',
        ]);

        self::gerarGrade($prod5->id, $variacao1->id, $variacao2->id );
        self::inserirEstoqueGrade($prod5->id);

        $prod4 = Produto::create([
            'nome'          => 'Short Feminino Jeans - Modelo 02',
            'imagem'        => 'teste/produtos/short-feminino-jeans02.png',
            'unidade'       => 'UNID',
            'valor_venda'   => 90.00,
            'valor_custo'   => 50.00,
            'estoque_minimo' => 10,
            'estoque_maximo' => 10,
            'estoque_inicial'=> 10,
            'estoque_atual'  => 10,
            "origem"         =>0,
            'tipo_produto_id'=>1,
            'categoria_id'   =>$cat2->id,
            'subcategoria_id'=>$sub4->id,
            'status_id'      =>config("constantes.status.ATIVO"),
            'largura'       =>10,
            'comprimento'   =>15,
            'altura'       =>1,
            'peso_liquido'  =>0.05,
            'peso_bruto'       =>0.05,
            'produto_loja'  => 'S',
            'sku'           => 'CAM006',
            'codigo_barra'  => '7810101000007',
            'gtin'          => 'SEM GTIN',
            'ncm'           => '61091000',
        ]);

        $prod4 = Produto::create([
            'nome'          => 'Short Feminino Jeans - Modelo 03',
            'imagem'        => 'teste/produtos/short-feminino-jeans03.png',
            'unidade'       => 'UNID',
            'valor_venda'   => 90.00,
            'valor_custo'   => 50.00,
            'estoque_minimo' => 10,
            'estoque_maximo' => 10,
            'estoque_inicial'=> 10,
            'estoque_atual'  => 10,
            "origem"         =>0,
            'tipo_produto_id'=>1,
            'categoria_id'   =>$cat2->id,
            'subcategoria_id'=>$sub4->id,
            'status_id'      =>config("constantes.status.ATIVO"),
            'largura'       =>10,
            'comprimento'   =>15,
            'altura'       =>1,
            'peso_liquido'  =>0.05,
            'peso_bruto'       =>0.05,
            'produto_loja'  => 'S',
            'gtin'          => 'SEM GTIN',
            'sku'           => 'CAM008',
            'codigo_barra'  => '7810101000008',
            'ncm'           => '61091000',
        ]);

        $sub5 =SubCategoria::create(["categoria_id" =>$cat2->id, 'subcategoria' => 'Social']);
        $prod4 = Produto::create([
            'nome'          => 'Short Feminino Com Sinto',
            'imagem'        => 'teste/produtos/short-feminino-com-sinto.png',
            'unidade'       => 'UNID',
            'valor_venda'   => 90.00,
            'valor_custo'   => 50.00,
            'estoque_minimo' => 10,
            'estoque_maximo' => 10,
            'estoque_inicial'=> 10,
            'estoque_atual'  => 10,
            "origem"         =>0,
            'tipo_produto_id'=>1,
            'categoria_id'   =>$cat2->id,
            'subcategoria_id'=>$sub5->id,
            'status_id'      =>config("constantes.status.ATIVO"),
            'largura'       =>10,
            'comprimento'   =>15,
            'altura'       =>1,
            'peso_liquido'  =>0.05,
            'peso_bruto'       =>0.05,
            'produto_loja'  => 'S',
            'sku'           => 'CAM009',
            'codigo_barra'  => '7810101000009',
            'gtin'          => 'SEM GTIN',
            'ncm'           => '61091000',
        ]);


        $cat3 = Categoria::create(['categoria' => 'Calça']);
        $sub6 =SubCategoria::create(["categoria_id" =>$cat3->id, 'subcategoria' => 'Legging']);
        $prod4 = Produto::create([
            'nome'          => 'Calça Leggin',
            'imagem'        => 'teste/produtos/calca-legging01.png',
            'unidade'       => 'UNID',
            'valor_venda'   => 90.00,
            'valor_custo'   => 50.00,
            'estoque_minimo' => 10,
            'estoque_maximo' => 10,
            'estoque_inicial'=> 10,
            'estoque_atual'  => 10,
            "origem"         =>0,
            'tipo_produto_id'=>1,
            'categoria_id'   =>$cat3->id,
            'subcategoria_id'=>$sub6->id,
            'status_id'      =>config("constantes.status.ATIVO"),
            'largura'       =>10,
            'comprimento'   =>15,
            'altura'       =>1,
            'peso_liquido'  =>0.05,
            'peso_bruto'       =>0.05,
            'produto_loja'  => 'S',
            'sku'           => 'CAM010',
            'codigo_barra'  => '7810101000010',
            'gtin'          => 'SEM GTIN',
            'ncm'           => '61091000',
        ]);

        $sub8 = SubCategoria::create(["categoria_id" =>$cat3->id, 'subcategoria' => 'Social']);
        $prod4 = Produto::create([
            'nome'          => 'Calça Social Feminina',
            'imagem'        => 'teste/produtos/calca-social-feminino01.png',
            'unidade'       => 'UNID',
            'valor_venda'   => 90.00,
            'valor_custo'   => 50.00,
            'estoque_minimo' => 10,
            'estoque_maximo' => 10,
            'estoque_inicial'=> 10,
            'estoque_atual'  => 10,
            "origem"         =>0,
            'tipo_produto_id'=>1,
            'categoria_id'   =>$cat3->id,
            'subcategoria_id'=>$sub8->id,
            'status_id'      =>config("constantes.status.ATIVO"),
            'largura'       =>10,
            'comprimento'   =>15,
            'altura'       =>1,
            'peso_liquido'  =>0.05,
            'peso_bruto'       =>0.05,
            'produto_loja'  => 'S',
            'sku'           => 'CAM011',
            'codigo_barra'  => '7810101000011',
            'gtin'          => 'SEM GTIN',
            'ncm'           => '61091000',
        ]);



        $prod4 = Produto::create([
            'nome'          => 'Calça Social Masculina Cinza',
            'imagem'        => 'teste/produtos/calca-social-masculino-cinza.png',
            'unidade'       => 'UNID',
            'valor_venda'   => 90.00,
            'valor_custo'   => 50.00,
            'estoque_minimo' => 10,
            'estoque_maximo' => 10,
            'estoque_inicial'=> 10,
            'estoque_atual'  => 10,
            "origem"         =>0,
            'tipo_produto_id'=>1,
            'categoria_id'   =>$cat3->id,
            'subcategoria_id'=>$sub8->id,
            'status_id'      =>config("constantes.status.ATIVO"),
            'largura'       =>10,
            'comprimento'   =>15,
            'altura'       =>1,
            'peso_liquido'  =>0.05,
            'peso_bruto'       =>0.05,
            'produto_loja'  => 'S',
            'sku'           => 'CAM012',
            'codigo_barra'  => '7810101000012',
            'gtin'          => 'SEM GTIN',
            'ncm'           => '61091000',
        ]);

        $prod4 = Produto::create([
            'nome'          => 'Calça Social Masculina Creme',
            'imagem'        => 'teste/produtos/calca-social-masculino-creme.png',
            'unidade'       => 'UNID',
            'valor_venda'   => 90.00,
            'valor_custo'   => 50.00,
            'estoque_minimo' => 10,
            'estoque_maximo' => 10,
            'estoque_inicial'=> 10,
            'estoque_atual'  => 10,
            "origem"         =>0,
            'tipo_produto_id'=>1,
            'categoria_id'   =>$cat3->id,
            'subcategoria_id'=>$sub8->id,
            'status_id'      =>config("constantes.status.ATIVO"),
            'largura'       =>10,
            'comprimento'   =>15,
            'altura'       =>1,
            'peso_liquido'  =>0.05,
            'peso_bruto'       =>0.05,
            'produto_loja'  => 'S',
            'sku'           => 'CAM013',
            'codigo_barra'  => '7810101000013',
            'gtin'          => 'SEM GTIN',
            'ncm'           => '61091000',
        ]);

        Cliente::Create([
            'nome_razao_social'  => 'Manoel Jailton',
            'nome_fantasia' => 'mjailton',
            'cpf_cnpj'      => '78589452387',
            'telefone'          => '9899992466',
            'email'         => 'mjailton@gmail.com',
            'senha'         => '123',
            'cep'           => '65074410',
            'logradouro'    => 'Rua José do Patrocínio',
            'numero'        => '09',
            'uf'            => 'MA',
            'cidade'        => 'São Luís',
            'complemento'   => 'qd 20',
            'bairro'        => 'Cohama',
            'tipo_contribuinte'   => '9',
            'ibge'          => '2111300',
            'indFinal'      => '1',
            'password'      =>  md5("1234"),
            'status_id'      => config("constantes.status.ATIVO")
        ]);

        Vendedor::Create([
            'nome'          => 'Carlos',
            'cpf'           => '57517502093',
            'telefone'      => '9899992466',
            'email'         => 'carlos@gmail.com',
            'senha'         => '123',
            'cep'           => '65074410',
            'logradouro'    => 'Rua José do Patrocínio',
            'numero'        => '09',
            'uf'            => 'MA',
            'cidade'        => 'São Luís',
            'complemento'   => 'qd 20',
            'bairro'        => 'Cohama',
            'tipo_contribuinte'   => '9',
            'ibge'          => '2111300',
            'password'          =>  md5("1234"),
            'status_id'      => config("constantes.status.ATIVO")
        ]);

        Vendedor::Create([
            'nome'          => 'Maria',
            'cpf'           => '67951998001',
            'telefone'      => '9899992466',
            'email'         => 'maria@gmail.com',
            'senha'         => '123',
            'cep'           => '65074410',
            'logradouro'    => 'Rua José do Patrocínio',
            'numero'        => '09',
            'uf'            => 'MA',
            'cidade'        => 'São Luís',
            'complemento'   => 'qd 20',
            'bairro'        => 'Cohama',
            'tipo_contribuinte'   => '9',
            'ibge'          => '2111300',
            'password'          =>  md5("1234"),
            'status_id'      => config("constantes.status.ATIVO")
        ]);

        Fornecedor::Create([
            'razao_social'  => 'Fornecedor teste',
            'cnpj'          => '09689284000140',
            'telefone'      => '9899992466',
            'email'         => 'fornecedor@gmail.com',
            'senha'         => '123',
            'cep'           => '65074410',
            'logradouro'    => 'Rua José do Patrocínio',
            'numero'        => '09',
            'uf'            => 'MA',
            'cidade'        => 'São Luís',
            'complemento'   => 'qd 20',
            'bairro'        => 'Cohama',
            'ibge'          => '2111300',
            'password'          =>  md5("1234"),
            'status_id'      => config("constantes.status.ATIVO")
        ]);
    }

    public static function gerarGrade($produto_id, $variacao_linha_id, $variacao_coluna_id ){
        $linhas = ItemVariacaoGrade::where("variacao_grade_id", $variacao_linha_id)->get();
        foreach($linhas as $l){
            $colunas = ItemVariacaoGrade::where("variacao_grade_id", $variacao_coluna_id)->get();
            foreach($colunas as $c){

                $grade = new \stdClass();
                $grade->produto_id              = $produto_id;
                $grade->descricao               = $l->valor ." / " .$c->valor ;
                $grade->variacao_grade_linha_id = $l->variacao_grade_id;
                $grade->linha_id                = $l->id;
                $grade->variacao_grade_coluna_id= $c->variacao_grade_id;
                $grade->coluna_id               = $c->id;
                $grade->estoque                 = 0;
                $grade->codigo_barra            = zeroEsquerda($grade->produto_id, 5) . zeroEsquerda($grade->linha_id, 3)  . zeroEsquerda($grade->coluna_id, 3);
                GradeProduto::Create(objToArray($grade));
            }
        }
    }



    public static function inserirEstoqueGrade($produto_id){
            $produto        = Produto::find($produto_id);
            $grades         = GradeProduto::where("produto_id", $produto_id)->get();
            for($i=0; $i<2; $i++){
                $grade = $grades[$i];
                $mov                    = new \stdClass();
                $mov->tipo_movimento_id = config("constantes.tipo_movimento.ENTRADA_INICIO_ESTOQUE");
                $mov->produto_id        = $produto->id;
                $mov->grade_id          = $grade->id;
                $mov->ent_sai           = 'E';
                $mov->estorno           = 'N';
                $mov->data_movimento    = hoje();
                $mov->qtde_movimento    = 5;
                $mov->descricao         = "Início de Estoque - Cadastro Produto";
                if($mov->qtde_movimento > 0){
                    GradeMovimento::Create(objToArray($mov));
                }
            }




    }
}

