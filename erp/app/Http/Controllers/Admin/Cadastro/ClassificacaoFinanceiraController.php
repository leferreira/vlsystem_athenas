<?php

namespace App\Http\Controllers\Admin\Cadastro;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Acl\PermissaoTrait;
use App\Models\CentroCusto;
use App\Models\ClassificacaoFinanceira;
use App\Models\Fornecedor;
use App\Models\Produto;
use App\Models\Transportadora;
use Illuminate\Http\Request;

class ClassificacaoFinanceiraController extends Controller
{
    use PermissaoTrait;
    public function __construct(){
        $this->modelName = 'classificacaofinanceira';
    }
    
    public function index()
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["lista"] = ClassificacaoFinanceira::get();
        return view("Admin.Cadastro.ClassificacaoFinanceira.Index", $dados);
    }
    
    public function create()
    {
        $this->checaPermissao(__FUNCTION__);
        return view("Admin.Cadastro.ClassificacaoFinanceira.Create");
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
        $dados["classificacaofinanceira"]     = ClassificacaoFinanceira::find($id);
        $dados["lista"]    = ClassificacaoFinanceira::get();
        return view('Admin.Cadastro.ClassificacaoFinanceira.Index', $dados);
    }
   
    public function store(Request $request){
        $req = $request->except(["_token","_method"]);
        ClassificacaoFinanceira::Create($req);
        return redirect()->route('admin.classificacaofinanceira.index')->with('msg_sucesso', "Inserido com sucesso.");
    }
    
    public function update(Request $request, $id)
    {
        $req     =   $request->except(["_token","_method"]);
        ClassificacaoFinanceira::where("id", $id)->update($req);
        return redirect()->route("admin.classificacaofinanceira.index")->with('msg_sucesso', "item alterado com sucesso.");;
    }

    
    public function destroy($id)
    {
        $this->checaPermissao(__FUNCTION__);
        try{
            $h = ClassificacaoFinanceira::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
