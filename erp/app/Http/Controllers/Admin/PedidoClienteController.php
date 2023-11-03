<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Cidade;
use App\Models\Cliente;
use App\Models\FormaPagto;
use App\Models\ItemPedidoCliente;
use App\Models\LojaPedido;
use App\Models\NaturezaOperacao;
use App\Models\PedidoCliente;
use App\Models\Produto;
use App\Models\Transportadora;
use App\Service\ConstanteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Venda;
use App\Models\ItemVenda;

class PedidoClienteController extends Controller
{
    public function index(){
        $filtro             = new \stdClass();
        $filtro->data1      = hoje();
        $filtro->data2      = hoje();
        $filtro->status_id  = null;
        $filtro->cliente_id = null;
        
        $dados["lista"]     = PedidoCliente::filtro($filtro);
        $dados["status"]    = ConstanteService::listaStatusPedido();
        $dados["clientes"]  = Cliente::get();
        $dados["filtro"]    = $filtro;
        return view("Admin.PedidoCliente.Index", $dados);
    }
    
    public function filtro(){
        $filtro             = new \stdClass();
        $filtro->data1      = $_GET["data1"];
        $filtro->data2      = $_GET["data2"];
        $filtro->status_id  = $_GET["status_id"];
        $filtro->cliente_id = $_GET["cliente_id"];
        
        $dados["lista"]     = PedidoCliente::filtro($filtro);
        $dados["status"]    = ConstanteService::listaStatusPedido();
        $dados["filtro"]    = $filtro;
        $dados["clientes"]  = Cliente::get();
        return view("Admin.PedidoCliente.Index", $dados);
    }    
    
    public function create()
    {
        $dados["produtos"] = Produto::get();
        return view("Admin.Loja.LojaPedido.Create", $dados);
    }

    public function gerarVendaPeloPedido($id){
        $pedido                     = PedidoCliente::find($id);

        if($pedido->venda_id){
            return redirect()->route('admin.venda.detalhe', $pedido->venda_id)->with("msg_erro", "Já existe uma venda para este pedido");
        }
        $venda = new \stdClass();
        $venda->data_venda          = hoje();
        $venda->pedido_cliente_id   = $pedido->id;
        $venda->cliente_id          = $pedido->cliente_id;
        $venda->status_id           = config("constantes.status.DIGITACAO");
        $venda->status_financeiro_id= config("constantes.status.ABERTO");
        $venda->valor_total         = $pedido->total;
        $venda->valor_frete         = 0;
        $venda->valor_imposto       = 0;
        $venda->total_seguro        = 0;
        $venda->despesas_outras     = 0;
        $venda->desconto_valor      = 0;
        $venda->desconto_per        = 0;
        $venda->valor_desconto      = 0;
        $venda->total_desconto_item = 0;
        $venda->valor_venda         = $pedido->total;
        $venda->valor_liquido       = $pedido->total;
        
        $novaVenda = Venda::Create(objToArray($venda));        
              
        foreach($pedido->itens as $i){
            $item = new \stdClass();
            $item->venda_id             = $novaVenda->id;
            $item->produto_id           = $i->produto_id;
            $item->quantidade           = $i->qtde;
            $item->valor                = $i->valor;
            $item->subtotal             = $i->subtotal;
            $item->subtotal_liquido     = $i->subtotal;
            $item->desconto_percentual  = 0;
            $item->desconto_por_valor   = 0;
            $item->desconto_por_unidade = 0;
            $item->total_desconto_item  = 0;
            $item->unidade              = $i->produto->unidade ?? "UNID" ;
            ItemVenda::Create(objToArray($item));
        }
        
        $pedido->data_atendimento = hoje();
        $pedido->venda_id         = $novaVenda->id;
        $pedido->status_id        = config("constantes.status.CONCRETIZADO");
        $pedido->save();
        
        return redirect()->route('admin.venda.edit', $novaVenda->id)->with("msg_sucesso", "Venda Criada com sucesso");
    }
    
    public function store(Request $request){      
        $req = $request->except(["_token","_method"]);
        LojaPedido::Create($req);
        return redirect()->route('admin.loja.lojapedido.index');
    }

    public function show($id)
    {
        $dados["pedido"] = PedidoCliente::find($id);
        return view("Admin.PedidoCliente.Show", $dados);
    }

    public function recusar($id)
    {
        PedidoCliente::where("id",$id)->update(["status_id"=>config("constantes.status.RECUSADO"),"data_atendimento"=>hoje()]) ;
        return redirect()->route('admin.pedidocliente.index');
    }
    
    public function excluir($id){
        try{
            $h = PedidoCliente::find($id);
            ItemPedidoCliente::where("pedido_id", $id)->delete();
            $h->delete();
            return redirect()->route('admin.pedidocliente.index')->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
    
    public function nfe($id){
        $dados["pedido"]            = LojaPedido::find($id);
        $dados["naturezas"]         = NaturezaOperacao::all();
        $dados["transportadoras"]   = Transportadora::all();
        $dados["cidades"]           = Cidade::all();
        
        return view("Admin.loja.LojaPedido.Emitir_nfe", $dados);
    }
    
   
    
    public function edit($id)
    {
        $dados["pedido"]        = LojaPedido::find($id);
        $dados["produtos"]      = Produto::get();
        return view('Admin.Loja.LojaPedido.Create', $dados);
    }

    public function update(Request $request, $id){
        $req     =   $request->except(["_token","_method"]);
        LojaPedido::where("id", $id)->update($req);
        return redirect()->route("admin.loja.lojapedido.index");
    }

    public function destroy($id){
        try{
            $h = LojaPedido::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Ítem apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
