<?php

namespace App\Http\Controllers\Admin\Recorrencia;

use App\Http\Controllers\Controller;
use App\Models\ItemProdutoRecorrente;
use App\Models\Produto;
use App\Models\ProdutoRecorrente;
use Illuminate\Http\Request;

class ProdutoRecorrenteController extends Controller{    
    
    public function index(){      
        $filtro = new \stdClass();
        $filtro->data1      = hoje();
        $filtro->data2      = hoje();
        $filtro->status_id  = null;
        $filtro->cliente_id = null;
        
        $dados["lista"]                 = ProdutoRecorrente::get();
        $dados["filtro"]                = $filtro;
        
        return view("Admin.Recorrencia.ProdutoRecorrente.Index", $dados);   
        
    }
    
    public function create(){      
      
        return view("Admin.Recorrencia.ProdutoRecorrente.Create");
    }    
    
    public function edit($id){
        $dados["produtorecorrente"]       = ProdutoRecorrente::find($id); 
        $dados["produtos"]                = Produto::where("tipo_produto_id", config("constantes.tipo_produto.PRODUTO"))->get();
        $dados["servicos"]                = Produto::where("tipo_produto_id", config("constantes.tipo_produto.SERVICO"))->get();
        
        $dados["lista_produtos"]          = ItemProdutoRecorrente::where("produto_id", "!=", Null)->where("produto_recorrente_id", $id)->get();
        $dados["lista_servicos"]          = ItemProdutoRecorrente::where("servico_id", "!=", Null)->where("produto_recorrente_id", $id)->get();   
        $dados["servicoJs"]               = true;
        $dados["produtoJs"]               = true;
        $dados["produtoRecorrenteJs"]     = true;
        return view("Admin.Recorrencia.ProdutoRecorrente.Edit", $dados);
    }
    
    public function store(Request $request){
        $req = $request->except(["_token","_method"]);
        $retorno  = new \stdClass();
        try {
          
           // $req["status_id"]       = config('constantes.status.DIGITACAO');
            $req["valor"]           = getFloat($req["valor"]);
            $recorrencia            = ProdutoRecorrente::Create($req);            
            return redirect()->route('admin.produtorecorrente.edit', $recorrencia->id)->with('msg_sucesso', "Inserido com sucesso.");
            
        } catch (\Exception $e) {
            return redirect()->back()->with('msg_erro', $e->getMessage());
        }
     }
    
     public function update(Request $request, $id){
         
         $req                    = $request->except(["_token","_method",  "file"]);
         
         try {
            // $req["status_id"]       = config('constantes.status.ATIVO');
             $req["valor"]           = getFloat($req["valor"]);           
            
             
             ProdutoRecorrente::where("id", $id)->update(objToArray($req));
             return redirect()->route('admin.produtorecorrente.index')->with('msg_sucesso', "Produto Inserido com sucesso.");
             
         } catch (\Exception $e) {
             return redirect()->back()->with('msg_erro', $e->getMessage());
         }
     }
     
     public function buscaPorId(){
         $id          = $_GET["id"];
         $produtos   = ProdutoRecorrente::find($id);
         
         return response()->json($produtos);
     }
     
     public function inserirServico(Request $request){
         $req = $request->except(["_token","_method"]);
         $retorno  = new \stdClass();
         try {
             
             $produto            = Produto::find($request->servico_id);
             $req["status_id"]   = config('constantes.status.DIGITACAO');
             $req["valor"]       = $produto->valor_venda;
             $req["subtotal"]    = $produto->valor_venda * $req["quantidade"];
             $recorrencia        = ItemProdutoRecorrente::Create($req);
             ProdutoRecorrente::somarTotal($req["produto_recorrente_id"]);
             
             $retorno->tem_erro  = false;
             $retorno->titulo    = "Venda Salva com Sucesso";
             $retorno->erro      = "";
             $retorno->redirect  =  url("admin/produtorecorrencia/edit",$recorrencia->id );
             $retorno->retorno   = $recorrencia->id;
             return response()->json($retorno);
             
         } catch (\Exception $e) {
             $retorno->tem_erro  = true;
             $retorno->titulo    = "Erro ao Salvar Venda";
             $retorno->erro      = $e->getMessage();
             return response()->json($retorno);
         }
     }
     
     public function inserirProduto(Request $request){
         $req = $request->except(["_token","_method"]);
         $retorno  = new \stdClass();
         try {
             $produto            = Produto::find($request->produto_id); 
             $req["status_id"]   = config('constantes.status.DIGITACAO');
             $req["valor"]       = $produto->valor_venda;
             $req["quantidade"]  = getFloat($req["quantidade"]);
             $req["subtotal"]    = $produto->valor_venda * $req["quantidade"];
             
             $recorrencia        = ItemProdutoRecorrente::Create($req);
             ProdutoRecorrente::somarTotal($req["produto_recorrente_id"]);
             
             $retorno->tem_erro  = false;
             $retorno->titulo    = "Venda Salva com Sucesso";
             $retorno->erro      = "";
             $retorno->redirect  =  url("admin/recorrencia/edit",$recorrencia->id );
             $retorno->retorno   = $recorrencia->id;
             return response()->json($retorno);
             
         } catch (\Exception $e) {
             $retorno->tem_erro  = true;
             $retorno->titulo    = "Erro ao Salvar Venda";
             $retorno->erro      = $e->getMessage();
             return response()->json($retorno);
         }
     }

     public function excluirItem($id){
         $item =  ItemProdutoRecorrente::find($id);
         try {
             $item->delete();    
             ProdutoRecorrente::somarTotal($item->produto_recorrente_id);
             return redirect()->back()->with('msg_sucesso', "Inserido com sucesso.");
             
         } catch (\Exception $e) {
             return redirect()->back()->with('msg_ero', $e->getMessage());
         }
     }
    
   
    
}
