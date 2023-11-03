<?php

namespace App\Http\Controllers;

use App\Service\CaixaService;
use App\Service\SuplementoService;
use Illuminate\Http\Request;

class SuplementoController extends Controller
{
    public function ver(){
        $caixas = CaixaService::listaCaixaAbertoPorUsuario(session("usuario_pdv_logado")->uuid);
        if($caixas){
            if(count($caixas) ==1){
                return redirect()->route('caixa.suplemento', $caixas[0]->id);
            }else{
                return redirect()->route('caixa.caixasAberto');
            }
        }else{
            return redirect()->back()->with("msg_erro", "Para visualizar ou inserir o Suplemento é necessário que tenha pelo menos um caixa aberto");
        }
    }
    
    public function index(){
        $dados["lista"]         = SuplementoService::lista(session("usuario_pdv_logado")->uuid);
        return view("Suplemento.Index", $dados);
    }
    
    public function salvarJs(Request $request){
        $retorno = new \stdClass();
        $req = $request->except(["_token","_method"]);
        try {
            $req["usuario_uuid"] = session("usuario_pdv_logado")->uuid;
            $req["valor"]        = getFloat($req["valor"] ); 
            $suplemento          =  SuplementoService::salvar($req);
            $retorno->tem_erro = false;
            $retorno->retorno  = $suplemento;
            return response()->json($retorno);
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return response()->json($retorno);
        }
        
    }
    
    public function store(Request $request){
        $req = $request->except(["_token","_method"]);
        $req["usuario_uuid"] = session("usuario_pdv_logado")->uuid;
        $req["valor"] = getFloat($req["valor"] );  
        SuplementoService::salvar($req);
        return redirect()->route('caixa.suplemento', $req["caixa_id"])->with('msg_sucesso', "Inserido com sucesso.");
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
        //
    }
}
