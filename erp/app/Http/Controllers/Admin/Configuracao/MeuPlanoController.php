<?php

namespace App\Http\Controllers\Admin\Configuracao;

use App\Http\Controllers\Controller;
use App\Models\FinFatura;
use App\Models\Modulo;
use App\Models\Plano;
use App\Models\PlanoModulo;
use App\Models\PlanoPreco;
use App\Service\PagamentoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeuPlanoController extends Controller
{

    public function index()
    {
        $dados["empresa"] = auth()->user()->empresa;
        return view("Admin.Configuracao.MeuPlano.Create", $dados);
    }


    public function create()
    {
        $dados = array();
        return view("Admin.Configuracao.Plano.Create", $dados);
    }

    public function assinar($id=1)
    {
        $dados["planos"] = PlanoPreco::where("recorrencia", $id)->get();
        $dados["id"] = $id;
        return view("Admin.Plano.Assinar", $dados);
    }


    public function pagamento($id){
        $dados["planopreco"] = PlanoPreco::where("id", $id)->first();
        return view("Admin.Plano.Pagamento", $dados);
    }

    public function finalizar($id){
        $plano = PlanoPreco::where("id", $id)->first();

        $forma_pagamento = 1;
        FinFatura::Create([
            "status_id"         =>config("constantes.status.PAGO"),
            "forma_pagto_id"    => $forma_pagamento,
            "data_aquisicao"    =>hoje(),
            "valor_original"    =>$plano->preco,
            "valor_a_pagar"     =>$plano->preco,
            "valor_pago"        =>$plano->preco,
            "data_vencimento"   =>hoje(),
            "data_pagamento"    =>hoje(),
            "descricao"         =>"Plano #" . $plano->id
        ]);

        $empresa                = auth()->user()->empresa;

        if($empresa->plano_id   ==1){
            $empresa->data_aquisicao            = hoje();
            $empresa->data_inicial_vencimento   = hoje();
        }

        $empresa->plano_id          = $plano->plano->id;
        $empresa->forma_pagto_id    = $forma_pagamento;
        $empresa->valor_recorrente  = $plano->preco;
        $empresa->tipo_recorrencia  = $plano->recorrencia;
        $empresa->status_id         = config("constantes.status.ATIVO");
        $empresa->data_vencimento   = somarData(hoje(),30 *$plano->recorrencia );
        $empresa->save();

        return redirect()->route('admin.index')->with("msg_sucesso", "Seu plano foi pago com sucesso");
    }

    


    public function obrigado()
    {
        return view("Admin.Plano.Obrigado");
    }

    public function vencido()
    {
        $fatura = FinFatura::where("status_id", config("constantes.status.ABERTO"))->first();      
        
        if(!$fatura){
            return view("Admin.Plano.Plano_Demo_Vencido");
        }else{
            $dados["fatura"] = $fatura;
            return view("Admin.Plano.Fatura_Vencida", $dados);
        }
        
    }

    public function store(Request $request)
    {
        $req = $request->except(["_token","_method"]);
        Plano::firstOrCreate($req);
        return redirect()->route('gestor.plano.index');
    }

    public function pagarComPix(){

    }

    public function pagarComCartao(){

    }

    public function pagarComBoleto(){

    }

    public function pagarPorTransferência($id){
        PagamentoService::pagarPorTransferência($id);
        return redirect()->route('admin.index')->with("msg_sucesso", "Seu plano foi pago com sucesso");
    }

    public function modulos($id)
    {
        $dados["plano"] = Modulo::find($id);
        $dados["modulos"] = Modulo::all();
        $dados["lista"] = PlanoModulo::where("plano_id", $id)->get();
        return view("Admin.Configuracao.Plano.Modulo", $dados);
    }

    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $dados["plano"] = Plano::find($id);
        $dados["lista"] = Plano::all();
        return view('Admin.Configuracao.MeuPlano.Index', $dados);
    }

    public function update(Request $request, $id)
    {
        $req     =   $request->except(["_token","_method"]);
        Plano::where("id", $id)->update($req);
        return redirect()->route("gestor.plano.index");
    }

   
    public function destroy($id)
    {
        try{
            $h = Plano::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Ítem apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
