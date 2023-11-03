<?php

namespace App\Http\Controllers\Admin\Financeiro;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContaReceberRequest;
use App\Models\CentroCusto;
use App\Models\ClassificacaoFinanceira;
use App\Models\Cliente;
use App\Models\ContaCorrente;
use App\Models\FinContaReceber;
use App\Models\FinRecebimento;
use App\Models\FormaPagto;
use App\Models\User;
use App\Models\Venda;
use App\Service\ConstanteService;
use App\Service\ContaReceberSevice;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;

class ContaReceberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        
        $filtro                 = new \stdClass();
        $filtro->cliente_id     = $_GET["cliente_id"] ?? null;
        $filtro->status_id      = $_GET["status_id"] ?? [];
        $filtro->venda_id       = $_GET["venda_id"] ?? null;
        $filtro->venc01         = $_GET["venc01"] ?? null;
        $filtro->venc02         = $_GET["venc02"]  ?? null;
        $filtro->emissao01      = $_GET["emissao01"]  ?? null;
        $filtro->emissao02      = $_GET["emissao02"]  ?? null;
        $filtro->conta_id       = $_GET["conta_id"] ?? null;
        $filtro->mostrar_pagto  = $_GET["mostrar_pagto"] ?? null;
        
        $dados["lista"]         = FinContaReceber::filtro($filtro,20);
        $dados["status"]        = ConstanteService::listaStatusFinanceiro();
        $dados["filtro"]        = $filtro;        
       
        $dados["clientes"]      = Cliente::get();
        $dados["financeiroJs"]  = true;
        return view("Admin.Financeiro.ContaReceber.Index", $dados);
    }
    
    
    
    public function pormes()
    {
        $mes            = $_GET["mes"];
        $ano            = $_GET["ano"];
        $dados["lista"] = FinContaReceber::whereMonth("data_vencimento", $mes)->whereYear("data_vencimento", $ano)->get();
        $dados["mes"]   = $mes;
        $dados["clientes"]      = Cliente::get();
        return view("Admin.Financeiro.ContaReceber.Index", $dados);
    }
    
    public function duplicata(){
        $dados["clientes"]      = Cliente::get();
        return view("Admin.Financeiro.ContaReceber.Duplicata", $dados);
    }
    
    public function tituloReceber(Request $request)
    {
        $dados["contas"]        = ContaCorrente::get();
        return view("Admin.Pdf.ContaReceber.Titulo_a_Receber", $dados);
    }
    
    
    
    public function selecionarRelatorioSintetico(){
        $filtro = new \stdClass();
        $filtro->data1                  = $_GET["data1"] ?? null;
        $filtro->data2                  = $_GET["data2"] ?? null;
        $filtro->status_id              = $_GET["status_id"] ?? null;
        $filtro->status_financeiro_id   = $_GET["status_financeiro_id"] ?? null;
        $filtro->cliente_id             = $_GET["cliente_id"] ?? null;
        
        $dados["status_financeiro"]     = ConstanteService::listaStatusFinanceiro();
        $dados["status"]                = ConstanteService::listaStatusVenda();
        $dados["usuarios"]              = User::get();
        $dados["clientes"]              = Cliente::get();
        $dados["lista"]                 = Venda::filtro($filtro);
        $dados["filtro"]                = $filtro;
        
        return view("Admin.Financeiro.ContaReceber.SelecionarRelatorioSintetico", $dados);
    }
    
    public function selecionarRelatorioAnalitico(){
        $filtro = new \stdClass();
        $filtro->data1                  = $_GET["data1"] ?? null;
        $filtro->data2                  = $_GET["data2"] ?? null;
        $filtro->status_id              = $_GET["status_id"] ?? null;
        $filtro->status_financeiro_id   = $_GET["status_financeiro_id"] ?? null;
        $filtro->cliente_id             = $_GET["cliente_id"] ?? null;
        
        $dados["status_financeiro"]     = ConstanteService::listaStatusFinanceiro();
        $dados["status"]                = ConstanteService::listaStatusVenda();
        $dados["usuarios"]              = User::get();
        $dados["clientes"]              = Cliente::get();
        $dados["lista"]                 = Venda::filtro($filtro);
        $dados["filtro"]                = $filtro;
        
        return view("Admin.Financeiro.ContaReceber.SelecionarRelatorioAnalitico", $dados);
    }
    
    public function relatorioSintetico(Request $request){
        $filtro = new \stdClass();
        $filtro->data1                  = $_GET["data1"] ?? null;
        $filtro->data2                  = $_GET["data2"] ?? null;
        $filtro->status_id              = $_GET["status_id"] ?? null;
        $filtro->status_financeiro_id   = $_GET["status_financeiro_id"] ?? null;
        $filtro->cliente_id             = $_GET["cliente_id"] ?? null;
        $filtro->usuario_id             = $_GET["usuario_id"] ?? null;
        $filtro->tipo_relatorio         = $_GET["tipo_relatorio"] ?? null;
        
        $dados["lista"]                 = FinContaReceber::relatorio($filtro);
        $dados["filtro"]                = $filtro;
        $options = new Options();
        $options->setIsRemoteEnabled(true);
        $dompdf = new Dompdf($options);
        $dados["dompdf"]     = $dompdf;
        
        
        return view("Admin.Pdf.ContaReceber.ContaReceber_Sintetica", $dados);
    }
    
    public function relatorioAnalitico(Request $request){
        $filtro = new \stdClass();
        $filtro->data1                  = $_GET["data1"] ?? null;
        $filtro->data2                  = $_GET["data2"] ?? null;
        $filtro->status_id              = $_GET["status_id"] ?? null;
        $filtro->status_financeiro_id   = $_GET["status_financeiro_id"] ?? null;
        $filtro->cliente_id             = $_GET["cliente_id"] ?? null;
        $filtro->usuario_id             = $_GET["usuario_id"] ?? null;
        $filtro->tipo_relatorio         = $_GET["tipo_relatorio"] ?? null;
        
        $dados["lista"]                 = FinContaReceber::relatorio($filtro);
        $dados["filtro"]                = $filtro;
        $options = new Options();
        $options->setIsRemoteEnabled(true);
        $dompdf = new Dompdf($options);
        $dados["dompdf"]     = $dompdf;
        
        
        return view("Admin.Pdf.ContaReceber.ContaReceber_Analitico", $dados);
    }
    
    
    public function confirmarPagamento($id){
        $contareceber = FinContaReceber::find($id); 
        if($contareceber->status_id == config("constantes.status.DELETADO")){
            return redirect()->back()->with('janela_atencao1', "Não é possível confirmar pagamento para uma conta DELETADA.");
        }        
        if($contareceber->recebimento_id){            
            return redirect()->route('admin.contareceber.detalhe', $id)->with('msg_erro', "Essa conta não pode mais ser modificada, só visualizada.");
        }        
        
        $dados["contareceber"]      = $contareceber;
        $dados["formaPagto"]        = FormaPagto::all();
        $dados["clientes"]          = Cliente::get();
        $dados["centro_custos"]     = CentroCusto::get();
        $dados["contas"]            = ContaCorrente::get();
        $dados["classificacoes"]    = ClassificacaoFinanceira::get();
        $dados["pagamentos"]        = array();        
        return view("Admin.Financeiro.ContaReceber.ConfirmarRecebimento", $dados);
    }
    
    
    public function create()
    {
        $dados["formaPagto"]    = FormaPagto::all();
        $dados["clientes"]      = Cliente::get();
        $dados["centro_custos"] = CentroCusto::get();        
        $dados["pagamentos"]    = array();
        $dados["clienteJs"]     = true;
        return view("Admin.Financeiro.ContaReceber.Create", $dados);
    }

    
    public function store(ContaReceberRequest $request)
    {
        $req = $request->except(["_token","_method"]);        
        
        $conta = new \stdClass();
        $conta->descricao               = $req["descricao"];
        $conta->cliente_id              = $req["cliente_id"];              
        $conta->data_emissao            = $req["data_emissao"]; 
        $conta->valor                   = ($req["valor"]) ? getFloat($req["valor"]) : 0;
        $conta->qtde_parcela            = $req["qtdParcelas"];
        $conta->primeiro_vencimento     = $req["primeiro_vencimento"];
        $conta->origem                  = $req["origem"];
        $conta->venda_id                = null;
        
        ContaReceberSevice::novoContaReceber($conta);
        return redirect()->route('admin.contareceber.index')->with('msg_sucesso', "Inserido com sucesso.");
    }

    public function receber(Request $request)
    {
        $req = $request->except(["_token","_method"]);
        
        $conta = new \stdClass();
        $conta->usuario_id              = auth()->user()->id;
        $conta->descricao_recebimento   = "Conta a Receber #" .$req["conta_receber_id"];
        $conta->forma_pagto_id          = $req["forma_pagto_id"];
        $conta->conta_receber_id        = $req["conta_receber_id"];
        $conta->data_recebimento        = hoje();
        $conta->numero_documento        = $req["numero_documento"];
        $conta->observacao              = $req["observacao"];
        $conta->valor_original          = ($req["valor_original"]) ? getFloat($req["valor_original"]) : 0;
        $conta->juros                   = ($req["juros"]) ? getFloat($req["juros"]) : 0;
        $conta->desconto                = ($req["desconto"]) ? getFloat($req["desconto"]) : 0 ;
        $conta->multa                   = ($req["multa"]) ? getFloat($req["multa"]) : 0;        
        $conta->tipo_documento          = $req["tipo_documento"];
        $conta->documento_id            = $req["conta_receber_id"];
        $conta->classificacao_financeira_id            = $req["classificacao_financeira_id"];
        $conta->conta_corrente_id       = $req["conta_corrente_id"];
        $conta->valor_recebido          = $conta->valor_original + $conta->juros + $conta->multa-$conta->desconto;
       
        $pag = FinRecebimento::Create(objToArray($conta));
       
        return redirect()->route('admin.contareceber.index', ["conta_id"=>$conta->conta_receber_id, "mostrar_pagto"=>"S"])->with('msg_sucesso', "Conta Paga com sucesso.");
    }
    public function detalhe($id)
    {
        $dados["contareceber"]  = FinContaReceber::find($id);
        $dados["pagamentos"]    = FinRecebimento::where("conta_receber_id",$id)->get();
        return view("Admin.Financeiro.ContaReceber.Show", $dados);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dados["contareceber"]  = FinContaReceber::find($id);
        
        $dados["formaPagto"]    = FormaPagto::all();
        $dados["clientes"]  = Cliente::get();
        $dados["centro_custos"] = CentroCusto::get();
        $dados["pagamentos"] = array();
        return view("Admin.Financeiro.ContaReceber.Create", $dados);
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
            $req["valor"]   = ($req["valor"]) ? getFloat($req["valor"]) : NULL;
            
            FinContaReceber::where("id", $id)->update($req);
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            return redirect()->route('admin.contareceber.index')->with('msg_sucesso', "Alterado com sucesso.");
            
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
            $h = FinContaReceber::find($id);
            $h->delete();
            return json_encode(1);
            //return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return json_encode(1);
           // return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
