<?php

namespace App\Http\Controllers\Admin\Assinatura;

use App\Http\Controllers\Controller;
use App\Models\CentroCusto;
use App\Models\FinFatura;
use App\Models\FinPagamento;
use App\Models\FormaPagto;
use App\Models\Fornecedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Assinatura;
use App\Models\PlanoPreco;
use App\Models\ContabilConta;
use App\Models\ClassificacaoFinanceira;
use App\Models\ContaCorrente;

class AssinaturaController extends Controller
{
    public function index()
    {
        $dados["lista"]         = Assinatura::get();
        $dados["assinatura"]    = Assinatura::where("status_id", config("constantes.status.ATIVO"))->first();
        return view("Admin.Assinatura.Index", $dados);
    }
    
    
    public function pormes()
    {
        $mes            = $_GET["mes"];
        $ano            = $_GET["ano"];
        $dados["lista"] = FinFatura::whereMonth("data_vencimento", $mes)->whereYear("data_vencimento", $ano)->get();
        $dados["mes"]   = $mes;
        return view("Admin.Financeiro.Fatura.Index", $dados);
    }
    
    public function assinar($id=1)
    {
        $dados["planos"]         = PlanoPreco::where("recorrencia", $id)->get();
        $dados["id"] = $id;
        $dados["plano_atual"]    = Assinatura::where(["status_id" => config("constantes.status.ATIVO"), "eh_teste" =>"N"])->first();
        return view("Admin.Assinatura.Assinar", $dados);
    }
      
    public function naoassinante()
    {
        
        $id = 1;
        $dados["planos"]         = PlanoPreco::where("recorrencia", $id)->get();
        $dados["id"]             = $id;
        $dados["plano_atual"]    = Assinatura::where(["status_id" => config("constantes.status.ATIVO"), "eh_teste" =>"N"])->first();
        return view("Admin.Assinatura.NaoAssinante", $dados);
    }
    
    public function demovencido()
    {
        
        $id = 1;
        $dados["planos"]         = PlanoPreco::where("recorrencia", $id)->get();
        $dados["id"]             = $id;
        $dados["plano_atual"]    = Assinatura::where(["status_id" => config("constantes.status.ATIVO"), "eh_teste" =>"N"])->first();
        return view("Admin.Assinatura.Plano_Demo_Vencido", $dados);
    }
    
    public function faturas($assinatura_id)
    {
        $assinatura        = Assinatura::find($assinatura_id);
        $dados["lista"]    = FinFatura::where(["assinatura_id"=>$assinatura->id ])->get();
        return view("Admin.Assinatura.Faturas", $dados);
    }
    
    public function faturaVencida()
    {        
        $assinatura         = Assinatura::orderBy("id", "desc")->first();
        $dados["lista"]    = FinFatura::where("data_vencimento","<=", hoje())->where(["assinatura_id"=>$assinatura->id, "status_id" => config("constantes.status.ABERTO") ])->get();
        return view("Admin.Assinatura.FaturaVencida", $dados);
    }
    
    public function nenhumFaturaPaga()
    {
        $assinatura        = Assinatura::orderBy("id", "desc")->first();
        $dados["lista"]    = FinFatura::where("data_vencimento","<=", hoje())->where(["assinatura_id"=>$assinatura->id, "status_id" => config("constantes.status.ABERTO") ])->get();
        return view("Admin.Assinatura.nenhumaFaturaPaga", $dados);
    }
    public function bloqueado()
    {
        return view("Admin.Assinatura.Bloqueado");
    }
    
    public function pagamento($id){
        
        $dados["planopreco"]     = PlanoPreco::where("id", $id)->first();
        return view("Admin.Assinatura.Pagamento", $dados);
    }
    
    public function comprovante($id) {
        $dados["contas"]         = ContaCorrente::get();
        $dados["formaPagto"]     = FormaPagto::get();
        $dados["classificacoes"] = ClassificacaoFinanceira::get();
        $dados["planopreco"] = PlanoPreco::where("id", $id)->first();
        return view("Admin.Assinatura.EnviarComprovante", $dados);
    }
    
    
    
    public function fazerAssinatura($tipo) {
        $fatura                 = FinFatura::where('empresa_id', Auth::user()->empresa_id)->first();
        $empresa                =  Auth::user()->empresa;
        
        if(!$fatura){
            $fat                    = new \stdClass();
            $fat->descricao         = "Fatura do Plano: " . Auth::user()->empresa->planopreco->plano->nome ;
            $fat->empresa_id        = Auth::user()->empresa_id;
            $fat->forma_pagto_id    = config("constantes.forma_pagto.BOLETO_BANCARIO");
            $fat->status_id         = config("constantes.status.ABERTO");
            $fat->data_emissao      = hoje();
            $fat->data_vencimento   = hoje();
            $fat->valor             = Auth::user()->empresa->planopreco->preco;
            $fat->num_fatura        = 1;
            $fat->inicio_vigencia   = hoje();
            $fat->fim_vigencia      = hoje();;
            
            //Verifica se tem alguma fatura em aberto se sim, ele atualiza, senão ele cria
            $fatura =  FinFatura::Create(objToArray($fat));
            
            if($fatura){
                $empresa->data_vencimento = hoje();
                $empresa->status_id       = config("constantes.status.ATIVO");
                $empresa->save();
            }
        }
        if($tipo=="comprovante"){
            return redirect()->route('admin.pagamento.comprovante', $fatura->id);
        }
        
    }
    
    
    
    public function filtro()
    {
        $filtro                 = new \stdClass();
        $filtro->status_id      = $_GET["status_id"];
        $filtro->venc01         = $_GET["venc01"];
        $filtro->venc02         = $_GET["venc02"];
        $filtro->emissao01      = $_GET["emissao01"];
        $filtro->emissao02      = $_GET["emissao02"];
        
        $dados["lista"]         = FinFatura::filtro($filtro);
        $dados["filtro"]        = $filtro;
        $dados["mes"]           = 13;
        return view("Admin.Financeiro.Fatura.Index", $dados);
    }
  

    
    
    
    
    public function confirmarPagamento($id)
    {
        $fatura = FinFatura::find($id);
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
    
    
    
    
    
    public function pix($id) {
        $fatura                 = FinFatura::find($id);
        $dados["fatura"]        = $fatura;
        $dados["empresa"]       = Auth::user()->empresa()->first();
        $dados["formaPagto"]    = FormaPagto::all();
        $dados["fornecedores"]  = Fornecedor::get();
        $dados["centro_custos"] = CentroCusto::get();
        $dados["mercadoPagoJs"] = true;
        $dados["pagamentos"]    = array();
        return view("Admin.Financeiro.Fatura.Pix", $dados);
    }
    
    public function cartao($id) {
        $fatura                 = FinFatura::find($id);
        $dados["fatura"]        = $fatura;
        $dados["empresa"]       = Auth::user()->empresa()->first();
        $dados["formaPagto"]    = FormaPagto::all();
        $dados["fornecedores"]  = Fornecedor::get();
        $dados["centro_custos"] = CentroCusto::get();
        $dados["mercadoPagoJs"] = true;
        $dados["pagamentos"]    = array();
        return view("Admin.Financeiro.Fatura.Cartao", $dados);
    }
    
    public function boleto($id) {
        $fatura                 = FinFatura::find($id);
        $dados["fatura"]        = $fatura;
        $dados["empresa"]       = Auth::user()->empresa()->first();
        $dados["formaPagto"]    = FormaPagto::all();
        $dados["fornecedores"]  = Fornecedor::get();
        $dados["centro_custos"] = CentroCusto::get();
        $dados["mercadoPagoJs"] = true;
        $dados["pagamentos"]    = array();
        return view("Admin.Financeiro.Fatura.Boleto", $dados);
    }
    
    public function detalhe($id)
    {
        $dados["fatura"]        = FinFatura::find($id);
        $dados["formaPagto"]    = FormaPagto::all();
        $dados["fornecedores"]  = Fornecedor::get();
        $dados["centro_custos"] = CentroCusto::get();
        $dados["pagamentos"] = array();
        return view("Admin.Financeiro.Fatura.Show", $dados);
    }
    
   
    public function create()
    {
        $dados["formaPagto"]    = FormaPagto::all();
        $dados["fornecedores"]  = Fornecedor::get();
        $dados["centro_custos"] = CentroCusto::get();
        $dados["pagamentos"] = array();
        return view("Admin.Financeiro.Fatura.Create", $dados);
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
        FinFatura::Create(objToArray($conta));
        return redirect()->route('admin.fatura.index')->with('msg_sucesso', "Inserido com sucesso.");
    }

    public function pagar(Request $request)
    {
        $req = $request->except(["_token","_method"]);
       
        $conta = new \stdClass();
        $conta->usuario_id              = auth()->user()->id;
        $conta->descricao_pagamento     = "Fatura #" .$req["fatura_id"];
        $conta->forma_pagto_id          = $req["forma_pagto_id"];
        $conta->data_pagamento          = hoje();
        $conta->numero_documento        = $req["numero_documento"];
        $conta->observacao              = $req["observacao"];
        $conta->valor_original          = $req["valor_original"];
        $conta->juros                   = $req["juros"];
        $conta->desconto                = $req["desconto"];
        $conta->multa                   = $req["multa"];        
        $conta->tipo_documento          = $req["tipo_documento"];
        $conta->documento_id            = $req["fatura_id"];
        $conta->valor_pago              = $conta->valor_original + $conta->juros + $conta->multa-$conta->desconto;
        $pag                            = FinPagamento::Create(objToArray($conta));
        if($pag){
            FinFatura::where("id", $req["fatura_id"])->update(["pagamento_id"=>$pag->id, "status_id"=>config("constantes.status.PAGO")]);
        }
        return redirect()->route('admin.fatura.index')->with('msg_sucesso', "Conta Paga com sucesso.");
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
            $h = FinFatura::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
