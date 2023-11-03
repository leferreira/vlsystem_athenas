<?php

namespace App\Http\Controllers\Admin\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\CentroCusto;
use App\Models\ClassificacaoFinanceira;
use App\Models\ContaCorrente;
use App\Models\FinPagamento;
use App\Models\FormaPagto;
use App\Models\Fornecedor;
use App\Models\MovimentoConta;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;


class MovimentoContaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $filtro                     = new \stdClass();
        $filtro->compensacao01      = $_GET["compensacao01"] ?? hoje();
        $filtro->compensacao02      = $_GET["compensacao02"] ?? hoje();
        $filtro->data_emissao01     = $_GET["data_emissao01"] ?? null;
        $filtro->data_emissao02     = $_GET["data_emissao02"] ?? null;
        $filtro->classificacao_id   = $_GET["classificacao_id"] ?? null;
        $filtro->conta_id           = $_GET["conta_id"] ?? null;
        $filtro->tipo               = $_GET["tipo"] ?? null;
      
        
        $dados["lista"]         = MovimentoConta::filtro($filtro, 20);
      
        $dados["filtro"]        = $filtro;
        $dados["mes"]           = 13;
        $dados["fornecedores"]  = Fornecedor::get();
        $dados["contas"]        = ContaCorrente::get();
        $dados["classificacoes"]      = ClassificacaoFinanceira::get();
        
        return view("Admin.Financeiro.MovimentoConta.Index", $dados);
    }

    public function pormes()
    {
        $mes            = $_GET["mes"];
        $ano            = $_GET["ano"];
        $dados["lista"] = MovimentoConta::whereMonth("data_emissao", $mes)->whereYear("data_emissao", $ano)->get();
        $dados["mes"]   = $mes;  
        $dados["fornecedores"]  = Fornecedor::get(); 
        return view("Admin.Financeiro.MovimentoConta.Index", $dados);
    }
    
    public function filtro()
    {
        $filtro                     = new \stdClass();
        $filtro->status_id          = $_GET["status_id"] ?? null;
        $filtro->compensacao01      = $_GET["compensacao01"] ?? hoje();
        $filtro->compensacao02      = $_GET["compensacao02"] ?? hoje();
        $filtro->data_emissao01     = $_GET["data_emissao01"] ?? null;
        $filtro->data_emissao02     = $_GET["data_emissao02"] ?? null;
        $filtro->classificacao_id   = $_GET["classificacao_id"] ?? null;
        $filtro->conta_id           = $_GET["conta_id"] ?? null;
        
        $dados["lista"]         = MovimentoConta::filtro($filtro);
        $dados["filtro"]        = $filtro;
        $dados["mes"]           = 13;
        $dados["fornecedores"]  = Fornecedor::get();
        $dados["contas"]        = ContaCorrente::get();
        $dados["classificacoes"]      = ClassificacaoFinanceira::get();
        return view("Admin.Financeiro.MovimentoConta.Index", $dados);
    }
    
 
    public function extrato01(Request $request)
    {
        $filtro                 = new \stdClass();
        $filtro->conta_id       = $_GET["conta_id"] ?? ContaCorrente::first();
        $filtro->compensacao01  = $_GET["compensacao01"] ?? hoje();
        $filtro->compensacao02  = $_GET["compensacao02"] ?? hoje();
        
        $dados["conta"]         = MovimentoConta::extrato($filtro);
        $dados["filtro"]        = $filtro;
        $dados["contas"]        = ContaCorrente::get();
        return view("Admin.Financeiro.MovimentoConta.Extrato01", $dados);
    }
    
    public function fluxoConta(Request $request)
    {
        $options = new Options();
        $options->setIsRemoteEnabled(true);
        $dompdf          = new Dompdf($options);
        $dados["dompdf"]     = $dompdf;   
        $dados["contas"]        = ContaCorrente::get();
        return view("Admin.Pdf.MovimentoConta.FluxoConta", $dados);
    }
    
    public function resumoFinanceiro(Request $request)
    {
        $options = new Options();
        $options->setIsRemoteEnabled(true);
        $dompdf          = new Dompdf($options);        
        $dados["dompdf"]     = $dompdf;        
        $dados["contas"]        = ContaCorrente::get();
        return view("Admin.Pdf.MovimentoConta.ResumoFinanceiro", $dados);
    }
    
    public function extrato(Request $request)
    {
        $options = new Options();
        $options->setIsRemoteEnabled(true);
        $dompdf          = new Dompdf($options);
        $dados["dompdf"]     = $dompdf;   
        $dados["contas"]        = ContaCorrente::get();
        return view("Admin.Pdf.MovimentoConta.Extrato", $dados);
    }
    
    public function detalhe($id)
    {
        $dados["movimentoconta"]    = MovimentoConta::find($id);
       
        $dados["formaPagto"]        = FormaPagto::all();
        $dados["fornecedores"]      = Fornecedor::get();
        $dados["centro_custos"]     = CentroCusto::get();
        $dados["pagamentos"]        = array();
        return view("Admin.Financeiro.MovimentoConta.Detalhe", $dados);
    }
    
   
    public function create()
    {
        $dados["contas"]            = ContaCorrente::get();
        $dados["classificacoes"]    = ClassificacaoFinanceira::get();
        $dados["pagamentos"] = array();
        return view("Admin.Financeiro.MovimentoConta.Create", $dados);
    }

    public function saldo()
    {
        $dados["lista"]             = ContaCorrente::saldo();
        return view("Admin.Financeiro.MovimentoConta.Saldo", $dados);
    }
    
    public function store(Request $request)
    {
        $req = $request->except(["_token","_method"]);
        $req["valor"]               = ($req["valor"]) ? getFloat($req["valor"]) : 0 ;
        MovimentoConta::Create($req);
        return redirect()->route('admin.movimentoconta.index')->with('msg_sucesso', "Inserido com sucesso.");
    }

    public function pagar(Request $request)
    {
        
        $req = $request->except(["_token","_method"]);
        //Altera o status do conta_a_pagar para pago        
        
        
        $conta = new \stdClass();
        $conta->usuario_id              = auth()->user()->id;
        $conta->descricao_pagamento     = "Conta a Pagar #" .$req["conta_pagar_id"];
        $conta->forma_pagto_id          = $req["forma_pagto_id"];
        $conta->data_pagamento          = hoje();
        $conta->numero_documento        = $req["numero_documento"];
        $conta->observacao              = $req["observacao"];
        $conta->valor_original          = ($req["valor_original"]) ? getFloat($req["valor_original"]) : 0;;
        $conta->juros                   = ($req["juros"]) ? getFloat($req["juros"]) : 0;
        $conta->desconto                = ($req["desconto"]) ? getFloat($req["desconto"]) : 0 ;
        $conta->multa                   = ($req["multa"]) ? getFloat($req["multa"]) : 0;        
        $conta->tipo_documento          = $req["tipo_documento"];
        $conta->documento_id            = $req["conta_pagar_id"];
        $conta->valor_pago              = $conta->valor_original + $conta->juros + $conta->multa-$conta->desconto;
        $pag                            = FinPagamento::Create(objToArray($conta));
        
        if($pag){ 
            $contaPagar                 = MovimentoConta::where("id", $req["conta_pagar_id"])->first();
           $contaPagar->pagamento_id   = $pag->id;
            $contaPagar->status_id      = config("constantes.status.PAGO");
            $contaPagar->save();
                   
            if($contaPagar->compra){
                if($contaPagar->compra->foiPaga()){
                    $contaPagar->compra->status_id = config("constantes.status.PAGO");                    
                }else{
                    $contaPagar->compra->status_id = config("constantes.status.PARCIALMENTE_PAGO");
                }
                $contaPagar->compra->save();
            }
        }
        return redirect()->route('admin.movimentoconta.index')->with('msg_sucesso', "Conta Paga com sucesso.");
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
        
        $dados["movimentoconta"]    = MovimentoConta::find($id);
        $dados["formaPagto"]    = FormaPagto::all();
        $dados["fornecedores"]  = Fornecedor::get();
        $dados["centro_custos"] = CentroCusto::get();
        $dados["pagamentos"] = array();
        return view("Admin.Financeiro.MovimentoConta.Create", $dados);
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
        $retorno = new \stdClass();
        try {
            $req             = $request->except(["_token","_method"]);
            $req["valor"]               = ($req["valor"]) ? getFloat($req["valor"]) : 0 ;
            
            MovimentoConta::where("id", $id)->update($req);
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            return redirect()->route('admin.movimentoconta.index')->with('msg_sucesso', "Alterado com sucesso.");
            
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
             return redirect()->back()->with('msg_erro', $e->getMessage());
            
        }
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
            $h = MovimentoConta::find($id);
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
