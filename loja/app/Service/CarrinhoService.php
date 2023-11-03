<?php
namespace App\Service;

class CarrinhoService{
    
    public static function add($dados){   
        $pedido         = session('pedido') ?? null;    
        $id_cliente     = session('usuario_loja_logado')->cliente_id ?? null;
        $codigo_cupom   = session('sessao_cupom_desconto') ?? null;
        
        if($pedido == null){
            $p = new \stdClass();
            $p->cliente_id = $id_cliente;
            $p->pedido_id  = $pedido;
            $p->produto_id = $dados["produto_id"];
            $p->quantidade = $dados["quantidade"];
            $p->desconto_por_valor = $dados["desconto_por_valor"];
            $p->desconto_percentual = $dados["desconto_percentual"];
            $p->linha_id = $dados["linha_id"];
            $p->coluna_id = $dados["coluna_id"];
            $p->cupom_desconto_id = $dados["cupom_desconto_id"];
            $p->empresa_uuid = getenv("APP_ID_EMPRESA");  
            $p->codigo_cupom = $codigo_cupom;
            
            $retorno = PedidoService::criaPedido($p);   
            if($retorno){
                session()->forget("pedido");
                session(["pedido"=>$retorno]);
                 return redirect()->route('carrinho');
            }else{
                return redirect()->back()->with('msg_erro', "Erro ao inserir Pedido.");
            }
        }
        
        if($pedido){
            $p = new \stdClass();
            $p->cliente_id      = $id_cliente;
            $p->pedido_id       = $pedido;
            $p->produto_id      = $dados["produto_id"];
            $p->quantidade      = $dados["quantidade"];
            $p->desconto_por_valor = $dados["desconto_por_valor"];
            $p->desconto_percentual = $dados["desconto_percentual"];
            $p->linha_id = $dados["linha_id"];
            $p->coluna_id = $dados["coluna_id"];
            $p->empresa_uuid    = getenv("APP_ID_EMPRESA"); 
            $p->codigo_cupom    = $codigo_cupom;
            $item               = PedidoService::addItem($p);            
            if($item){
                return redirect()->route('carrinho');
            }else{
                return redirect()->back()->with('msg_erro', "Erro ao inserir Pedido.");
            }
        }
      } 
      
      
      public static function calculaFrete($cepDestino, $itens, $cepOrigem, $servico="04014", $formato=1){
          $retorno       = new \stdClass();
          $retorno->tem_erro = false;
          $somaPeso      = PedidoService::somaPeso($itens);
          $dimensoes     = PedidoService::somaDimensoes($itens);
          
          $valores = new \stdClass();
          $valores->codigoServico     = "04014" ;
          $valores->cepOrigem         = tira_mascara($cepOrigem);
          $valores->cepDestino        = tira_mascara($cepDestino);
          $valores->peso              = $somaPeso;
          $valores->formato           = $formato;
          $valores->comprimento       = $dimensoes->comprimento;
          $valores->altura            = $dimensoes->altura;
          $valores->largura           = $dimensoes->largura;
          $valores->diametro          = 0;
          $valores->maoPropria        = "N";
          $valores->valorDeclarado    = 0;
          $valores->avisoRecebimento  = "N";
         
          $frete =  calculaFrete($valores);
      
          if(!$frete){
              $retorno->tem_erro = true;
              $retorno->erro = "Erro ao calcular o frete";
              return $retorno;
          }
          
          if(strlen($frete->MsgErro)){
              $retorno->tem_erro = true;
              $retorno->erro     = "Erro:" .$frete->MsgErro;
              return $retorno;
          }
          
          $retorno->frete = $frete;
          return $retorno;
      }
      
      public  static function calculaFreteEnderecos($cepDestino, $itens, $cepOrigem){
          
          $sedex =  CarrinhoService::calculaFrete($cepDestino, $itens, $cepOrigem, config('correios.servico.SEDEX'));
          $pac   =  CarrinhoService::calculaFrete($cepDestino, $itens, $cepOrigem, config('correios.servico.PAC'));
          
          $retorno = array(
              'preco_sedex' => isset($sedex->frete) ? strval($sedex->frete->Valor) : $sedex->erro,
              'prazo_sedex' => isset($sedex->frete) ?  strval($sedex->frete->PrazoEntrega): $sedex->erro,
              
              'preco' => isset($pac->frete) ? strval($pac->frete->Valor): $pac->erro,
              'prazo' => isset($pac->frete) ? strval($pac->frete->PrazoEntrega): $pac->erro,
          );
          return $retorno;
      }
    
   
}

