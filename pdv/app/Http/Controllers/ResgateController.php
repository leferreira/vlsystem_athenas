<?php

namespace App\Http\Controllers;

use App\Service\PdvService;
use App\Service\ResgateService;
use Illuminate\Http\Request;
use App\Service\VendaService;

class ResgateController extends Controller
{
    
    public function lista(){
        $dados["teste"] = "oi";
        return view('Resgate.Index', $dados);
    }
    
    public function index(){
        $venda = PdvService::home("verificar_venda_aberta"); 
        
        if(isset($venda->id)){
            return redirect()->back()->with("msg_erro", "Existe uma venda em aberto, para poder fazer resgate não pode haver nenhuma venda pendente");
        }
        $dados["lista"]     = ResgateService::lista();  
        $dados["resgateJs"] = true;
        return view("Resgate.ListaResgate", $dados);
    }
       
    
    public function resgatar(Request $request){
        $retorno = new \stdClass();
        try {            
            $resultado = ResgateService::buscar($request->all());  
            if($resultado){
                $retorno->tem_erro = false;
                $retorno->retorno  = $resultado;
            }else{
                $retorno->tem_erro = true;
                $retorno->retorno  = "";
            }
            
            return response()->json($retorno);            
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return response()->json($retorno);
        }
        
    }
    
    public function enviarParaCaixa(Request $request){
        $retorno = new \stdClass();
        try {
            $req = $request->all();
                     
            $resultado          = ResgateService::resgatar($req);
            
            if($resultado){
                $retorno->tem_erro = false;
                $retorno->retorno  = $resultado->data;
            }else{
                $retorno->tem_erro = true;
                $retorno->retorno  = "";
            }
            
            return response()->json($retorno);
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return response()->json($retorno);
        }
        
    }
    
    public function excluirBalcao($id)
    {
        ResgateService::excluirBalcao($id);
        return redirect()->route("resgate.index");
    }
    
    public function excluirPdvVenda($id)
    {
        $retorno = new \stdClass();
        try {
            $venda                = new \stdClass();
            $venda->venda_id      = $id;
            $resultado            = VendaService::cancelarVenda($venda);
            return redirect()->route("resgate.index");
            
        } catch (\Exception $e) {
            $retorno->tem_erro    = true;
            $retorno->erro        = $e->getMessage();
            $retorno->retorno     = "";
            return redirect()->back()->with("msg_erro", $e->getMessage());
        }
        
    }
  
    public function show($id)
    {
        
    }

    
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
}
