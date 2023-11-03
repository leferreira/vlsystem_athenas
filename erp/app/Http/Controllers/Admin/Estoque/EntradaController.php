<?php

namespace App\Http\Controllers\Admin\Estoque;

use App\Http\Controllers\Controller;
use App\Http\Requests\EntradaRequest;
use App\Models\Categoria;
use App\Models\Entrada;
use App\Models\Produto;
use App\Models\Tributacao;
use App\Service\ConstanteService;
use Illuminate\Http\Request;

class EntradaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
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
        $dados["gradeJs"]           = true;
        
        $dados["produtos"]  = Produto::get();
        $dados["lista"]     = Entrada::filtro($filtro)->get();
        $dados["soma"]      = Entrada::filtro($filtro)->sum("subtotal_entrada"); 
        $dados["filtro"]    = $filtro;
        $dados["entradaJs"] = true;
        return view("Admin.Estoque.Entrada.Index", $dados);
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
        $dados["entradaJs"] = true;
        
        $dados["lista"]     = Entrada::filtro($filtro)->get();
        $dados["soma"]      = Entrada::filtro($filtro)->sum("subtotal_entrada"); 
        $dados["produtos"]  = Produto::get();
        $dados["filtro"]    = $filtro;
        return view("Admin.Estoque.Entrada.Index", $dados);
    } 
 
    public function create()
    {
        //
    }

    public function salvarJs(Request $request)  {       
        $retorno = new \stdClass();        
        try {            
            
            $obj                      = new \stdClass();
            $obj->produto_id          =  $request->produto_id ;
            $obj->qtde_entrada        =  getFloat($request->qtde_entrada) ;
            $obj->valor_entrada       =  getFloat($request->valor_entrada);
            $obj->subtotal_entrada    =  $obj->qtde_entrada * $obj->valor_entrada;
            $obj->data_entrada        = date("Y-m-d");
            $obj->unidade             =  $request->unidade ;
            $obj->eh_grade            = "N";           
            Entrada::create(objToArray($obj));            
          
            $retorno->tem_erro = false;
            return response()->json($retorno);
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return response()->json($retorno);
        }
        
        
    }
  
    public function store(EntradaRequest $request)  {
        $req = $request->except(["_token","_method"]); 
        
        try {            
        
            $req["qtde_entrada"]        =  getFloat($request->qtde) ;
            $req["valor_entrada"]       =  getFloat($request->preco);
            $req["subtotal_entrada"]    =  $request->qtde * $request->preco;
            $req["data_entrada"]        = date("Y-m-d");
            
            $estoque_grade            = $request->estoque_grade;
            i($estoque_grade);
            Entrada::create($req);     
          
            
            return redirect()->route("admin.entrada.index")->with("msg_sucesso", "Operação realizada com sucesso");
        } catch (\Exception $e) {
            return redirect()->back()->with("msg_erro", $e->getMessage());
        }
            
        
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
    public function update(Request $request, $id) {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        
    }
}
