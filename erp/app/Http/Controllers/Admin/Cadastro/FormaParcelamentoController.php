<?php

namespace App\Http\Controllers\Admin\Cadastro;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Acl\PermissaoTrait;
use App\Models\CentroCusto;
use App\Models\ClassificacaoFinanceira;
use App\Models\ContaCorrente;
use App\Models\FormaParcelamento;
use App\Models\Fornecedor;
use App\Models\OperadoraCartao;
use App\Models\Produto;
use App\Models\Transportadora;
use Illuminate\Http\Request;

class FormaParcelamentoController extends Controller
{
    use PermissaoTrait;
    public function __construct(){
        $this->modelName = 'banco';
    }
    
    public function index()
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["lista"] = FormaParcelamento::get();
        $dados["operadoras"] = OperadoraCartao::get();
        $dados["contas"] = ContaCorrente::get();
        $dados["classificacoes"] = ClassificacaoFinanceira::get();
        return view("Admin.Cadastro.Administradora.Index", $dados);
    }
    
    public function create()
    {
        $this->checaPermissao(__FUNCTION__);
        return view("Admin.Cadastro.Administradora.Create");
    }

    public function salvarJs(Request $request){
        $req = $request->except(["_token","_method"]);
        FormaParcelamento::Create($req);
        $lista = FormaParcelamento::get();
        echo json_encode($lista);
    }
    
    public function formas($id){
        $dados["administradora"] = FormaParcelamento::find($id);
        return view("Admin.Cadastro.Administradora.Formas", $dados);
    }
   
    public function store(Request $request){
        $this->checaPermissao(__FUNCTION__);
        $req = $request->except(["_token","_method"]);
        $req["taxa"]        = $req["taxa"] ? getFloat($req["taxa"]) : 0;
        $req["acrescimo"]   = $req["acrescimo"] ? getFloat($req["acrescimo"]) : 0;
        $req["desconto"]    = $req["desconto"] ? getFloat($req["desconto"]) : 0;
        $req["valor_minimo"]= $req["valor_minimo"] ? getFloat($req["valor_minimo"]) : 0;
        
        FormaParcelamento::Create($req);
        return redirect()->route('admin.administradora.formas', $req["administradora_cartao_id"])->with('msg_sucesso', "Inserido com sucesso.");
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
        $dados["banco"]     = FormaParcelamento::find($id);
        $dados["bancos"]    = FormaParcelamento::get();
        return view('Admin.Cadastro.Administradora.Index', $dados);
    }
   
    public function update(Request $request, $id)
    {
        $this->checaPermissao(__FUNCTION__);
        $req     =   $request->except(["_token","_method"]);
        FormaParcelamento::where("id", $id)->update($req);
        return redirect()->route("admin.administradora.index")->with('msg_sucesso', "item alterado com sucesso.");;
    }

    
    public function destroy($id)
    {
        $this->checaPermissao(__FUNCTION__);
        try{
            $h = FormaParcelamento::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
