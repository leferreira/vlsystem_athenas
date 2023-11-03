<?php

namespace App\Http\Controllers\Admin\Cadastro;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\NaturezaOperacao;
use App\Models\TributacaoCofins;
use App\Models\TributacaoProduto;
use Illuminate\Http\Request;
use App\Models\Tributacao;
use App\Http\Requests\TributacaoProdutoRequest;
use App\Models\ProdutoComposicao;

class ComposicaoProdutoController extends Controller
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
            $req["qtde"] = getFloat($req["qtde"]);
            ProdutoComposicao::Create($req);
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            $retorno->retorno   = ProdutoComposicao::where("produto_pai_id", $req["produto_pai_id"])->with("produtoFilho")->get();
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
            $composicao = ProdutoComposicao::find($id);
            $composicao->delete();
            $retorno = new \stdClass();
            $retorno->retorno   = ProdutoComposicao::where("produto_pai_id", $composicao->produto_pai_id)->with("produtoFilho")->get();
            
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
