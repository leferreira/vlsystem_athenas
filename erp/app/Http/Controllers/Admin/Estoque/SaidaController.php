<?php

namespace App\Http\Controllers\Admin\Estoque;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaidaRequest;
use App\Models\Categoria;
use App\Models\GradeMovimento;
use App\Models\GradeProduto;
use App\Models\Produto;
use App\Models\Saida;
use App\Models\Tributacao;
use App\Service\ConstanteService;
use Illuminate\Http\Request;
use function Termwind\ValueObjects\getFormatString;

class SaidaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filtro             = new \stdClass();
        $filtro->data1      = hoje();
        $filtro->data2      = hoje();
        $filtro->produto_id = null;
        
        //Dados da Venda
        $empresa                    = auth()->user()->empresa;
        $dados["categorias"]        = Categoria::orderBy('categoria', 'asc')->get();
        $dados["unidades"]          = ConstanteService::unidadesMedida();
        $dados["tributacoes"]       = Tributacao::get();
        $dados["parametro"]         = $empresa->parametro;
        $dados["produtoJs"]         = true;
        
        $dados["produtos"]  = Produto::get();
        $dados["lista"]     = Saida::filtro($filtro)->get();
        $dados["soma"]      = Saida::filtro($filtro)->sum("subtotal_saida");
        $dados["filtro"]    = $filtro;
        $dados["saidaJs"]   = true;
        $dados["gradeJs"]   = true;
        return view("Admin.Estoque.Saida.Index", $dados);
    }

    public function filtro(){
        $filtro             = new \stdClass();
        $filtro->data1      = $_GET["data1"];
        $filtro->data2      = $_GET["data2"];
        $filtro->produto_id = $_GET["produto_id"];
        
        //Dados da Venda
        $empresa                    = auth()->user()->empresa;
        $dados["categorias"]        = Categoria::orderBy('categoria', 'asc')->get();
        $dados["unidades"]          = ConstanteService::unidadesMedida();
        $dados["tributacoes"]       = Tributacao::get();
        $dados["parametro"]         = $empresa->parametro;
        $dados["produtoJs"]         = true;
        
        $dados["produtos"]  = Produto::get();
        
        $dados["lista"]     = Saida::filtro($filtro)->get();
        $dados["soma"]      = Saida::filtro($filtro)->sum("subtotal_saida");
        $dados["produtos"]  = Produto::get();
        $dados["filtro"]    = $filtro;
        $dados["saidaJs"] = true;
        return view("Admin.Estoque.Saida.Index", $dados);
    } 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function salvarJs(Request $request)  {
      
        $retorno = new \stdClass();        
        try {
            $produto = Produto::find($request->produto_id);  
            $qtde = getFloat($request->qtde_saida);           
            
            $somatorio = $produto->estoque->quantidade -  $qtde;
            if($somatorio < 0 ){
                throw new \Exception("Quantidade maior que estoque o disponível !");
            }
           
           
            $obj                    = new \stdClass();
            $obj->produto_id        =  $request->produto_id ;
            $obj->qtde_saida        =  $qtde ;
            $obj->valor_saida       =  getFloat($request->valor_saida);
            $obj->subtotal_saida    =  $qtde * getFloat($request->valor_saida);
            $obj->data_saida        =  date("Y-m-d");
            $obj->unidade           =  $request->unidade ;
            $obj->eh_grade          = "N";            
            
             Saida::create(objToArray($obj));
            
     
            $retorno->tem_erro = false;
            return response()->json($retorno);
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return response()->json($retorno);
        }
        
        
    }
    public function store(SaidaRequest $request) {
        $req = $request->except(["_token","_method"]);
        try {            
        
            $req["qtde_saida"]        =  $request->qtde ;
            $req["valor_saida"]       =  $request->preco;
            $req["subtotal_saida"]    =  $request->qtde * $request->preco;
            $req["data_saida"]        = date("Y-m-d");
            Saida::create($req);
            
              
            return redirect()->route("admin.saida.index")->with("msg_sucesso", "Operação realizada com sucesso");            
        } catch (\Exception $e) {
            return redirect()->back()->with("msg_erro", $e->getMessage());
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
