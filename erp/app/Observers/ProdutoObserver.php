<?php

namespace App\Observers;

use App\Models\Produto;
use App\Models\TabelaPreco;
use App\Models\TabelaPrecoProduto;
use App\Service\MovimentoService;
use Str;

class ProdutoObserver
{
    public function creating(Produto $product)
    {
        $product->uuid = Str::uuid();
    }
    
   
    public function updating(Produto $product){
       // $product->url = Str::kebab(limita_caracteres($product->nome, 80));
    }
    
    public function updated(Produto $produto){
        
        //verifica a tabela de preço
    }
    
    public function created(Produto $produto){
        //Faz o lançamento do Estoque Inicial
        if($produto->tipo_produto_id == config("constantes.tipo_produto.PRODUTO")){
            $mov                    = new \stdClass();
            $mov->tipo_movimento_id = config("constantes.tipo_movimento.ENTRADA_INICIO_ESTOQUE");
            $mov->produto_id        = $produto->id;
            $mov->ent_sai           = 'E';
            $mov->estorno           = 'N';
            $mov->data_movimento    = hoje();
            $mov->qtde_movimento    = $produto->estoque_inicial;
            $mov->valor_movimento   = $produto->valor_venda;
            $mov->subtotal_movimento= $produto->estoque_inicial * $produto->valor_venda;
            $mov->descricao         = "Início de Estoque - Cadastro Produto";
            if($mov->qtde_movimento > 0){
                MovimentoService::inserir($mov);
            }
        }
        
        //Cria a tabela de preço
        $tabelaPreco = TabelaPreco::where("padrao", "S")->first();
        $preco = new \stdClass();
        $preco->tabela_preco_id = $tabelaPreco->id;
        $preco->produto_id      = $produto->id;
        $preco->valor           = $produto->valor_venda;
        $preco->data_atualizacao = hoje();
        TabelaPrecoProduto::Create(objToArray($preco));
    }
}


