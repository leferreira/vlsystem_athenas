<?php

namespace App\Http\Controllers\Admin\Configuracao;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\NaturezaOperacao;
use App\Models\TributacaoCofins;
use App\Models\TributacaoProduto;
use Illuminate\Http\Request;
use App\Models\Tributacao;
use App\Http\Requests\TributacaoProdutoRequest;

class TributacaoProdutoController extends Controller
{
    
    public function index()
    {
        
        $dados["lista"] = NaturezaOperacao::get();
        return view("Admin.Configuracao.NaturezaOperacao.Index", $dados);
    }

    
    public function create()
    {
        $dados["naturezas"] = NaturezaOperacao::all();
        return view("Admin.Configuracao.NaturezaOperacao.Create", $dados);
    }

    
    public function store(TributacaoProdutoRequest $request){   
        $req = $request->except(["_token","_method"]); 
        $retorno = new \stdClass();
        try {
            $tributacao = Tributacao::find($req["tributacao_id"]);
            $req["natureza_operacao_id"] = $tributacao->natureza_operacao_id;                       
            TributacaoProduto::Create($req);
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            $retorno->retorno   = TributacaoProduto::lista($req["produto_id"]);
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
            $produto = TributacaoProduto::find($id);
            $produto->delete();
            $retorno = new \stdClass();
            $retorno->retorno   = TributacaoProduto::lista($produto->produto_id);
            
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
