<?php

namespace App\Http\Controllers\Admin\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\ContaReceberPrevisao;
use App\Models\NaturezaOperacao;
use App\Models\TributacaoCofins;
use Illuminate\Http\Request;

class ContaReceberPrevisaoController extends Controller
{
    
    public function index()
    {
    }

    
    public function create()
    {
        
    }

    public function lista($conta_receber_id)
    {
        $retorno = new \stdClass();
        try {
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            $retorno->retorno   = ContaReceberPrevisao::where("conta_receber_id",$conta_receber_id)->get();
            return response()->json($retorno);
        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->erro      = $e->getMessage();
            return response()->json($retorno);
        }
    }
    
    public function store(Request $request){   
        $req = $request->except(["_token","_method"]); 
        $retorno = new \stdClass();
        try {                      
            ContaReceberPrevisao::Create($req);
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            $retorno->retorno   = ContaReceberPrevisao::where("conta_receber_id",$req["conta_receber_id"])->get();
            return response()->json($retorno);
        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->erro      = $e->getMessage();
            return response()->json($retorno);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    
    public function edit($id){
        $dados["natureza"]     = NaturezaOperacao::find($id);
        return view("Admin.Configuracao.NaturezaOperacao.Create", $dados);
    }

   
    public function update(Request $request, $id)
    {
        $req                    = $request->except(["_token","_method"]);    
        
        TributacaoCofins::where("id", $id)->update($req);
        return redirect()->back()->with('msg_sucesso', "item alterado com sucesso.");;
    }

    
    public function destroy( $id){
        try {
            $previsao = ContaReceberPrevisao::find($id);
            $previsao->delete();
            $retorno = new \stdClass();
            $retorno->retorno   = ContaReceberPrevisao::where("conta_receber_id",$previsao->conta_receber_id)->get();
            
            return response()->json($retorno);
        } catch (\Exception $e) {
            $retorno = new \stdClass();
            $retorno->retorno = array();
            $retorno->tem_erro  = true;
            $retorno->erro      = $e->getMessage();
            return response()->json($retorno);
        }
        
    }
}
