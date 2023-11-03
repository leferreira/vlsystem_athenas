<?php

namespace App\Http\Controllers\Admin\Cadastro;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Acl\PermissaoTrait;
use App\Http\Requests\ServicoRequest;
use App\Models\Categoria;
use App\Models\Produto;
use App\Models\TabelaPreco;
use Illuminate\Http\Request;
use App\Models\TabelaPrecoProduto;

class ServicoController extends Controller
{
    use PermissaoTrait;
    public function __construct(){
        $this->modelName = 'servico';
    }
    
    public function index()
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["categorias"]    = Categoria::get();
        $dados["servicos"]      = Produto::where("tipo_produto_id", config("constantes.tipo_produto.SERVICO"))->get();
        return view("Admin.Cadastro.Servico.Index", $dados);
    }
    
    
    public function filtro(Request $request){        
        $filtro                     = new \stdClass();
        $filtro->categoria_id       = $request->categoria_id;
        $filtro->nome               = $request->nome;
        
        $dados["produtos"]          = Produto::filtro($filtro);
        $dados["filtro"]            = $filtro;
        $dados["categorias"]        = Categoria::get();
        return view("Admin.Cadastro.Servico.Index", $dados);
    }
    
    public function create()    {
        $this->checaPermissao(__FUNCTION__);       
        return view("Admin.Cadastro.Servico.Create");
    }    
  
   
    public function salvarJs(ServicoRequest $request){
        $this->checaPermissao(__FUNCTION__);
        $retorno = new \stdClass();
        try {                        
            $servico                    = new \stdClass();
            $servico->nome              = $request->nome;
            $servico->valor_venda       = getFloat($request->valor_venda);
            $servico->unidade           = "SERVICO";
            $servico->tipo_produto_id   = config("constantes.tipo_produto.SERVICO");
            Produto::Create(objToArray($servico));            
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            $retorno->retorno   = Produto::where("tipo_produto_id", config("constantes.tipo_produto.SERVICO"))->get();
            return response()->json($retorno);           
            
        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->erro      = $e->getMessage();
            return response()->json($retorno);            
        }
        
    }
    public function store(ServicoRequest $request){   
        $this->checaPermissao(__FUNCTION__);
        try {    
      
            $req                        = $request->except(["_token","_method"]);        
            $req["unidade"]             = "SERVICO";
            $req["valor_venda"]         = getFloat($req["valor_venda"]);
            $req["valor_custo"]         = getFloat($req["valor_venda"]);
            $req["tipo_produto_id"]     = config("constantes.tipo_produto.SERVICO");
            Produto::Create(objToArray($req));        
       
            return redirect()->route('admin.servico.index')->with('msg_sucesso', "Produto Inserido com sucesso.");
        
        } catch (\Exception $e) {
            return redirect()->back()->with('msg_erro', $e->getMessage());
        }
    }

    public function show($id)
    {
        //
    }
    
    public function edit($id)
    {
        $dados["produto"]               = Produto::where([ "id"=>$id])->first();    
        return view('Admin.Cadastro.Servico.Create', $dados);
    }
    
  
    
    public function update(Request $request, $id){    
        $req                    = $request->except(["_token","_method"]);
        try {                    
            $req['valor_venda']	        = getFloat($req['valor_venda']);
            $req['valor_custo']	        = getFloat($req['valor_venda']);                  
          
            Produto::where("id", $id)->update(objToArray($req)); 
            return redirect()->route('admin.servico.index')->with('msg_sucesso', "Produto Inserido com sucesso.");
        
        } catch (\Exception $e) {
            return redirect()->back()->with('msg_erro', $e->getMessage());            
        }
    }
 
    
    public function destroy($id)
    {
        $this->checaPermissao(__FUNCTION__);
        try{
            TabelaPrecoProduto::where("produto_id", $id)->delete();
            $h = Produto::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Produto excluído com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Erro: " .$e->getMessage());
        }
    }    
  
}
