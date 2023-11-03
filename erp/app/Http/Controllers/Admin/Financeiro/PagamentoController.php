<?php

namespace App\Http\Controllers\Admin\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\CentroCusto;
use App\Models\FinPagamento;
use App\Models\FormaPagto;
use App\Models\Fornecedor;
use Illuminate\Http\Request;

class PagamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filtro                 = new \stdClass();
        $filtro->forma_pagto_id = $_GET["forma_pagto_id"] ?? null;
        $filtro->data01         = $_GET["data01"]  ?? hoje();
        $filtro->data02         = $_GET["data02"]  ?? hoje();
        
        $dados["lista"]         = FinPagamento::filtro($filtro);
        $dados["filtro"]        = $filtro;
        $dados["mes"]           = 13;
        $dados["formas"]        = FormaPagto::get();
        return view("Admin.Financeiro.Pagamento.Index", $dados);
    }

    public function pormes()
    {
        $mes            = $_GET["mes"];
        $ano            = $_GET["ano"];
        $dados["lista"] = FinPagamento::whereMonth("data_pagamento", $mes)->whereYear("data_pagamento", $ano)->get();
        $dados["mes"]   = $mes; 
        $dados["formas"]= FormaPagto::get();
        return view("Admin.Financeiro.Pagamento.Index", $dados);
    }
    
    public function filtro()
    {
        $filtro                 = new \stdClass();
        $filtro->forma_pagto_id = $_GET["forma_pagto_id"];
        $filtro->data01         = $_GET["data01"];
        $filtro->data02         = $_GET["data02"];
        
        $dados["lista"]         = FinPagamento::filtro($filtro);
        $dados["filtro"]        = $filtro;
        $dados["mes"]           = 13;
        $dados["formas"]        = FormaPagto::get();
        return view("Admin.Financeiro.Pagamento.Index", $dados);
    }
    
    public function confirmarPagamento($id)
    {
        $dados["pagamento"]    = FinPagamento::find($id);
        $dados["formaPagto"]    = FormaPagto::all();
        $dados["fornecedores"]  = Fornecedor::get();
        $dados["centro_custos"] = CentroCusto::get();
        $dados["pagamentos"]    = array();
        return view("Admin.Financeiro.Pagamento.ConfirmarPagamento", $dados);
    }
    
       
   
    public function create()
    {
        $dados["formaPagto"]    = FormaPagto::all();
        $dados["fornecedores"]  = Fornecedor::get();
        $dados["centro_custos"] = CentroCusto::get();
        $dados["pagamentos"] = array();
        return view("Admin.Financeiro.Pagamento.Create", $dados);
    }

    
    public function store(Request $request)
    {
        $req = $request->except(["_token","_method"]);
        
        $conta = new \stdClass();
        $conta->descricao               = $req["descricao"];
        $conta->fornecedor_id           = $req["fornecedor_id"];
        $conta->centro_custo_id         = $req["centro_custo_id"];
        $conta->data_emissao            = $req["data_emissao"];
        $conta->valor                   = $req["valor"];
        $conta->qtde_parcela            = $req["qtdParcelas"];
        $conta->primeiro_vencimento     = $req["primeiro_vencimento"];
     
   
        return redirect()->route('admin.pagamento.index')->with('msg_sucesso', "Inserido com sucesso.");
    }

    public function pagar(Request $request)
    {
        $req = $request->except(["_token","_method"]);
       
        $conta = new \stdClass();
        $conta->usuario_id              = auth()->user()->id;
        $conta->descricao_pagamento     = "Conta a Pagar #" .$req["conta_pagar_id"];
        $conta->forma_pagto_id          = $req["forma_pagto_id"];
        $conta->data_pagamento          = hoje();
        $conta->numero_documento        = $req["numero_documento"];
        $conta->observacao              = $req["observacao"];
        $conta->valor_original          = $req["valor_original"];
        $conta->juros                   = $req["juros"];
        $conta->desconto                = $req["desconto"];
        $conta->multa                   = $req["multa"];
        $conta->valor_pago              = $conta->valor_original + $conta->juros + $conta->multa-$conta->desconto;
        $pag = FinPagamento::Create(objToArray($conta));
        if($pag){
            FinPagamento::where("id", $req["conta_pagar_id"])->update(["pagamento_id"=>$pag->id, "status_id"=>config("constantes.status.PAGO")]);
        }
        return redirect()->route('admin.pagamento.index')->with('msg_sucesso', "Conta Paga com sucesso.");
    }
    
    
    public function show($id)
    {
        $dados["pagamento"]    = FinPagamento::find($id);
        $dados["formaPagto"]    = FormaPagto::all();
        $dados["fornecedores"]  = Fornecedor::get();
        $dados["centro_custos"] = CentroCusto::get();
        $dados["pagamentos"] = array();
        return view("Admin.Financeiro.Pagamento.Detalhe", $dados);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
            $h = FinPagamento::find($id);            
                      
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            if($cod==23000){
                $mensagem = "Não é possível excluir este registro devido a Integridade Referencial dos Dados";
            }else{
                $mensagem = $e->getMessage();
            }
            return redirect()->back()->with('msg_erro', "Não é Possível Excluir:  [$mensagem]");
        }
    }
}
