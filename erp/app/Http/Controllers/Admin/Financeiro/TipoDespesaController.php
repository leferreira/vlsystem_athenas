<?php

namespace App\Http\Controllers\Admin\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\FinDespesa;
use App\Models\FinLancamentoDespesa;
use Illuminate\Http\Request;
use App\Models\Fornecedor;
use App\Models\FinTipoDespesa;
use App\Http\Requests\TipoDespesaRequest;

class TipoDespesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados["lista"]   = FinTipoDespesa::all();
        return view("Admin.Financeiro.TipoDespesa.Index", $dados);
    }

    
    public function create()
    {
        //
    }

    public function salvarJs(TipoDespesaRequest $request){
        $retorno = new \stdClass();
        try {
            $req = $request->except(["_token","_method"]);
            FinTipoDespesa::Create($req);
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            $retorno->retorno   = FinTipoDespesa::get();
            return response()->json($retorno);
            
        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->erro      = $e->getMessage();
            return response()->json($retorno);
        }
        
    }
    

    
    public function store(TipoDespesaRequest $request){
        try {
            $req = $request->except(["_token","_method"]);
            FinTipoDespesa::Create($req);
            return redirect()->route('admin.tipodespesa.index')->with('msg_sucesso', "Inserido com sucesso.");
        } catch (\Exception $e) {
            return redirect()->back()->with('msg_erro', "Erro: " . $e->getMessage());
        }
        
        
    }

    
    public function show($id)
    {
        //
    }

    public function pesquisa(){
        $q        = $_GET["q"];        
        $lista   = FinTipoDespesa::where("nome","like","%$q%")->get();
        
        return response()->json($lista);
    }
    
    public function edit($id)
    {
        $dados["tipodespesa"]     = FinTipoDespesa::find($id);
        $dados["lista"]    = FinTipoDespesa::get();
        return view('Admin.Financeiro.TipoDespesa.Index', $dados);
    }

    
    public function update(TipoDespesaRequest $request, $id)
    {        
        try {
            $req     =   $request->except(["_token","_method"]);
            FinTipoDespesa::where("id", $id)->update($req);
            return redirect()->route("admin.tipodespesa.index")->with('msg_sucesso', "item alterado com sucesso.");
        } catch (\Exception $e) {
            return redirect()->back()->with('msg_erro', "Erro: " . $e->getMessage());
        }
        
    }

   
    public function destroy($id)
    {
        try{
            $h = FinTipoDespesa::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Erro: " . $e->getMessage());
        }
    }
}
