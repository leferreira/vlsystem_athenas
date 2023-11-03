<?php

namespace App\Http\Controllers\Delivery\Balcao;

use App\Http\Controllers\Controller;
use App\Models\BairroDelivery;
use App\Models\CategoriaProdutoDelivery;
use App\Models\ClienteDelivery;
use App\Models\ComplementoDelivery;
use App\Models\DeliveryConfig;
use App\Models\EnderecoDelivery;
use App\Models\ItemPedidoComplementoDelivery;
use App\Models\ItemPedidoDelivery;
use App\Models\ItemPizzaPedido;
use App\Models\PedidoDelivery;
use App\Models\ProdutoDelivery;
use App\Models\TamanhoPizza;
use App\Models\VendaCaixa;
use Illuminate\Http\Request;


class PedidoBalcaoController extends Controller
{
    public function index(){
       
        $dados["produtos"] = ProdutoDelivery::all(); 
        $dados["clientes"] = ClienteDelivery::all();
        $dados["balcaoJS"] = true;
        return view("Delivery.Balcao.Pedido.Create", $dados);
    }
    
    public function abrirPedido($id){
      
        $tem               = PedidoDelivery::where(["status_id" => config('constantes.status.DIGITACAO'),"cliente_id"=>$id])->first();
        if(!$tem){
            $pedido = PedidoDelivery::create([
                'cliente_id'    => $id,
                'status_id'     => config('constantes.status.DIGITACAO'),
                'valor_total'   => 0,
                'telefone'      => '',
                'observacao'    => '',
                'forma_pagamento'=> '',
                'estado'        => 'nv',
                'motivoEstado'  => '',
                'endereco_id'   => NULL,
                'troco_para'    => 0,
                'desconto'      => 0,
                'cupom_id'      => NULL,
                'app'           => false
            ]);
            
        }else{
            $pedido = $tem;
        }
        
        return redirect()->route("delivery.balcao.edit",$pedido->id);
    }
    
    public function edit($id){ 
        $pedido  = PedidoDelivery::find($id);
        
        $bairros = BairroDelivery::orderBy('nome')->get();
        $config  = DeliveryConfig::first();
        
        $produtos = ProdutoDelivery::
        select('produto_deliveries.*')
        ->join('produtos', 'produtos.id', '=', 'produto_deliveries.produto_id')
        ->orderBy('produtos.nome')
        ->get();
        foreach($produtos as $p){
            $p->produto;
        }
        
        $tamanhos   = TamanhoPizza::all();
        $adicionais = ComplementoDelivery::all();
        foreach($adicionais as $a){
            $a->nome = $a->nome();
        }
        
        $valorEntrega = 0;
        
        if($pedido->endereco){
            if($config->usar_bairros){
                $bairro = BairroDelivery::find($pedido->endereco->bairro_id);
                $valorEntrega = $bairro->valor_entrega;
            }else{
                $valorEntrega = $config->valor_entrega;
            }
        }
        
        $pizzas = [];
        
        foreach($produtos as $p){            
            $p->pizza;
            $p->produto;            
            foreach($p->pizza as $pz){
                $pz->tamanho;
            }
            if(sizeof($p->pizza) > 0){
                array_push($pizzas, $p);
            }           
            
        }
        
        $itens = ItemPedidoDelivery::
        selectRaw('count(*) as qtd, produto_id')
        ->groupBy('produto_id')
        ->orderBy('qtd', 'desc')
        ->limit(12)
        ->get();
        
        $destaques = [];
        foreach($itens as $i){
            $p = ProdutoDelivery::find($i->produto_id);
            array_push($destaques, $p);
        }
        
       /* $categorias = CategoriaProdutoDelivery::all();
        foreach($categorias as $c){
            echo count($c->produtos);
        }
        */
        
        $dados["pedido"]        = $pedido;
        $dados["config"]        = $config;
        $dados["categorias"]    = CategoriaProdutoDelivery::all();
        $dados["produtos"]      = $produtos;
        $dados["destaques"]     = $destaques;
        $dados["pizzas"]        = $pizzas;
        $dados["bairros"]       = $bairros;
        $dados["adicionais"]    = $adicionais;
        $dados["tamanhos"]      = $tamanhos;
        $dados["valorEntrega"]  = $valorEntrega;
        $dados["balcaoJS"]      = true;
        return view("Delivery.Balcao.Pedido.Edit", $dados);
    }
    
    public function finalizar(Request $request){        
        $pedido = PedidoDelivery::find($request->pedido_id);
        $total = $pedido->somaItens();
        
        if($pedido->endereco_id != NULL){
            $config = DeliveryConfig::first();
            $total -= $config->valor_entrega;
        }
        
        if(isset($request->taxa_entrega)){
            $total += str_replace(",", ".", $request->taxa_entrega);
        }
        
        $pedido->valor_total = $total;
        $pedido->estado = 'ap';
        $pedido->status_id = config("constantes.status.NOVO");
        $pedido->telefone = $request->telefone;
        $pedido->observacao = $request->observacao_pedido ?? '';
        $pedido->troco_para = $request->troco_para ? str_replace(",", ".", $request->troco_para) : 0;
        $pedido->data_registro = date('Y-m-d H:i:s');
        $pedido->save();
        
        session()->flash('mensagem_sucesso', 'Pedido realizado!');
        
    /*    if($request->imprimir == 1){
            $url = getenv('PATH_URL') . '/pedidosDelivery/print/' . $pedido->id;
            return redirect('/pedidosDelivery/frente')
            ->with('url', $url);
            
        }else{
            return redirect('/pedidosDelivery/frente');
        }
        */
        
        return redirect()->route("delivery.balcao.home");
    }
    
    public function inserirEnderecoCliente(Request $request){
        $pedido = PedidoDelivery::find($request->pedido_id);
        
        $endereco = EnderecoDelivery::create(
            [
                'cliente_id' => $pedido->cliente_id,
                'rua' => $request->rua ?? '',
                'numero' => $request->numero ?? '',
                'bairro' => $request->bairro ?? '',
                'bairro_id' => $request->bairro_id ?? 0,
                'referencia' => $request->referencia ?? '',
                'latitude' => '',
                'longitude' => ''
            ]
            );
        
        $pedido->endereco_id = $endereco->id;
        $pedido->save();
        return redirect()->route('delivery.balcao.edit', $pedido->id);
    }
    
    public function inserirItem(Request $request){       
        
        $pedido = PedidoDelivery::find($request->pedido_id);       
        $this->_validateItem($request);      
        
        $result = ItemPedidoDelivery::create([
            'pedido_id'     => $pedido->id,
            'produto_id'    => $request->produto_id,
            'quantidade'    => str_replace(",", ".", $request->quantidade),
            'status'        => false,
            'tamanho_id'    => ($request->tamanho_pizza_id) ? $request->tamanho_pizza_id : NULL,
            'observacao'    => $request->observacao ?? '',
            'valor'         => str_replace(",", ".", $request->valor)
        ]);
        
        
        $saborDup = false;
        if($request->tamanho_pizza_id && $request->sabores_escolhidos){
            $saborDup = false;
            
            $sabores = explode(",", $request->sabores_escolhidos);
            if(count($sabores) > 0){
                foreach($sabores as $sab){
                    $prod = ProdutoDelivery
                    ::where('id', $sab)
                    ->first();
                    
                    $item = ItemPizzaPedido::create([
                        'item_pedido' => $result->id,
                        'sabor_id' => $prod->id,
                    ]);
                    
                    if($prod->id == $produto) $saborDup = true;
                }
            }else{
                $item = ItemPizzaPedido::create([
                    'item_pedido' => $result->id,
                    'sabor_id' => $produto_id,
                ]);
            }
        }
        
        if(!$saborDup && $request->tamanho_pizza_id){
            
            $item = ItemPizzaPedido::create([
                'item_pedido' => $result->id,
                'sabor_id' => $produto,
            ]);
            
        }
        
        else if($request->tamanho_pizza_id){
            
            $item = ItemPizzaPedido::create([
                'item_pedido' => $result->id,
                'sabor_id' => $produto,
            ]);
        }
        
        
        if($request->adicioanis_escolhidos){
            $adicionais = explode(",", $request->adicioanis_escolhidos);
            foreach($adicionais as $id){
                
                $id = (int)$id;
                
                $adicional = ComplementoDelivery
                ::where('id', $id)
                ->first();
                
                
                $item = ItemPedidoComplementoDelivery::create([
                    'item_pedido_id' => $result->id,
                    'complemento_id' => $adicional->id,
                    'quantidade' => str_replace(",", ".", $request->quantidade),
                ]);
            }
        }
        
        session()->flash('mensagem_sucesso', 'Item Adicionado!');
        return redirect()->back();        
    }
    
    private function _validateItem(Request $request){
        $validaTamanho = false;
        if($request->input('produto_id')){            
            $p = ProdutoDelivery::find($request->input('produto_id'));
           
            if(strpos(strtolower($p->categoria->nome), 'izza') !== false){
                $validaTamanho = true;
            }
        }
        $rules = [
            'produto_id' => 'required',
            'quantidade' => 'required',
            'tamanho_pizza_id' => $validaTamanho ? 'required' : '',
        ];
        
        $messages = [
            'produto_id.required' => 'O campo produto é obrigatório.',
            'quantidade.required' => 'O campo quantidade é obrigatório.',
            'tamanho_pizza_id.required' => 'Selecione um tamanho.',
        ];
        
        $this->validate($request, $rules, $messages);
    }
    
    public function marcarEnderecoCliente(Request $request){
        $pedido = PedidoDelivery::find($request->pedido_id);
        $pedido->endereco_id = $request->endereco_id;
        if($request->endereco_id == 'NULL') $pedido->endereco_id = NULL;
        $pedido->save();
        return response()->json($pedido, 200);
    }
    
    public function verPedido($id){
        $pedido = PedidoDelivery::where('id', $id)->first();
        
        //Verifica se o pedido foi finalizado
        $finazalido = VendaCaixa::where('pedido_delivery_id', $id)->exists();        
   
        
        $dados["pedido"] = $pedido;
        $dados["finazalido"] = $finazalido;
        $dados["pedidoDeliveryJs"] = true;
        $dados["pedido"] = $pedido;
        return view("Delivery.Balcao.Pedido.Show", $dados);
       
    }
}
