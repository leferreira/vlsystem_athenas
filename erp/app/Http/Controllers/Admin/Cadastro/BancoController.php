<?php

namespace App\Http\Controllers\Admin\Cadastro;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Acl\PermissaoTrait;
use App\Models\Banco;
use App\Models\CentroCusto;
use App\Models\Fornecedor;
use App\Models\Produto;
use App\Models\Transportadora;
use Illuminate\Http\Request;
use App\Http\Requests\BancoRequest;

class BancoController extends Controller
{
    use PermissaoTrait;
    public function __construct(){
        $this->modelName = 'banco';
    }
    
    public function index()
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["bancos"] = Banco::get();
        return view("Admin.Cadastro.Banco.Index", $dados);
    }
    
    public function create()
    {
        $this->checaPermissao(__FUNCTION__);
        return view("Admin.Cadastro.Banco.Create");
    }

    public function salvarJs(Request $request){
        $req = $request->except(["_token","_method"]);
        Banco::Create($req);
        $lista = Banco::get();
        echo json_encode($lista);
    }
    
    public function listarBanco(){
        $lista = Banco::get();
        echo json_encode($lista);
    }
   
    public function store(BancoRequest $request){
        try {
            $this->checaPermissao(__FUNCTION__);
            $req = $request->except(["_token","_method"]);
            
            $tem = Banco::where(["codigo"=>$request->codigo ])->first();
            if($tem){
                throw(new \Exception('Ja existem um registro com este Código.'));
            }
            
            $tem2 = Banco::where(["variacao_grade_id"=>$request->banco ])->first();
            if($tem2){
                throw(new \Exception('Ja existem um registro com este Nome.'));
            }
            
            Banco::Create($req);
            return redirect()->route('admin.banco.index')->with('msg_sucesso', "Inserido com sucesso.");
        } catch (\Exception $e) {
            return redirect()->back()->with('msg_erro', "Erro: " . $e->getMessage());
        }
        
    }

    public function show($id)
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["fornecedores"]      = Fornecedor::get();
        $dados["transportadoras"]   = Transportadora::get();
        $dados["produtos"]          = Produto::get();
        $dados["centro_custos"]     = CentroCusto::get();
        $dados["excluirJS"]           = true;
        return view("Admin.Excluir.Create", $dados);
    }
   
    public function edit($id){
        $dados["banco"]     = Banco::find($id);
        $dados["bancos"]    = Banco::get();
        return view('Admin.Cadastro.Banco.Index', $dados);
    }
   
    public function update(Request $request, $id)
    {
        $this->checaPermissao(__FUNCTION__);
        $req     =   $request->except(["_token","_method"]);
        Banco::where("id", $id)->update($req);
        return redirect()->route("admin.banco.index")->with('msg_sucesso', "item alterado com sucesso.");;
    }

    
    public function destroy($id)
    {
        $this->checaPermissao(__FUNCTION__);
        try{
            $h = Banco::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
