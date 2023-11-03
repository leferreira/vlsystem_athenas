<?php

namespace App\Http\Controllers\Admin\Estoque;

use App\Http\Controllers\Controller;
use App\Models\GradeMovimento;
use App\Models\GradeProduto;
use App\Models\Produto;
use App\Service\MovimentoService;
use Illuminate\Http\Request;
use App\Models\ItemVenda;
use App\Models\ItemCompra;
use App\Models\Entrada;
use App\Models\Saida;
use App\Models\ItemOrcamento;
use App\Models\ItemPedidoCliente;
use App\Models\GradeMovimentoTemp;

class MovimentoGradeTempController extends Controller
{
    
    public function index(){
        //
    }
    
     
    
    public function create()
    {
        //
    }
  
    public function inserirEntradaSaida(Request $request)
    {        
        $retorno = new \stdClass();
        try {           
            $grade = GradeProduto::find($request->grade_id);
            $mov                    = new \stdClass();
            
            //Entrada do Produto
            if($request->tabela=="entrada"){
                $obj                      = new \stdClass();
                $obj->produto_id          =  $request->produto_id ;
                $obj->qtde_entrada        =  getFloat($request->qtde) ;
                $obj->valor_entrada       =  getFloat($request->valor);
                $obj->grade_produto_id    =  $request->grade_id;
                $obj->subtotal_entrada    =  $request->qtde * $request->valor;
                $obj->data_entrada        =  date("Y-m-d");
                $obj->unidade             =  $request->unidade ;
                $obj->eh_grade            =  "S";
                $entrada                  =  Entrada::create(objToArray($obj));
                if($entrada){
                    $mov->tipo_movimento_id = config("constantes.tipo_movimento.ENTRADA_AVULSA");
                    $mov->entrada_avulsa_id = $entrada->id;
                    $mov->ent_sai           = 'E';
                    $mov->descricao         = "Entrada Avulsa num: " . $entrada->id;
                }                
            }
            
            if($request->tabela=="saida"){                
                $somatorio = $grade->estoque_temporario - $request->qtde;
                if($somatorio < 0 ){
                    throw new \Exception("Quantidade maior que estoque o disponível !");
                }                
                
                $obj                      = new \stdClass();
                $obj->produto_id          =  $request->produto_id ;
                $obj->qtde_saida          =  getFloat($request->qtde) ;
                $obj->valor_saida         =  getFloat($request->valor);
                $obj->grade_produto_id    =  $request->grade_id;
                $obj->subtotal_saida      =  $request->qtde * $request->valor;
                $obj->data_saida          =  date("Y-m-d");
                $obj->unidade             =  $request->unidade ;
                $obj->eh_grade            =  "S";
                $saida                  =  Saida::create(objToArray($obj));
                if($saida){
                    $mov->tipo_movimento_id = config("constantes.tipo_movimento.SAIDA_AVULSA");
                    $mov->saida_avulsa_id = $saida->id;
                    $mov->ent_sai           = 'S';
                    $mov->descricao         = "Saida Avulsa num: " . $saida->id;
                }
            }
            //fazet Movimento se for grade         
            
            $mov->produto_id        = $request->produto_id;            
            $mov->grade_id          = $grade->id;            
            $mov->estorno           = 'N';
            $mov->data_movimento    = hoje();
            $mov->qtde_movimento    = $request->qtde;            
            if($mov->qtde_movimento > 0){
                GradeMovimento::Create(objToArray($mov));
            }
                
            $retorno->tem_erro = false;
            return response()->json($retorno);
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return response()->json($retorno);
        }
    }
    
    
    public function salvarJs(Request $request)
    {      
      
        $retorno  = new \stdClass();
        try {
            if($request->campo=="item_orcamento_id"){
                $item        = ItemOrcamento::find($request->item_id);
            }else if($request->campo=="pedido_cliente_id"){
                $item        = ItemPedidoCliente::find($request->item_id);
            }
                       
            $grade_produto = GradeProduto::find($request->grade_id);             
            
            
            //Verifica se já existe um movimento
            $temGradeMovimento = GradeMovimentoTemp::where([$request->campo => $request->item_id, "grade_id" =>$request->grade_id])->first();
            if($temGradeMovimento){
                throw new \Exception('Já existe um laçamento para esta grade, caso queira atualizar o valor, exclua e inclua novamente!');
            }
            
            $soma = GradeMovimentoTemp::where($request->campo, $request->item_id)->sum('qtde_movimento');            
            $somatorio = $soma + $request->qtde;         
            if($somatorio > $item->quantidade){
                throw new \Exception("O somatório das quantidades de saída da grade ($somatorio) ficará superior à quantidade do pedido ($item->quantidade) !");
            }
            
            $mov                    = new \stdClass();
            $mov->tipo_movimento_id = config("constantes.tipo_movimento.SEM_MOVIMENTO");
            $mov->produto_id        = $item->produto_id; 
            $mov->grade_id          = $request->grade_id;
            $mov->estorno           = 'N';
            $mov->data_movimento    = hoje();
            $mov->qtde_movimento    = $request->qtde;
            if($request->campo=="item_orcamento_id"){
                $mov->item_orcamento_id = $item->id;    
                $mov->orcamento_id      = $item->orcamento_id;
                $mov->ent_sai       = 'S';                
                $mov->descricao     = "Saída Por Venda - Item: #" . $item->id;
            }else if($request->campo=="item_compra_id"){
                $mov->item_compra_id   = $item->id; 
                $mov->compra_id        = $item->compra_id;
                $mov->ent_sai           = 'E';                
                $mov->descricao         = "Entrada Por Compra - Item: #" . $item->id;
            }   
            
            if($mov->qtde_movimento > 0){
                GradeMovimentoTemp::Create(objToArray($mov));
            }
            
            //Listando os movimentos do item
            $lista          = GradeMovimentoTemp::where($request->campo, $request->item_id)->get();
            $movimentos     = array();
            foreach($lista as $l){
                $grade              = $l->grade;
                $movimento          = new \stdClass();
                $movimento->id      = $l->id;
                $movimento->descricao = $grade->descricao;
                $movimento->linha   = $grade->linha->valor;
                $movimento->coluna  = $grade->coluna->valor;
                $movimento->qtde    = $l->qtde_movimento;
                $movimentos[] = $movimento;
            }
            
            
            $retorno->tem_erro  = false;
            $retorno->titulo    = "Item Inserido com Sucesso";
            $retorno->erro      = "";
            $retorno->qtde_movimento = GradeMovimentoTemp::where($request->campo, $request->item_id)->sum('qtde_movimento');       
            $retorno->movimentos = $movimentos;
            return response()->json($retorno);
        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->titulo    = "Erro ao Salvar Venda";
            $retorno->erro      = $e->getMessage();
            return response()->json($retorno);
        }
    }
    
    public function store(Request $request)
    {
        $retorno  = new \stdClass();
        try {
            $item                 = ItemVenda::find($request->item_venda_id);   
            $mov                    = new \stdClass();
            $mov->tipo_movimento_id = config("constantes.tipo_movimento.SEM_MOVIMENTO");
            $mov->produto_id        = $item->produto_id;
            $mov->item_venda_id     = $item->id;
            $mov->grade_id          = $request->grade_id;
            $mov->ent_sai           = 'S';
            $mov->estorno           = 'N';
            $mov->data_movimento    = hoje();
            $mov->qtde_movimento    = $request->qtde;
            $mov->descricao         = "Saída Por Venda - Item: #" . $item->id;
            if($mov->qtde_movimento > 0){
                GradeMovimento::Create(objToArray($mov));
            }           
            
            $retorno->tem_erro  = false;
            $retorno->titulo    = "Item Inserido com Sucesso";
            $retorno->erro      = "";
            $retorno->redirect  =  url("admin/venda/edit", $item->venda_id );
            $retorno->retorno   = $item->venda_id;
            return response()->json($retorno);
        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->titulo    = "Erro ao Salvar Venda";
            $retorno->erro      = $e->getMessage();
            return response()->json($retorno);
        }
    }

   
    public function show($id_grade){
        $grade                  = GradeProduto::find($id_grade);
        $dados["grade"]         = $grade;
        $dados["produto"]       = $grade->produto;
        $dados["lista"]         = GradeMovimento::where("grade_id", $grade->id)->get();
        $dados["soma_entrada"]  = 0;
        $dados["soma_saida"]    = 0;
        $dados["qtde_entrada"]  = GradeMovimento::where("ent_sai",'E')->where("grade_id", $grade->id)->sum("qtde_movimento");
        $dados["qtde_saida"]    = GradeMovimento::where("ent_sai",'S')->where("grade_id", $grade->id)->sum("qtde_movimento");
        $dados["produtos"]      = Produto::get();
        return view("Admin.Estoque.Movimento.EstoqueGrade", $dados);
    }

    
    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy( $id){
        try {
            $mov = GradeMovimentoTemp::find($id);            
            $mov->delete();
            
            $lista          = GradeMovimentoTemp::where("item_orcamento_id", $mov->item_orcamento_id)->get();
            $movimentos     = array();
            foreach($lista as $l){
                $grade              = $l->grade;
                $movimento          = new \stdClass();
                $movimento->id      = $l->id;
                $movimento->descricao = $grade->descricao;
                $movimento->linha   = $grade->linha->valor;
                $movimento->coluna  = $grade->coluna->valor;
                $movimento->qtde    = $l->qtde_movimento;
                $movimentos[] = $movimento;
            }
            
            
            $retorno = new \stdClass();
            $retorno->qtde_movimento = GradeMovimentoTemp::where("item_orcamento_id", $mov->item_orcamento_id)->sum('qtde_movimento');
            $retorno->movimentos   = $movimentos;
            
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
