<?php

namespace App\Http\Controllers\Admin\Cadastro;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Acl\PermissaoTrait;
use App\Http\Requests\ContaCorrenteRequest;
use App\Models\Banco;
use App\Models\CentroCusto;
use App\Models\ContaCorrente;
use App\Models\Fornecedor;
use App\Models\Produto;
use App\Models\TipoContaCorrente;
use App\Models\Transportadora;
use Illuminate\Http\Request;

class ContaCorrenteController extends Controller
{
    use PermissaoTrait;
    public function __construct(){
        $this->modelName = 'contacorrente';
    }
    
    public function index()
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["lista"]     = ContaCorrente::get();
        $dados["bancos"]    = Banco::get();
        $dados["tipos"]     = TipoContaCorrente::get();
        return view("Admin.Cadastro.ContaCorrente.Index", $dados);
    }
    
    public function create()
    {
        $this->checaPermissao(__FUNCTION__);
        return view("Admin.Cadastro.ContaCorrente.Create");
    }

   
    
    public function store(ContaCorrenteRequest $request){
        try {
            $this->checaPermissao(__FUNCTION__);
            $req = $request->except(["_token","_method"]);
            ContaCorrente::Create($req);
            return redirect()->route('admin.contacorrente.index')->with('msg_sucesso', "Inserido com sucesso.");
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
        $dados["contacorrente"] = ContaCorrente::find($id);
        $dados["lista"]         = ContaCorrente::get();
        $dados["tipos"]         = TipoContaCorrente::get();
        $dados["bancos"]        = Banco::get();
        return view('Admin.Cadastro.ContaCorrente.Index', $dados);
    }
   
    public function update(Request $request, $id)
    {
        $this->checaPermissao(__FUNCTION__);
        $req     =   $request->except(["_token","_method"]);
        ContaCorrente::where("id", $id)->update($req);
        return redirect()->route("admin.contacorrente.index")->with('msg_sucesso', "item alterado com sucesso.");;
    }

    
    public function destroy($id)
    {
        $this->checaPermissao(__FUNCTION__);
        try{
            $h = ContaCorrente::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
