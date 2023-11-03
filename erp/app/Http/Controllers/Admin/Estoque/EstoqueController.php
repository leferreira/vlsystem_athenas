<?php

namespace App\Http\Controllers\Admin\Estoque;

use App\Http\Controllers\Controller;
use App\Http\Requests\EntradaRequest;
use App\Models\Categoria;
use App\Models\Entrada;
use App\Models\GradeMovimento;
use App\Models\GradeProduto;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstoqueController extends Controller
{
    
    public function index(Request $request){
        $filtro                     = new \stdClass();
        $filtro->categoria_id       = $request->categoria_id ?? null;
        $filtro->nome               = $request->nome ?? null;
        $filtro->tipo               = config("constantes.tipo_produto.PRODUTO");
        $dados["lista"]             = Produto::filtro($filtro, 20);
        $dados["filtro"]            = $filtro;
        $dados["categorias"]        = Categoria::get();
        return view("Admin.Estoque.Estoque.Index", $dados);
    }

    public function minimo(){
       $sql  = "SELECT  produtos.nome,produtos.estoque_minimo, estoques.* FROM produtos INNER JOIN estoques ON produtos.id = estoques.produto_id";
       $sql .= " WHERE estoques.quantidade < produtos.estoque_minimo AND estoques.empresa_id = 2" ;
                
       $dados["lista"]  = DB::select($sql);        
       
        return view("Admin.Estoque.Estoque.Minimo", $dados);
    } 
    
    public function vencimento(){
        $filtro             = new \stdClass();
        $filtro->data1      = hoje();
        $filtro->data2      = hoje();
        $filtro->nome       = null;
        
        
        $dados["lista"]     = Produto::where("validade", "<=", $filtro->data1)->get();
        $dados["filtro"]    = $filtro;
        return view("Admin.Estoque.Estoque.Vencimento", $dados);
    }
    
    
    public function create()
    {
        //
    }

    public function salvarJs(Request $request)  {       
        $retorno = new \stdClass();        
        try {
            if($request->eh_grade == "S"){
                $estoque_grade   = $request->estoque_grade ?? null;
                $soma = 0;
                foreach($estoque_grade as $estoque){
                    $soma += $estoque["qtde"];
                }
                
                if($soma != getFloat($request->qtde_entrada) ){
                    throw new \Exception('A quantidade de produto da grade é diferente da quantidade total da entrada. Verifique os dados digitados');
                }
            }
            
            $obj                      = new \stdClass();
            $obj->produto_id          =  $request->produto_id ;
            $obj->qtde_entrada        =  getFloat($request->qtde_entrada) ;
            $obj->valor_entrada       =  getFloat($request->valor_entrada);
            $obj->subtotal_entrada    =  $request->qtde_entrada * $request->valor_entrada;
            $obj->data_entrada        = date("Y-m-d");
            $obj->unidade             =  $request->unidade ;
            $obj->eh_grade            = $request->eh_grade;            
            
            
            $entrada = Entrada::create(objToArray($obj));
            
            //fazet entrada se for grade
            if($entrada->eh_grade == "S"){
                $estoque_grade         = $request->estoque_grade ?? null;
                
                foreach($estoque_grade as $estoque){
                    if($estoque["qtde"]){
                        $grade = GradeProduto::find($estoque["id"]);
                        $mov                    = new \stdClass();
                        $mov->tipo_movimento_id = config("constantes.tipo_movimento.ENTRADA_AVULSA");
                        $mov->produto_id        = $request->produto_id;
                        $mov->entrada_avulsa_id = $entrada->id;
                        $mov->grade_id          = $grade->id;
                        $mov->ent_sai           = 'E';
                        $mov->estorno           = 'N';
                        $mov->data_movimento    = hoje();
                        $mov->qtde_movimento    = $estoque["qtde"];
                        $mov->descricao         = "Entrada Avulsa num: " . $entrada->id;
                        if($mov->qtde_movimento > 0){
                           GradeMovimento::Create(objToArray($mov));                           
                        }
                    }
                }
            }
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
