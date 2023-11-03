<?php
namespace App\Service;

use App\Models\ItemVenda;
use App\Models\Movimento;
use App\Models\Venda;
use App\Models\ItemCompra;
use App\Models\NfeItem;
use App\Models\Nfe;
use App\Models\PdvItemVenda;
use App\Models\PdvVenda;

class MovimentoService{
    public static function inserir($mov ){        
        $saldo_anterior = Movimento::saldoEstoque($mov->produto_id);
        $qtde           = ($mov->ent_sai=="E") ? $mov->qtde_movimento : - $mov->qtde_movimento;
        $saldo          =  $saldo_anterior + ($qtde) ;
        
        //Se for transferência
        $saldo_atual = ($mov->tipo_movimento_id==config('constantes.tipo_movimento.ENTRADA_TRANSFERENCIA_ESTOQUE') || $mov->tipo_movimento_id==config('constantes.tipo_movimento.SAIDA_TRANSFERENCIA_ESTOQUE')) ? $saldo_anterior : $saldo;
        $mov->saldoestoque = $saldo_atual ;
        return Movimento::create(objToArray($mov));
    }
    
    public static function historico($filtro){
        $retorno = Movimento::where("qtde_movimento",">",0);
        
        if($filtro->produto_id){
            $retorno->where("produto_id", $filtro->produto_id);
        }
        
        if($filtro->entrada_saida){
            $retorno->where("ent_sai", $filtro->entrada_saida);
        }        
        
        if($filtro->data1){
            if($filtro->data2){
                $retorno->where("data_movimento",">=", $filtro->data1)->where("data_movimento","<=", $filtro->data2);
            }else{
                $retorno->where("data_movimento", $filtro->data1);
            }
        }
        
        if($filtro->origem_movimento){
            if($filtro->origem_movimento= "estorno"){
                $retorno->where("estorno", "S");
            }else{
                $retorno->whereNotNull($filtro->origem_movimento);
            }            
        }
        
        return $retorno;
    }
    
    public static function lancarEstoqueDaCompra($id_compra, $tipo_movimento, $descricao){
        $itens = ItemCompra::where("compra_id", $id_compra)->get();
        foreach($itens as $item){
            $produto        =  $item->produto;
            $ultimoMovimento = Movimento::where(["compra_id"=>$id_compra, "produto_id"=>$item->produto_id])->orderBy('created_at', 'desc')->first();
            if($item->unidade ==$produto->fragmentacao_unidade){
                $quantidade = $item->quantidade / $produto->fragmentacao_qtde;
            }else{
                $quantidade = $item->quantidade;
            }
            
            $mov                    = new \stdClass();
            $mov->tipo_movimento_id = $tipo_movimento;
            $mov->produto_id        = $item->produto_id;
            $mov->compra_id         = $id_compra;
            $mov->ent_sai           = 'E';
            $mov->estorno           = 'N';
            $mov->data_movimento    = hoje();
            $mov->qtde_movimento    = $quantidade;
            $mov->valor_movimento   = $item->valor_unitario;
            $mov->subtotal_movimento= $item->subtotal;
            $mov->descricao         = $descricao;
            
            if(isset($ultimoMovimento->estorno) ){
                if($ultimoMovimento->estorno == "S"){
                    MovimentoService::inserir($mov);
                }
            }else{
                MovimentoService::inserir($mov);
            }
            
        }        
       
        
    }
    
    public static function estornarEstoqueDaCompra($id_compra, $tipo_movimento, $descricao){
        $itens = ItemCompra::where("compra_id", $id_compra)->get();
        foreach($itens as $item){
            $ultimoMovimento = Movimento::where(["compra_id"=>$id_compra, "produto_id"=>$item->produto_id])->orderBy('created_at', 'desc')->first();
       
            $produto        =  $item->produto;
            if($item->unidade ==$produto->fragmentacao_unidade){
                $quantidade = $item->quantidade / $produto->fragmentacao_qtde;
            }else{
                $quantidade = $item->quantidade;
            }
            
            $mov                    = new \stdClass();
            $mov->tipo_movimento_id = $tipo_movimento;
            $mov->produto_id        = $item->produto_id;
            $mov->compra_id          = $id_compra;
            $mov->ent_sai           = 'S';
            $mov->estorno           = 'S';
            $mov->data_movimento    = hoje();
            $mov->qtde_movimento    = $quantidade;
            $mov->valor_movimento   = $item->valor_unitario;
            $mov->subtotal_movimento= $item->subtotal;
            $mov->descricao         = $descricao;
            if(isset($ultimoMovimento->estorno) ){
                if($ultimoMovimento->estorno =="N"){
                    MovimentoService::inserir($mov);
                }
            }
            
            
        }
    }
    
    
    public static function lancarEstoqueDaVenda($id_venda, $tipo_movimento, $descricao){
        $itens = ItemVenda::where("venda_id", $id_venda)->get();
        foreach($itens as $item){
            $produto        =  $item->produto;
            $ultimoMovimento = Movimento::where(["venda_id"=>$id_venda, "produto_id"=>$item->produto_id])->orderBy('created_at', 'desc')->first();
            if($item->unidade ==$produto->fragmentacao_unidade){
                $quantidade = $item->quantidade / $produto->fragmentacao_qtde;
            }else{
                $quantidade = $item->quantidade;
            }
            
            $mov                    = new \stdClass();
            $mov->tipo_movimento_id = $tipo_movimento;
            $mov->produto_id        = $item->produto_id;
            $mov->venda_id          = $id_venda;
            $mov->ent_sai           = 'S';
            $mov->estorno           = 'N';
            $mov->data_movimento    = hoje();
            $mov->qtde_movimento    = $quantidade;
            $mov->valor_movimento   = $item->valor;
            $mov->subtotal_movimento= $item->subtotal;
            $mov->descricao         = $descricao;
            
            if(isset($ultimoMovimento->estorno) ){
                if($ultimoMovimento->estorno == "S"){
                    MovimentoService::inserir($mov);
                }
            }else{
                MovimentoService::inserir($mov);
            }
        }        
        Venda::where("id", $id_venda)->update(["estornou_estoque"=>"N"]);
    }
    
    public static function estornarEstoqueDaVenda($id_venda, $tipo_movimento, $descricao){
        $itens = ItemVenda::where("venda_id", $id_venda)->get();
        
        foreach($itens as $item){
            $ultimoMovimento = Movimento::where(["venda_id"=>$id_venda, "produto_id"=>$item->produto_id])->orderBy('created_at', 'desc')->first();
          
            $produto        =  $item->produto;
            if($item->unidade ==$produto->fragmentacao_unidade){
                $quantidade = $item->quantidade / $produto->fragmentacao_qtde;
            }else{
                $quantidade = $item->quantidade;
            }
            
            $mov                    = new \stdClass();
            $mov->tipo_movimento_id = $tipo_movimento;
            $mov->produto_id        = $item->produto_id;
            $mov->venda_id          = $id_venda;
            $mov->ent_sai           = 'E';
            $mov->estorno           = 'S';
            $mov->data_movimento    = hoje();
            $mov->qtde_movimento    = $quantidade;
            $mov->valor_movimento   = $item->valor;
            $mov->subtotal_movimento= $item->subtotal;
            $mov->descricao         = $descricao;
            if(isset($ultimoMovimento->estorno) ){
                if($ultimoMovimento->estorno =="N"){
                    MovimentoService::inserir($mov);
                }                
            }
        }        
        Venda::where("id", $id_venda)->update(["estornou_estoque"=>"S"]);
    }
    
    public static function lancarEstoqueDaNfe($id_nfe, $tipo_movimento, $descricao){
        $itens = NfeItem::where("nfe_id", $id_nfe)->get();
        foreach($itens as $item){
            $produto        =  $item->produto;
            $ultimoMovimento = Movimento::where(["nfe_id"=>$id_nfe, "produto_id"=>$item->produto_id])->orderBy('created_at', 'desc')->first();
           /* if($item->unidade ==$produto->fragmentacao_unidade){
                $quantidade = $item->quantidade / $produto->fragmentacao_qtde;
            }else{
                $quantidade = $item->quantidade;
            }*/
            
            $quantidade = $item->qCom;
            $mov                    = new \stdClass();
            $mov->tipo_movimento_id = $tipo_movimento;
            $mov->produto_id        = $item->produto_id;
            $mov->nfe_id            = $id_nfe;
            $mov->ent_sai           = 'S';
            $mov->estorno           = 'N';
            $mov->data_movimento    = hoje();
            $mov->qtde_movimento    = $quantidade;
            $mov->valor_movimento   = $item->vUnCom;
            $mov->subtotal_movimento= $item->vProd;
            $mov->descricao         = $descricao;
            
            if(isset($ultimoMovimento->estorno) ){
                if($ultimoMovimento->estorno == "S"){
                    MovimentoService::inserir($mov);
                }
            }else{
                MovimentoService::inserir($mov);
            }
        }
        
        
    }
    
    public static function lancarEstoqueDoPdv($id_venda, $tipo_movimento, $descricao){
        $itens = PdvItemVenda::where("venda_id", $id_venda)->get();
        foreach($itens as $item){
            $produto        =  $item->produto;
            $ultimoMovimento = Movimento::where(["venda_id"=>$id_venda, "produto_id"=>$item->produto_id])->orderBy('created_at', 'desc')->first();
         /*   if($item->unidade ==$produto->fragmentacao_unidade){
                $quantidade = $item->qtde / $produto->fragmentacao_qtde;
            }else{
                $quantidade = $item->qtde;
            }*/
            
            $quantidade             = $item->qtde;
            
            $mov                    = new \stdClass();
            $mov->tipo_movimento_id = $tipo_movimento;
            $mov->produto_id        = $item->produto_id;
            $mov->pdvvenda_id       = $id_venda;
            $mov->ent_sai           = 'S';
            $mov->estorno           = 'N';
            $mov->data_movimento    = hoje();
            $mov->qtde_movimento    = $quantidade;
            $mov->valor_movimento   = $item->valor;
            $mov->subtotal_movimento= $item->subtotal;
            $mov->descricao         = $descricao;
            
            if(isset($ultimoMovimento->estorno) ){
                if($ultimoMovimento->estorno == "S"){
                    MovimentoService::inserir($mov);
                }
            }else{
                MovimentoService::inserir($mov);
            }
        }
        PdvVenda::where("id", $id_venda)->update(["estornou_estoque"=>"N"]);
    }
}

