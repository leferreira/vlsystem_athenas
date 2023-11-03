<?php

namespace App\Http\Controllers\Delivery\Web;

use App\Http\Controllers\Controller;
use App\Models\BairroDelivery;
use App\Models\ClienteDelivery;
use App\Models\CodigoDesconto;
use App\Models\DeliveryConfig;
use App\Models\FuncionamentoDelivery;
use App\Models\ItemPedidoComplementoDelivery;
use App\Models\ItemPedidoDelivery;
use App\Models\PedidoDelivery;
use Illuminate\Http\Request;

class CarrinhoWebController extends Controller{  
    
    public function index(){    
       
        $clienteLog = session('cliente_delivery_log');
        $pedido = PedidoDelivery::where('estado', 'nv')->where('valor_total', 0)->where('cliente_id', $clienteLog['id'])->first();
        
        $dados["jsCarrinho"]      = true;
        $dados["pedido"]        = $pedido;
        $dados["config"]        = DeliveryConfig::first();
        return view("Delivery.Web.Carrinho.Index", $dados);        
    }
    
    public function add(Request $request){        
        $value = session('cliente_delivery_log');    
       
        if($value){
            $adicionais = $request['adicionais'];
            $produto_id = $request['produto_id'];
            $quantidade = $request['quantidade'];
            $observacao = $request['observacao'];
            
            $clienteLog = session('cliente_delivery_log');
            //verifica se cliente nao possui pedido estado novo 'nv'
            
            $pedido = PedidoDelivery::where('estado', 'nv')->where('cliente_id', $clienteLog['id'])->first();
            if($pedido == null){ // cria um novo
                $pedido = PedidoDelivery::create([
                    'cliente_id' => $clienteLog['id'],
                    'status_id' => 1,
                    'valor_total' => 0,
                    'telefone' => '',
                    'observacao' => '',
                    'forma_pagamento' => '',
                    'estado'=> 'nv',
                    'motivoEstado'=> '',
                    'endereco_id' => NULL,
                    'troco_para' => 0,
                    'desconto' => 0,
                    'cupom_id' => NULL,
                    'app' => false
                ]);
            } // se nao usa o ja existe
            
            if($pedido->valor_total == 0){
                $item = ItemPedidoDelivery::create([
                    'pedido_id' => $pedido->id,
                    'produto_id' => $produto_id,
                    'status' => false,
                    'observacao' => $observacao ?? '',
                    'quantidade' => $quantidade,
                    'tamanho_id' => null
                ]);
                
                if($adicionais){
                    foreach($adicionais as $a){                        
                        $itemAdd = ItemPedidoComplementoDelivery::create([
                            'item_pedido_id' => $item->id,
                            'complemento_id' => $a['id'],
                            'quantidade' => 1,
                        ]);
                    }
                }                
                
                echo json_encode($pedido);
            }else{
                echo json_encode(false);
            }
        }else{
            session()->flash("message_erro", "Voce precisa estar logado, realize seu cadastro por gentileza");
            echo json_encode('401');
        }
    }
    
    public function forma_pagamento($cupom = 0){        
        $funcionamento = $this->funcionamento();
        
        $pagseguroAtivo = getenv("PAGSEGURO_ATIVO");
        $pagseguroEmail = getenv("PAGSEGURO_EMAIL");
        $pagseguroToken = getenv("PAGSEGURO_TOKEN");
        
        $pagseguroAtivado = false;
        if($pagseguroAtivo == 1 && strlen($pagseguroEmail) > 10 && strlen($pagseguroToken) > 10){
            $pagseguroAtivado = true;
        }
        
        if($funcionamento['status']){
            $clienteLog = session('cliente_delivery_log');
            $pedido = PedidoDelivery::
            where('estado', 'nv')->where('valor_total', '==', 0)->where('cliente_id', $clienteLog['id'])->first();
            
            if($pedido){                
                if(count($pedido->itens) > 0){
                    
                    $total = 0;
                    foreach($pedido->itens as $i){
                        if(count($i->sabores) > 0){
                            
                            $maiorValor = 0;
                            $somaValores = 0;
                            foreach($i->sabores as $it){
                                $v = $it->maiorValor($it->sabor_id, $i->tamanho_id);
                                $somaValores += $v;
                                if($v > $maiorValor) $maiorValor = $v;
                            }
                            if(getenv("DIVISAO_VALOR_PIZZA") == 1){
                                $maiorValor = number_format(($somaValores/sizeof($i->sabores)),2);
                            }
                            $total += $i->quantidade * $maiorValor;
                        }else{
                            $total += ($i->produto->valor * $i->quantidade);
                        }
                        
                        
                        foreach($i->itensAdicionais as $a){
                            $total += $i->quantidade * $a->adicional->valor;
                        }
                    }
                    
                    $cliente = ClienteDelivery::where('id', $clienteLog['id'])->first();                    
                    $enderecos = $cliente->enderecos;                   
                    
                    if($clienteLog){
                        
                        $ultimoPedido = PedidoDelivery:: where('cliente_id', $cliente->id)->where('valor_total', '>', 0)->orderBy('id', 'desc')->first();
                        
                        $cartoes = $this->getPedidosPagSeguro($cliente->id);
                        $d = DeliveryConfig::first();
                        
                        $bairros = BairroDelivery::orderBy('nome')->get();
                        
                        
                        
                        $dados['pedido']= $pedido;
                        $dados['ultimoPedido']= $ultimoPedido;
                        $dados['cartoes']= $cartoes;
                        $dados['cliente']= $cliente;
                        $dados['enderecos']= $enderecos;
                        $dados['forma_pagamento']= true;
                        $dados['total']= $total;
                        $dados['mapaJs']= true;
                        $dados['bairros']= $bairros;
                        $dados['usar_bairros']= $d->usar_bairros;
                        $dados['maximo_km_entrega']= $d->maximo_km_entrega;
                        $dados['cupom']= $cupom;
                        $dados['pagseguroAtivado']= $pagseguroAtivado;
                        $dados['config']= DeliveryConfig::first();
                        return view("Delivery.Web.Carrinho.forma_pagamento", $dados); 
                    }else{
                        session()->flash("message_erro", "Voce precisa estar logado, realize seu cadastro por gentileza");
                        return redirect('/autenticar/registro');
                    }
                }else{
                    session()->flash("message_erro", "Carrinho vazio!");
                    return redirect('delivery.web.home');
                }
            }else{
                session()->flash("message_erro", "Carrinho vazio!");
                return redirect('delivery.web.home');
            }
        }else{
            if($funcionamento['funcionamento'] != null){
                session()->flash("message_erro", "Delivery das " .$funcionamento['funcionamento']->inicio_expediente. " às ".$funcionamento['funcionamento']->fim_expediente);
                
            }else{
                session()->flash("message_erro", "Não haverá delivery no dia de hoje!");
            }
            return redirect('delivery.web.home');
        }
    }
    
    private function funcionamento(){
        $atual = strtotime(date('H:i'));
        $dias = FuncionamentoDelivery::dias();
        $hoje = $dias[date('w')];
        $func = FuncionamentoDelivery::where('dia', $hoje)->first();
        
        if($func){
            if($atual >= strtotime($func->inicio_expediente) && $atual < strtotime($func->fim_expediente) && $func->ativo){
                return ['status' => true, 'funcionamento' => $func];
            }else{
                return ['status' => false, 'funcionamento' => $func];
            }
        }else{
            return ['status' => false, 'funcionamento' => null];
        }
    }
    
    private function getPedidosPagSeguro($clienteId){
        $pedidos = PedidoDelivery::where('cliente_id', $clienteId)->get();
        $arr = [];
        $cartaoInserido = [];
        foreach($pedidos as $p){
            if($p->forma_pagamento == 'pagseguro'){
                if(!in_array($p->pagseguro->numero_cartao, $cartaoInserido)){
                    $p->pagseguro->src_bandeira = 'https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/'.
                        $p->pagseguro->bandeira . '.png';
                        array_push($arr, $p->pagseguro);
                        array_push($cartaoInserido, $p->pagseguro->numero_cartao);
                }
            }
        }
        
        return $arr;
    }
    
    
    public function finalizarPedido(Request $request){
        $data = $request['data'];
        $pedido = PedidoDelivery::where('id', $data['pedido_id'])->where('estado', 'nv')->first();
        if($pedido){
            $total = 0;
            foreach($pedido->itens as $i){
                
                foreach($i->itensAdicionais as $a){
                    $total += $a->adicional->valor * $i->quantidade;
                }
                
                if(count($i->sabores) > 0){
                    $maiorValor = 0;
                    $somaValores = 0;
                    foreach($i->sabores as $it){
                        $v = $it->maiorValor($it->produto->id, $i->tamanho_id);
                        $somaValores += $v;
                        if($v > $maiorValor) $maiorValor = $v;
                    }
                    
                    if(getenv("DIVISAO_VALOR_PIZZA") == 1){
                        $maiorValor = number_format(($somaValores/sizeof($i->sabores)),2);
                    }
                    $total += ($maiorValor * $i->quantidade);
                }else{
                    $total += ($i->produto->valor * $i->quantidade);
                }
                
            }
            
            if($data['desconto']){
                $total -= str_replace(",", ".", $data['desconto']);
            }
            
            if($data['endereco_id'] != 'balcao'){
                // $config = DeliveryConfig::first();
                $total += $data['valor_entrega'];
            }
            
            $pedido->forma_pagamento = $data['forma_pagamento'];
            $pedido->observacao = $data['observacao'] ? substr($data['observacao'], 0, 50) : '';
            $pedido->endereco_id = $data['endereco_id'] == 'balcao' ? null : $data['endereco_id'];
            $pedido->valor_total = $total;
            $pedido->telefone = $data['telefone'];
            $pedido->troco_para = $data['troco'] ? str_replace(",", ".", $data['troco']) : 0;
            $pedido->data_registro = date('Y-m-d H:i:s');
            $pedido->desconto = $data['desconto'] ? str_replace(",", ".", $data['desconto']) : 0;
            // $pedido->estado = 'ap';
            
            if($data['cupom'] != ''){
                $cupom = CodigoDesconto::
                where('codigo', $data['cupom'])
                ->first();
                
                if($cupom->cliente_id != null){
                    $cupom->ativo = false;
                    $cupom->save();
                }
                
                $pedido->cupom_id= $cupom ? $cupom->id : NULL;
            }
            
            $pedido->save();
            echo json_encode($pedido);
        }else{
            echo json_encode(false);
        }
    }
    
    public function finalizado($id){
        $clienteLog = session('cliente_delivery_log');
        if(!$clienteLog){
            session()->flash("message_erro", "Voce precisa estar logado, realize seu cadastro por gentileza");
            return redirect()->route('delivery.login');
        }
        $pedido = PedidoDelivery::where('valor_total', '!=', 0)->where('id', $id)->where('cliente_id', $clienteLog['id'])
        ->where('estado', 'nv')->first();
        
        if($pedido == null){
            session()->flash("message_erro", "Pedido inexistente");
            return redirect('delivery.web.home');
        }
        
        $valorEntrega = 0;
        if($pedido->endereco){
            if($this->config->usar_bairros){
                $bairro = BairroDelivery::find($pedido->endereco->bairro_id);
                $valorEntrega = $bairro->valor_entrega;
            }else{
                $valorEntrega = $this->config->valor_entrega;
            }
        }
        
        if($pedido){
            $dados['pedido']= $pedido;
            $dados['valorEntrega']=$valorEntrega;
            $dados['config']= DeliveryConfig::first();
            $dados['carrinho']= true;
            $dados['config']= DeliveryConfig::first();
            return view("Delivery.Carrinho.pedido_finalizado", $dados);
            
        }else{
            session()->flash("message_erro", "Pedido inexistente");
            return redirect('delivery.web.home');
        }
    }
    
    public function excluir($id){
        $item = ItemPedidoDelivery::where('id', $id)->first();
        $item->delete();
        echo json_encode($item);
    }
    
    public function atualizar($id, $quantidade){
        if($quantidade > 0){
            $item = ItemPedidoDelivery::where('id', $id)->first();
            $item->quantidade = $quantidade;
            
            //verifica os adicionais
            foreach($item->itensAdicionais as $a){
                $a->quantidade = $quantidade;
                $a->save();
            }
            $item->save();
            echo json_encode($item);
        }
    }
    
}
