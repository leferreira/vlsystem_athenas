<?php

namespace App\Http\Controllers\Admin\Cadastro;

use App\Http\Controllers\Controller;
use App\Models\NaturezaOperacao;
use App\Models\ProdutoComposicao;
use App\Models\ProdutoSemelhante;
use Illuminate\Http\Request;

class ProdutoSemelhanteController extends Controller
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

    
    public function store(Request $request){   
        $req = $request->except(["_token","_method"]); 
        $retorno = new \stdClass();
        try {     
        
            ProdutoSemelhante::Create($req);
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            $retorno->retorno   = ProdutoSemelhante::where("produto_principal_id", $req["produto_principal_id"])->with("produtoSemelhante")->get();
     
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
       
    }

   
    public function update(Request $request, $id)
    {
       
    }

    
    public function destroy( $id){
        try {
            $composicao = ProdutoSemelhante::find($id);
            $composicao->delete();
            $retorno = new \stdClass();
            $retorno->retorno   = ProdutoSemelhante::where("produto_principal_id", $composicao->produto_principal_id)->with("produtoSemelhante")->get();
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
