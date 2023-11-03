<?php

namespace App\Http\Controllers;

use App\Service\CarrinhoService;
use App\Service\LojaService;
use Illuminate\Http\Request;

class CarrinhoController extends Controller{ 
    
    public function index(){
        try {
            if(!(session()->has('pedido'))  ){
                return redirect()->route('home')->with('msg_erro', "Não existe nenhum pedido selecionado");
            }
            
            $carrinho               = LojaService::home("carrinho", null, null, null) ;
          
            if($carrinho->carrinho->status_id == config("constantes.status.FINALIZADO")){
                return redirect()->route('home')->with('msg_erro', "Este pedido já está finalizado, não é mais possível fazer modificações");
            }
            
            $dados["configuracao"]  = $carrinho->configuracao;
            $dados["carrinho"]      = $carrinho->carrinho;
            $dados["itens"]         = $carrinho->itens;
            $dados["cupom"]         = $carrinho->cupom_desconto;            
            $dados["jsCarrinho"]    = true;
            $dados["pag"]           = "detalhe";
            return view("Carrinho.Index", $dados);
        } catch (\Exception $e) {
            $mensagem = $e->getMessage();            
            return redirect()->route('erro')->with('msg_erro', $mensagem);
        }
    }
    
    public function fecharSessao(){
        session()->forget('pedido');
        return redirect()->route('home');
    }
    
    public function aplicarCupom(Request $request){
        $dados      = $request->all();
        $url        = getenv("APP_URL_API"). "loja/aplicarCupom";       
         
        enviarPostJsonCurl($url,json_encode($dados));
        return redirect()->back();
        
    }
    
    public function excluirCupom($pedido_id){
        session()->forget('sessao_cupom_desconto');
        $url         = getenv("APP_URL_API"). "loja/excluirCupom/". $pedido_id;
        enviarGetCurl($url);
        return redirect()->back();
        
    }
    
    public function acompanhar($uuid){
        $carrinho               = LojaService::home("acompanhar", null, null, $uuid) ;
        
        $dados["carrinho"]      = $carrinho->pedido;
        $dados["pedido"]        = $carrinho->pedido;
        $dados["itens"]         = $carrinho->itens;
        $dados["cliente"]       = $carrinho->cliente;   
        $dados["endereco"]      = $carrinho->endereco;
        $dados["configuracao"]  = $carrinho->configuracao;
        
        $dados["id_pedido"]     = $carrinho->pedido->id ?? null;
        return view("Carrinho.Acompanhar", $dados);        
    }
    
    public function add(Request $request){
        
        $data = [
            'produto_id'            => $request->produto_id,           
            'quantidade'            => $request->qtde,
            'desconto_por_valor'    => 0,
            'desconto_percentual'   => 0,
            'linha_id'              => $request->linha_id,
            'coluna_id'             => $request->coluna_id,
            'cupom_desconto_id'     => $request->cupom_desconto_id,
        ];
       
        try {
            CarrinhoService::add($data);
            return redirect()->route('carrinho')->with('msg_sucesso', 'Item adicionado!!');
        } catch (\Exception $e) {
            return redirect()->back()->with('msg_erro', 'Erro: ' . $e->getMessage());
            
        }
    }
    
    public function retomar($uuid){
        try {
            $pedido          = LojaService::getPedidoPeloUuid($uuid) ;           
            if($pedido){
                session()->forget('pedido');              
                session(["pedido"=>$pedido->id]);
                return redirect()->route('carrinho');
            }
        } catch (\Exception $e) {
            $mensagem = $e->getMessage();
            return redirect()->route('erro')->with('msg_erro', $mensagem);
        }
        
    }
    public function checkout(Request $request){
        if(!(session()->has('pedido'))  ){
            return redirect()->route('home')->with('msg_erro', "Não existe nenhum pedido selecionado");
        }
        
        $carrinho                = LojaService::home("checkout", null, null, null) ;
        
        $dados["carrinho"]      = $carrinho ;
        $tipoFrete              = $request->tp_frete;
        
        if((session('usuario_loja_logado')->nome ?? null) == null){
            if( $carrinho== null){
                return redirect()->route('home');
            }            
            $dados["jsCarrinho"]    = true;
            $dados["cart"]          = true;
            $dados["contato"]       = true;
            $dados["carrinho"]      = $carrinho->carrinho;
            $dados["configuracao"]  = $carrinho->configuracao;
            $dados["itens"]         = $carrinho->itens;
            return view("Carrinho.Checkout", $dados);
        }else{            
            return redirect()->route('carrinho.endereco',['tipo_frete'=>''.$tipoFrete]);
        }
    }
    
    public function endereco(Request $request){
        if(!(session()->has('pedido'))  ){
            return redirect()->route('home')->with('msg_erro', "Não existe nenhum pedido selecionado");
        }
        $home              = LojaService::home("endereco_carrinho", null, null, null) ;
      
        $carrinho     = $home->carrinho;
        $enderecos    = $home->enderecos;
        $cliente      = $home->cliente;
        $configuracao = $home->configuracao ;
        $itens        = $home->itens;
        
        $tipoFrete  = $request->tipo_frete;    

        $total      = $carrinho->valor_venda;
        
        
        foreach($enderecos as $e){
            $calc               = CarrinhoService::calculaFreteEnderecos($e->cep, $itens, $configuracao->cep);  
                                                                         
            $e->preco_sedex     = $calc['preco_sedex'];
            $e->prazo_sedex     = $calc['prazo_sedex'];
            $e->preco           = $calc['preco'];
            $e->prazo           = $calc['prazo'];
            $e->frete_gratis    = 0;
            
            if($total > $configuracao->frete_gratis_valor){
                $e->frete_gratis = 1;
            }
            
        }
        $dados["tipoFrete"]     = $tipoFrete;
        $dados["carrinho"]      = $carrinho;
        $dados["configuracao"]  = $configuracao;
        $dados["itens"]         = $itens;  
        $dados["cliente"]       = $cliente;
        $dados["enderecos"]     = $enderecos;        
        $dados["total"]         = $total;
        $dados["contato"]       = true;
        
        
        return view("Carrinho.SelecionarEndereco", $dados);
    }
    
    public function pagamento(Request $request){   
        if(!(session()->has('pedido'))  ){
            return redirect()->route('home')->with('msg_erro', "Não existe nenhum pedido selecionado");
        }
        $pedido_id  = $request->pedido_id;
        $tipo       = $request->tipo;
        $uuid       = $request->uuid;
        
        if(!$request->endereco ){
            session()->flash('msg_erro', 'Selecione o endereço');
            return redirect()->back();
        }
        
        $endereco = json_decode($request->endereco);        
        $valorFrete = 0;        
        if($tipo == 'sedex'){
            $valorFrete = getFloat($endereco->preco_sedex);
        }else if($tipo == 'pac'){
            $valorFrete = getFloat($endereco->preco);
        }       
        
        $pedido              = new \stdClass();
        $pedido->pedido_id  = $pedido_id;
        $pedido->endereco_id = $endereco->id;
        $pedido->valor_frete = $valorFrete;        
        
        //Envia para o servidor
        $resultado = LojaService::setarEnderecoFrete($pedido);
        if($resultado){
            return redirect()->route('pagamento.escolher', $uuid);
        }
        
    }
 
    public function atualizarItem($id, $qtde){
        try {
           $retorno = LojaService::atualizarItem($id, $qtde) ;
           return response()->json($retorno);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    
    public function excluir($id){
        try {
            $retorno = LojaService::excluirItem($id) ;
            return response()->json($retorno);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    
    public function finalizado($uuid_pedido){   
        session()->forget('pedido');
        $carrinho               = LojaService::home("finalizado", null, null, $uuid_pedido) ;
        
        $dados["carrinho"]      = $carrinho->pedido;
        $dados["pedido"]        = $carrinho->pedido;
        $dados["configuracao"]  = $carrinho->configuracao;
        
        $dados["id_pedido"]     = $carrinho->pedido->id ?? null;
        return view("Carrinho.Obrigado", $dados);
        
    }
}
