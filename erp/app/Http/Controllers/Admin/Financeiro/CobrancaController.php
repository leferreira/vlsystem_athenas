<?php

namespace App\Http\Controllers\Admin\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\CentroCusto;
use App\Models\Cobranca;
use App\Models\FinPagamento;
use App\Models\FormaPagto;
use App\Models\Fornecedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FinContaReceber;
use App\Models\FinRecebimento;

class CobrancaController extends Controller{
    public function index()
    {
       
        $dados["lista"] = Cobranca::whereMonth("data_vencimento", date('m'))->whereYear("data_vencimento", date('Y'))->get();
        $dados["mes"]   = date('m');
        return view("Admin.Financeiro.Cobranca.Index", $dados);
    }
    
    public function pormes()
    {
        $mes            = $_GET["mes"];
        $ano            = $_GET["ano"];
        $dados["lista"] = Cobranca::whereMonth("data_vencimento", $mes)->whereYear("data_vencimento", $ano)->get();
        $dados["mes"]   = $mes;
        return view("Admin.Financeiro.Cobranca.Index", $dados);
    }
    
    public function filtro()
    {
        $filtro                 = new \stdClass();
        $filtro->status_id      = $_GET["status_id"];
        $filtro->venc01         = $_GET["venc01"];
        $filtro->venc02         = $_GET["venc02"];
        $filtro->emissao01      = $_GET["emissao01"];
        $filtro->emissao02      = $_GET["emissao02"];
        
        $dados["lista"]         = Cobranca::filtro($filtro);
        $dados["filtro"]        = $filtro;
        $dados["mes"]           = 13;
        return view("Admin.Financeiro.Cobranca.Index", $dados);
    }
  


    
    public function detalhe($id)
    {
        $dados["cobranca"]        = Cobranca::find($id);
        $dados["formaPagto"]    = FormaPagto::all();
        $dados["fornecedores"]  = Fornecedor::get();
        $dados["centro_custos"] = CentroCusto::get();
        $dados["pagamentos"] = array();
        return view("Admin.Financeiro.Cobranca.Show", $dados);
    }
    
   
    public function create()
    {
        $dados["formaPagto"]    = FormaPagto::all();
        $dados["fornecedores"]  = Fornecedor::get();
        $dados["centro_custos"] = CentroCusto::get();
        $dados["pagamentos"] = array();
        return view("Admin.Financeiro.Cobranca.Create", $dados);
    }

    public function confirmarPagamento($id)
    {
        $fatura = Cobranca::find($id);
        if($fatura->pagamento_id){
            return redirect()->route('admin.fatura.detalhe', $id)->with('msg_erro', "Essa Fatura não pode mais ser modificada.");
        }
        
        $dados["fatura"]        = $fatura;
        $dados["empresa"]       = Auth::user()->empresa()->first();
        $dados["formaPagto"]    = FormaPagto::all();
        $dados["fornecedores"]  = Fornecedor::get();
        $dados["centro_custos"] = CentroCusto::get();
        $dados["mercadoPagoJs"] = true;
        $dados["pagamentos"]    = array();
        return view("Admin.Financeiro.Fatura.PagarFatura", $dados);
    }
    
    public function store(Request $request)
    {
        $req = $request->except(["_token","_method"]);
        
        $conta = new \stdClass();
        $conta->descricao               = $req["descricao"];
        $conta->observacao              = $req["observacao"];
        $conta->data_emissao            = $req["data_emissao"];
        $conta->valor                   = $req["valor"];
        $conta->data_vencimento         = $req["data_vencimento"];     
        Cobranca::Create(objToArray($conta));
        return redirect()->route('admin.cobranca.index')->with('msg_sucesso', "Inserido com sucesso.");
    }

    public function pagar(Request $request)
    {
        $req = $request->except(["_token","_method"]);
       
        $conta = new \stdClass();
        $conta->usuario_id              = auth()->user()->id;
        $conta->descricao_pagamento     = "Cobranca #" .$req["cobranca_id"];
        $conta->forma_pagto_id          = $req["forma_pagto_id"];
        $conta->data_pagamento          = hoje();
        $conta->numero_documento        = $req["numero_documento"];
        $conta->observacao              = $req["observacao"];
        $conta->valor_original          = $req["valor_original"];
        $conta->juros                   = $req["juros"];
        $conta->desconto                = $req["desconto"];
        $conta->multa                   = $req["multa"];        
        $conta->tipo_documento          = $req["tipo_documento"];
        $conta->documento_id            = $req["cobranca_id"];
        $conta->valor_pago              = $conta->valor_original + $conta->juros + $conta->multa-$conta->desconto;
        $pag                            = FinPagamento::Create(objToArray($conta));
        if($pag){
            Cobranca::where("id", $req["cobranca_id"])->update(["pagamento_id"=>$pag->id, "status_id"=>config("constantes.status.PAGO")]);
        }
        return redirect()->route('admin.cobranca.index')->with('msg_sucesso', "Conta Paga com sucesso.");
    }
    
    
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dados["cobranca"]      = Cobranca::find($id);
        $dados["formaPagto"]    = FormaPagto::all();
        $dados["fornecedores"]  = Fornecedor::get();
        $dados["centro_custos"] = CentroCusto::get();
        $dados["pagamentos"] = array();
        return view("Admin.Financeiro.Cobranca.Edit", $dados);
    }

   
    public function update(Request $request, $id)
    {
        $cobranca = Cobranca::find($id);
        $cobranca->descricao    = $request->descricao;
        $cobranca->valor        = getFloat($request->valor);
        $cobranca->data_vencimento = $request->data_vencimento;
        $cobranca->save();
        return redirect()->route('admin.cobranca.index')->with('msg_sucesso', "Conta Paga com sucesso.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{            
            $h = Cobranca::find($id);
            $receber = FinContaReceber::where("cobranca_id", $h->id)->first();
            $recebimentos = FinRecebimento::where("conta_receber_id", $receber->id)->get();
            if($recebimentos){
                foreach($recebimentos as $rec){
                    $rec->delete();
                }
                
                $receber->delete();
            }
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            return redirect()->back()->with('msg_erro', "erro: " . $e->getMessage());
        }
    }
}
