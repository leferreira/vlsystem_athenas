<?php
namespace App\Service;

use App\Models\LojaCliente;
use App\Models\LojaConfiguracao;
use App\Models\LojaItemPedido;
use App\Models\LojaPedido;
use Illuminate\Support\Str;

class CarrinhoService{
    public static function add($data){   
       
        $typeUser = self::getUser(); 
       
        if($typeUser == 'temp'){
            //Pedido sem está logado           
            $userTemp = self::getUserTemp();                
            $pedido = LojaPedido::where('rand_pedido', $userTemp['rand'])->first(); 
           
            if($pedido == null){                    
                $pedido = self::criaPedido(null,$userTemp['rand'] );                    
                self::addItem($data, $pedido);
            }else{
                self::addItem($data, $pedido);
            }             
            
        }else{
            $user   = self::getUserLogado();
            $pedido = LojaPedido::where('cliente_id', $user['cliente_id'])->where('valor_total', '0')->first();
            if($pedido == null){
                $pedido =self::criaPedido($user['cliente_id'], null);
                self::addItem($data, $pedido);
            }else{
                self::addItem($data, $pedido);
            }
        } 
        
    }
    
    public function getUser(){        
        $user = self::getUserLogado(); 
        
        if($user == null){
            $userTemp = self::getUserTemp();
            if($userTemp == null){
                $randUser = Str::random(20);
                $ob = [
                    'rand' => $randUser,
                    'start' => date('H:i:s')
                ];
                session(['user_temp' => $ob]);
                return 'temp';
            }else{
                return 'temp';
            }
        }else{
            //usuario logado
            return 'logado';
        }
    }
    
    public function getUserTemp(){
        $usr = session('user_temp');
        return $usr;
    }
    public function getUserLogado(){
        $usr = session('user_ecommerce');
        return $usr;
    }
    private function addItem($data, $pedido){
        $item = [
            'pedido_id'     => $pedido->id,
            'produto_id'    => $data['produto_id'],
            'valor'         => $data['valor'],
            'quantidade'    => $data['quantidade']
        ];
        LojaItemPedido::create($item);
    }
    
    private function criaPedido($cliente_id, $rand){
        $pedido = [
            'cliente_id'    => $cliente_id,
            'endereco_id'   => null,
            'status_id'     => config('constantes.status.DIGITACAO'),
            'valor_total'   => 0,
            'valor_frete'   => 0,
            'tipo_frete'    => '',
            'venda_id'      => 0,
            'numero_nfe'    => 0,
            'observacao'    => '',
            'rand_pedido'   => $rand
        ];
    
        $pedido = LojaPedido::create($pedido);
      
    }
    
    public static function getCarrinho(){
        $user       = self::getUserLogado();
        $userTemp   = self::getUserTemp();
        
        $pedido = null;
        if($userTemp != null){
            $pedido = LojaPedido::where('rand_pedido', $userTemp['rand'])->where('status_id', config('constantes.status.DIGITACAO'))->first();
        }else if($user != null){            
            $pedido = LojaPedido::where('cliente_id', $user['cliente_id'])->where('status_id', config('constantes.status.DIGITACAO'))->first();
        }   
        
        return $pedido;
    }
    
    public static function calculaFreteCepProduto($request, $config){
        $cepDestino = str_replace("-", "", $request->cep);
        $pedidoId = $request->pedido_id;
        
        $pedido = LojaPedido::find($pedidoId);
        
        
        $ceps = $pedido->getCepsDoPedido($config->cep);
        i($ceps);
        $retorno = [
            'preco_sedex' => 0,
            'prazo_sedex' => 0,
            'preco' => 0,
            'prazo' => 0
        ];
        if(sizeof($ceps) > 0){
            for($i=0; $i < sizeof($ceps); $i++){
                $cepOrigem = str_replace("-", "", $ceps[$i]);
                
                $somaPeso = $pedido->somaPesoPorCep($ceps[$i]);
                $dimensoes = $pedido->somaDimensoesPorCep($ceps[$i]);
                
                $stringUrl = "&sCepOrigem=$cepOrigem&sCepDestino=$cepDestino&nVlPeso=$somaPeso";
                
                $stringUrl .= "&nVlComprimento=".$dimensoes['comprimento']."&nVlAltura=".$dimensoes['altura']."&nVlLargura=".$dimensoes['largura']."&nCdServico=04510";
                
                
                $url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCdAvisoRecebimento=n&sCdMaoPropria=n&nVlValorDeclarado=0&nVlDiametro=0&StrRetorno=xml&nIndicaCalculo=3&nCdFormato=1" . $stringUrl;
                
                $unparsedResult = file_get_contents($url);
                $parsedResult = simplexml_load_string($unparsedResult);
                
                $stringUrl = "&sCepOrigem=$cepOrigem&sCepDestino=$cepDestino&nVlPeso=$somaPeso";
                
                $stringUrl .= "&nVlComprimento=".$dimensoes['comprimento']."&nVlAltura=".$dimensoes['altura']."&nVlLargura=".$dimensoes['largura']."&nCdServico=04014";
                
                $url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCdAvisoRecebimento=n&sCdMaoPropria=n&nVlValorDeclarado=0&nVlDiametro=0&StrRetorno=xml&nIndicaCalculo=3&nCdFormato=1" . $stringUrl;
                
                $unparsedResultSedex = file_get_contents($url);
                $parsedResultSedex = simplexml_load_string($unparsedResultSedex);
                
                // $retorno = array(
                // 	'preco_sedex' => strval($parsedResult->cServico->Valor),
                // 	'prazo_sedex' => strval($parsedResult->cServico->PrazoEntrega),
                
                // 	'preco' => strval($parsedResultSedex->cServico->Valor),
                // 	'prazo' => strval($parsedResultSedex->cServico->PrazoEntrega)
                // );
                
                $valorSedex = (strval($parsedResultSedex->cServico->Valor));
                $valorSedex = (float)str_replace(",", ".", $valorSedex);
                
                $retorno['preco_sedex'] += $valorSedex;
                
                $valorPac = (strval($parsedResult->cServico->Valor));
                $valorPac = (float)str_replace(",", ".", $valorPac);
                
                $retorno['preco'] += $valorPac;
                
                if($retorno['prazo_sedex'] < strval($parsedResultSedex->cServico->PrazoEntrega)){
                    $retorno['prazo_sedex'] = strval($parsedResultSedex->cServico->PrazoEntrega);
                }
                
                if($retorno['prazo'] < strval($parsedResult->cServico->PrazoEntrega)){
                    $retorno['prazo'] = strval($parsedResult->cServico->PrazoEntrega);
                }
                // $retorno['prazo_sedex'] = strval($parsedResult->cServico->PrazoEntrega);
                
                
            }
            
            $retorno['preco_sedex'] = number_format($retorno['preco_sedex'], 2, ',', '.') . "";
            $retorno['preco'] = number_format($retorno['preco'], 2, ',', '.') . "";
            
            return $retorno;
            
        }else{
            return $this->calculaFreteNormal($request);
        }
    }
    
    public static function calculaFreteNormal($request, $config){
        $cepDestino = str_replace("-", "", $request->cep);
        $pedidoId = $request->pedido_id;
        
        $pedido = LojaPedido::find($pedidoId);        
       
        
        $cepOrigem = str_replace("-", "", $config->cep);        
        $somaPeso  = $pedido->somaPeso();        
        $dimensoes = $pedido->somaDimensoes();
        
        $stringUrl = "&sCepOrigem=$cepOrigem&sCepDestino=$cepDestino&nVlPeso=$somaPeso";
        
        $stringUrl .= "&nVlComprimento=".$dimensoes['comprimento']."&nVlAltura=".$dimensoes['altura']."&nVlLargura=".$dimensoes['largura']."&nCdServico=04510";
        
        
        $url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCdAvisoRecebimento=n&sCdMaoPropria=n&nVlValorDeclarado=0&nVlDiametro=0&StrRetorno=xml&nIndicaCalculo=3&nCdFormato=1" . $stringUrl;
       
        $unparsedResult = file_get_contents($url);
        $parsedResult = simplexml_load_string($unparsedResult);
        
        $stringUrl = "&sCepOrigem=$cepOrigem&sCepDestino=$cepDestino&nVlPeso=$somaPeso";
        
        $stringUrl .= "&nVlComprimento=".$dimensoes['comprimento']."&nVlAltura=".$dimensoes['altura']."&nVlLargura=".$dimensoes['largura']."&nCdServico=04014";
        
        $url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCdAvisoRecebimento=n&sCdMaoPropria=n&nVlValorDeclarado=0&nVlDiametro=0&StrRetorno=xml&nIndicaCalculo=3&nCdFormato=1" . $stringUrl;
        
        $unparsedResultSedex = file_get_contents($url);
        $parsedResultSedex = simplexml_load_string($unparsedResultSedex);
        
        $retorno = array(
            'preco_sedex' => strval($parsedResultSedex->cServico->Valor),
            'prazo_sedex' => strval($parsedResultSedex->cServico->PrazoEntrega),
            
            'preco' => strval($parsedResult->cServico->Valor),
            'prazo' => strval($parsedResult->cServico->PrazoEntrega)
        );
        
        if($pedido->somaItens() > $config->frete_gratis_valor){
            $retorno['frete_gratis'] = true;
        }
        
        return $retorno;
    }
    public  static function calculaFreteEnderecos($endereco, $carrinho){
        
        $cepDestino = $endereco->cep;        
        $config     = LojaConfiguracao::first();
        
        $cepOrigem = str_replace("-", "", $config->cep);
        
        $somaPeso = $carrinho->somaPeso();
        $dimensoes = $carrinho->somaDimensoes();
        
        $stringUrl = "&sCepOrigem=$cepOrigem&sCepDestino=$cepDestino&nVlPeso=$somaPeso";
        
        $stringUrl .= "&nVlComprimento=".$dimensoes['comprimento']."&nVlAltura=".$dimensoes['altura']."&nVlLargura=".$dimensoes['largura']."&nCdServico=04014";
        
        
        $url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCdAvisoRecebimento=n&sCdMaoPropria=n&nVlValorDeclarado=0&nVlDiametro=0&StrRetorno=xml&nIndicaCalculo=3&nCdFormato=1" . $stringUrl;
        
        $unparsedResult = file_get_contents($url);
        $parsedResult = simplexml_load_string($unparsedResult);
        
        $stringUrl = "&sCepOrigem=$cepOrigem&sCepDestino=$cepDestino&nVlPeso=$somaPeso";
        
        $stringUrl .= "&nVlComprimento=".$dimensoes['comprimento']."&nVlAltura=".$dimensoes['altura']."&nVlLargura=".$dimensoes['largura']."&nCdServico=04510";
        
        $url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCdAvisoRecebimento=n&sCdMaoPropria=n&nVlValorDeclarado=0&nVlDiametro=0&StrRetorno=xml&nIndicaCalculo=3&nCdFormato=1" . $stringUrl;
        
        $unparsedResultSedex = file_get_contents($url);
        $parsedResultSedex = simplexml_load_string($unparsedResultSedex);
        
        $retorno = array(
            'preco_sedex' => strval($parsedResult->cServico->Valor),
            'prazo_sedex' => strval($parsedResult->cServico->PrazoEntrega),
            
            'preco' => strval($parsedResultSedex->cServico->Valor),
            'prazo' => strval($parsedResultSedex->cServico->PrazoEntrega)
        );
        
        return $retorno;
    }
    public static function setUserEcommerce($clienteId){
        $cliente = LojaCliente::find($clienteId);
        $ob = [
            'cliente_id'    => $clienteId,
            'nome'          => $cliente->nome,
            'sobre_nome'    => $cliente->sobre_nome,
            'start' => date('H:i:s')
        ];
        session()->forget('user_temp');
        session(['user_ecommerce' => $ob]);
    }
}

