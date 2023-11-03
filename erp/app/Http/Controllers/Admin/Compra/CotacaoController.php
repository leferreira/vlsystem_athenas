<?php

namespace App\Http\Controllers\Admin\Compra;

use App\Http\Controllers\Controller;
use App\Models\Cotacao;
use App\Models\Fornecedor;
use App\Models\FornecedorCotacao;
use App\Models\ItemCotacao;
use App\Models\Solicitacao;
use App\Models\SolicitacaoCotacao;
use App\Service\CotacaoService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CotacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lista = Cotacao::all();
        return view("Admin.Cotacao.Index",compact('lista'));
    }

    public function em_massa(Request $request){       
        $cotacao = Cotacao::where("status_cotacao_id",1)->first();
        if(!$cotacao){
            $cotacao = Cotacao::create(["status_cotacao_id"=>1, "data_abertura"=>date("Y-m-d")]);
        }   
        
        $solicitacoes = ($request["idSolicitacao"]) ? $request["idSolicitacao"]: null;
        if($solicitacoes){
            for($i=0; $i< count($solicitacoes); $i++){
                $solicitacao = Solicitacao::find($solicitacoes[$i]);
                if($solicitacao->status_solicitacao_id ==1){
                    $cadastrou = SolicitacaoCotacao::create(["solicitacao_id" =>$solicitacoes[$i], "cotacao_id"=>$cotacao->id]);
                    if($cadastrou){
                        Solicitacao::where("id" , $solicitacoes[$i])->update(["status_solicitacao_id"=>2 ]);                        
                    }
                }
            }
        }
        
        return redirect()->route("cotacao.create");
        
    }
    public function create() {
        $cotacao = Cotacao::where("status_cotacao_id",1)->first();
        
        if(!$cotacao){
            $cotacao = Cotacao::create(["data_abertura"=>date("Y-m-d")]);
        }
        
        $dados["abertas"]               = Solicitacao::where("status_solicitacao_id", 1)->get();
        $dados["solicitacoes"]          = SolicitacaoCotacao::where("cotacao_id", $cotacao->id)->get(); 
        
        $fornecedores                   = Fornecedor::all();
        $fornecedores_cotacao           = FornecedorCotacao::where("cotacao_id", $cotacao->id)->get();
        
        $arr_fornecedores               = Arr::pluck($fornecedores,"id");         
        $arr_forn_cotacao               = Arr::pluck($fornecedores_cotacao, 'fornecedor_id');
        
       
        $lista_fornecedores = array();
        foreach ($arr_fornecedores as $f){
            if(!in_array($f, $arr_forn_cotacao)){
                $lista_fornecedores[] = Fornecedor::find($f);
            }
        }
        
        
        $dados["fornecedores"] = $lista_fornecedores;
        $dados["fornecedores_cotacao"]  = FornecedorCotacao::where("cotacao_id", $cotacao->id)->get();
        $dados["cotacao"] = $cotacao;
        return view("Admin.Cotacao.Create",$dados);
    }

    public function finalizar($id)    {
        $solicitacoes = SolicitacaoCotacao::where("cotacao_id", $id)->get();
        $fornecedores = FornecedorCotacao::where("cotacao_id", $id)->get();
        
        if(!$solicitacoes || !$fornecedores){
            return redirect()->route("cotacao.create");
        }
        
        
        foreach($fornecedores as $f){
            foreach ($solicitacoes as $s){               
                $item = new ItemCotacao();
                $item->cotacao_id           = $id;
                $item->fornecedor_id        = $f->fornecedor_id;
                $item->solicitacao_id       = $s->solicitacao_id;
                $item->status_item_cotacao_id= 1;
                $item->produto_id           = $s->solicitacao->produto_id;
                $item->qtde                 = $s->solicitacao->qtde;               
                $item->save();
            }
        }
        Cotacao::where("id", $id)->update(["status_cotacao_id"=>2]);
        return redirect()->route("cotacao.index");
    }
    
    public function comparar($cotacao_id){
        $dados["cotacao"]   = Cotacao::find($cotacao_id);
        if($dados["cotacao"]->status_cotacao_id >=4){
            return redirect()->route("cotacao.index");
        }
        $dados["lista"]     = CotacaoService::listaComparacaoPrecos($cotacao_id);
       
        return view("Admin.Cotacao.Comparar",$dados);
    }    
    
    public function store(Request $request)
    {
        //
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
        //
    }
}
