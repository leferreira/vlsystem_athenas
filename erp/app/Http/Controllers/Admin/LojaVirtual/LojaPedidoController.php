<?php

namespace App\Http\Controllers\Admin\LojaVirtual;

use App\Http\Controllers\Controller;
use App\Models\LojaConfiguracao;
use App\Models\LojaItemPedido;
use App\Models\LojaPedido;
use App\Models\NaturezaOperacao;
use App\Models\Produto;
use App\Models\Venda;
use App\Service\ConstanteService;
use App\Service\ItemLojaPedidoService;
use Illuminate\Http\Request;
use App\Models\StatusEntrega;
use App\Models\FinContaReceber;

class LojaPedidoController extends Controller
{
    
    public function index()
    {
        $filtro = new \stdClass();
        $filtro->data1      = hoje();
        $filtro->data2      = hoje();
        $filtro->status_id  = null;
        $filtro->status_financeiro_id   = $_GET["status_financeiro_id"] ?? null;
        $filtro->cliente_id = null;
        
        $dados["status_financeiro"]     = ConstanteService::listaStatusFinanceiro();
        $dados["status"]                = ConstanteService::listaStatusVenda();
        $dados["lista"]                 = LojaPedido::filtro($filtro);
        $dados["filtro"]                = $filtro;
        $dados["naturezas"]             = NaturezaOperacao::where("tipo", "S")->get();
        
        return view("Admin.Loja.LojaPedido.Index", $dados);
        
    }
    
    public function create()
    {
        $dados["produtos"] = Produto::get();
        $dados["lojaPedidoJs"] = true;
        return view("Admin.Loja.LojaPedido.Create", $dados);
    }

    public function store(Request $request){    
        
        $req = $request->except(["_token","_method"]);
        LojaPedido::Create($req);
        return redirect()->route('admin.loja.lojapedido.index');
    }
    
    public function salvarVenda(Request $request){
        $dados                      = $request->venda;
        $venda                      = new \stdClass();
        $venda->usuario_id          = auth()->user()->id;
        $venda->cliente_id          = ($dados["cliente_id"]) ? $dados["cliente_id"] :null ;
        $venda->vendedor_id         = ($dados["vendedor_id"]) ? $dados["vendedor_id"] : null ;
        $venda->valor_frete         = $dados["valor_frete"] != null ? getFloat($dados["valor_frete"]) : 0;
        $venda->total_seguro        = $dados["total_seguro"] != null ? getFloat($dados["total_seguro"]) : 0;
        $venda->despesas_outras     = $dados["despesas_outras"] != null ? getFloat($dados["despesas_outras"]) : 0;
        $venda->desconto_valor      = $dados["desconto_valor"] != null ? getFloat($dados["desconto_valor"]) : 0;
        $venda->desconto_per        = $dados["desconto_per"] != null ? getFloat($dados["desconto_per"]) : 0;
        $venda->status_id           = config("constantes.status.DIGITACAO");
        $venda->data_venda          = hoje();
        $itens = (object) $dados["itens"];
        
        $retorno  = new \stdClass();
        
        try {
            $vendaNova = LojaPedido::Create(objToArray($venda));
            if($vendaNova){
                foreach($itens as $i){
                    $i["pedido_id"] = $vendaNova->id;
                    $i = (object) $i;
                    ItemLojaPedidoService::inserirItem($i);
                }
            }
            
            $retorno->tem_erro  = false;
            $retorno->titulo    = "Venda Salva com Sucesso";
            $retorno->erro      = "";
            $retorno->redirect  =  url("admin/lojapedido");
            $retorno->retorno   = $vendaNova->id;
            return response()->json($retorno);
            
        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->titulo    = "Erro ao Salvar Venda";
            $retorno->erro      = $e->getMessage();
            return response()->json($retorno);
        }
        
    }

    public function show($id)
    {
        //
    }

    public function detalhe($id){
        $dados["pedido"] = LojaPedido::find($id); 
        return view("Admin.loja.LojaPedido.Detalhe", $dados);
    }
    
    
    public function excluir($id){
        try{
            $h = LojaPedido::find($id);
            LojaItemPedido::where("pedido_id", $id)->delete();
            $h->delete();
            return redirect()->route('admin.loja.lojapedido.index')->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
  
    public function atualizarDados(Request $request){
        $req                          = $request->except(["_token","_method"]);        
        $retorno                        = new \stdClass();
        try {
            $venda                      = LojaPedido::find($req["id"]);            
            $venda->update($req);
            if($venda->data_separacao){
                $venda->status_entrega_id = config("constantes.status_entrega.SEPARACAO_PRODUTO");
            }
            
            if($venda->data_envio){
                $venda->status_entrega_id = config("constantes.status_entrega.ENVIADO_PARA_ENTREGA");
            }
            
            if($venda->data_entrega){
                $venda->status_entrega_id = config("constantes.status_entrega.ENTREGUE");
            }
            
            $venda->save();
            $retorno->tem_erro = false;
            $retorno->erro = "";
            return response()->json($retorno);
            
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return response()->json($retorno);
        }
        
    }
    
    public function edit($id)
    {
        $pedido                     = LojaPedido::find($id);
        $dados["pedido"]            = $pedido;
        $dados["produtos"]          = Produto::get();
        $dados["contas_receber"]    = FinContaReceber::where("loja_pedido_id", $id)->get();
        $dados["status"]            = StatusEntrega::get();
        $dados["unidades"]          = ConstanteService::unidadesMedida();
        $dados["lojaPedidoEditJs"]  = true;
        $dados["clienteJs"]         = true;
        $dados["vendedorJs"]        = true;
        if($pedido->status_id==config('constantes.status.FINALIZADO')){
            return view('Admin.Loja.LojaPedido.Show', $dados);
        }else{
            return view('Admin.Loja.LojaPedido.Show', $dados);
        }
        
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
