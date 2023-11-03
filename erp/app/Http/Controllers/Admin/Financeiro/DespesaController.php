<?php

namespace App\Http\Controllers\Admin\Financeiro;

use App\Http\Controllers\Controller;
use App\Http\Requests\DespesaRequest;
use App\Models\ClassificacaoFinanceira;
use App\Models\ContaCorrente;
use App\Models\FinDespesa;
use App\Models\FinPagamento;
use App\Models\FinTipoDespesa;
use App\Models\FormaPagto;
use App\Models\Fornecedor;
use Illuminate\Http\Request;
use App\Models\FinContaPagar;

class DespesaController extends Controller
{
    public function index()
    {
        $dados["lista"]         = FinDespesa::whereMonth("data_vencimento", date('m'))->whereYear("data_vencimento", date('Y'))->get(); 
        $dados["mes"]           = date('m');
        $dados["fornecedores"]  = Fornecedor::get(); 
        $dados["tipos"]         = FinTipoDespesa::get(); 
        return view("Admin.Financeiro.Despesa.Index", $dados);
    }

    public function pormes()
    {
        $mes                    = $_GET["mes"];
        $ano                    = $_GET["ano"];
        $dados["lista"]         = FinDespesa::whereMonth("data_vencimento", $mes)->whereYear("data_vencimento", $ano)->get();
        $dados["mes"]           = $mes;  
        $dados["fornecedores"]  = Fornecedor::get(); 
        $dados["tipos"]         = FinTipoDespesa::get(); 
        return view("Admin.Financeiro.Despesa.Index", $dados);
    }
    
    public function filtro()
    {
        $filtro                 = new \stdClass();
        $filtro->fornecedor_id  = $_GET["fornecedor_id"];
        $filtro->tipo_despesa_id= $_GET["tipo_despesa_id"];
        $filtro->status_id      = $_GET["status_id"];
        $filtro->venc01         = $_GET["venc01"];
        $filtro->venc02         = $_GET["venc02"];
        $filtro->emissao01      = $_GET["emissao01"];
        $filtro->emissao02      = $_GET["emissao02"];
        
        $dados["lista"]         = FinDespesa::filtro($filtro);
        $dados["filtro"]        = $filtro;
        $dados["mes"]           = 13;
        $dados["fornecedores"]  = Fornecedor::get();
        $dados["tipos"]         = FinTipoDespesa::get(); 
        return view("Admin.Financeiro.Despesa.Index", $dados);
    }

    
    public function create()
    {
        $dados["tipos"]        = FinTipoDespesa::all();
        $dados["fornecedores"] = Fornecedor::all();
        $dados["fornecedorJs"] = true;
        $dados["tipoDespesaJs"]= true;
        $dados["despesaJs"]= true;
        return view("Admin.Financeiro.Despesa.Create", $dados);
    }

    public function confirmarPagamento($id)
    {
        $contapagar      = FinContaPagar::where("despesa_id", $id)->first();
        if($contapagar){
            return redirect()->route('admin.contapagar.confirmarPagamento', $contapagar->id);
        }
    }
    
    public function pagar(Request $request)
    {
        $req = $request->except(["_token","_method"]);
        
        $conta = new \stdClass();
        $conta->usuario_id              = auth()->user()->id;
        $conta->descricao_pagamento     = "Despesa #" .$req["despesa_id"];
        $conta->forma_pagto_id          = $req["forma_pagto_id"];
        $conta->data_pagamento          = hoje();
        $conta->numero_documento        = $req["numero_documento"];
        $conta->observacao              = $req["observacao"];
        $conta->valor_original          = ($req["valor_original"]) ? getFloat($req["valor_original"]) : 0;;
        $conta->juros                   = ($req["juros"]) ? getFloat($req["juros"]) : 0;
        $conta->desconto                = ($req["desconto"]) ? getFloat($req["desconto"]) : 0 ;
        $conta->multa                   = ($req["multa"]) ? getFloat($req["multa"]) : 0;  
             
        $conta->tipo_documento          = $req["tipo_documento"];
        $conta->documento_id            = $req["despesa_id"];
        $conta->valor_pago              = $conta->valor_original + $conta->juros + $conta->multa-$conta->desconto;
        $pag = FinPagamento::Create(objToArray($conta));
        if($pag){
            FinDespesa::where("id", $req["despesa_id"])->update(["pagamento_id"=>$pag->id, "status_id"=>config("constantes.status.PAGO")]);
        }
        return redirect()->route('admin.despesa.index')->with('msg_sucesso', "Conta Paga com sucesso.");
    }
    
    public function store(DespesaRequest $request){
        $req        = $request->all();
        $repete = $req["repete"];
        for($i=0;$i<$repete; $i++){
            $lancamento = new \stdClass();
            $lancamento->tipo_despesa_id 		= $req['tipo_despesa_id'];
            $lancamento->fornecedor_id 	        = $req['fornecedor_id'];
            $lancamento->valor_despesa 		    = getFloat($req['valor_despesa']);
            $lancamento->data_lancamento        = $req['data_lancamento'];
            $lancamento->data_vencimento        = somarData($req['primeiro_vencimento'], 30 * $i);
            $lancamento->descricao 		        = $req['descricao'];
            FinDespesa::create(objToArray($lancamento));
        }        
        return redirect()->route("admin.despesa.index");
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $dados["despesa"]       = FinDespesa::find($id);
        
        $dados["tipos"]        = FinTipoDespesa::all();
        return view("Admin.Financeiro.Despesa.Edit", $dados);
    }

    
    public function update(Request $request, $id)
    {
        $retorno = new \stdClass();
        try {
            $req                    = $request->except(["_token","_method"]);
            $req["valor_despesa"]   = ($req["valor_despesa"]) ? getFloat($req["valor_despesa"]) : NULL;
            
            FinDespesa::where("id", $id)->update($req);
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            return redirect()->route('admin.despesa.index')->with('msg_sucesso', "Alterado com sucesso.");
            
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return redirect()->back()->with('msg_erro', $e->getMessage());
            
        }
    }

   
    public function destroy($id)
    {
        try{
            $h = FinDespesa::find($id);
            $h->delete();
            return json_encode(1);
            //return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return json_encode(1);
            //return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
