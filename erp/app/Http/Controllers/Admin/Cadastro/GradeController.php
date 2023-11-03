<?php

namespace App\Http\Controllers\Admin\Cadastro;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Acl\PermissaoTrait;
use App\Models\Banco;
use App\Models\CentroCusto;
use App\Models\Fornecedor;
use App\Models\GradeMovimento;
use App\Models\GradeProduto;
use App\Models\ItemVariacaoGrade;
use App\Models\Produto;
use App\Models\Transportadora;
use App\Service\GradeService;
use App\Service\MovimentoService;
use Illuminate\Http\Request;
use App\Models\GradeMovimentoTemp;

class GradeController extends Controller
{
    use PermissaoTrait;
    public function __construct(){
        $this->modelName = 'banco';
    }
    
    public function index()
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["bancos"] = Banco::get();
        return view("Admin.Cadastro.Banco.Index", $dados);
    }
    
    
    public function create()
    {
        $this->checaPermissao(__FUNCTION__);
        return view("Admin.Cadastro.Banco.Create");
    }
    
    public function alterarCodigoBarra(Request $request)
    {   $retorno = new \stdClass();
        try {
            $tem = GradeProduto::where("codigo_barra", $request->codigo_barra)->first();
            if($tem){
                throw new \Exception('Já existe um produto com este código'); 
            }
            $grade = GradeProduto::find($request->grade_id);
            $grade->codigo_barra = $request->codigo_barra;
            $grade->save();
            $retorno->tem_erro   = false;
            return response()->json($retorno);
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return response()->json($retorno);
        }
    }
    
    public function gradeComMovimento(Request $request){     
        $retorno = new \stdClass();       
        try {
            $lista          = GradeMovimento::where($request->campo, $request->item_id)->get(); 
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
                      
            $grade               = GradeService::montar($request->produto_id);
            
            $retorno->tem_erro   = false;
            $retorno->grade      = $grade;
            $retorno->movimentos = $movimentos;
            $retorno->qtde_movimento = GradeMovimento::where($request->campo, $request->item_id)->sum('qtde_movimento');
        
            return response()->json($retorno);
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->retorno = $e->getMessage();
            return response()->json($retorno);
        }        
        
    }
    
    public function gradeTempComMovimento(Request $request){
        $retorno = new \stdClass();
        try {
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
            
            $grade               = GradeService::montar($request->produto_id);
            
            $retorno->tem_erro   = false;
            $retorno->grade      = $grade;
            $retorno->movimentos = $movimentos;
            $retorno->qtde_movimento = GradeMovimentoTemp::where($request->campo, $request->item_id)->sum('qtde_movimento');
            
            return response()->json($retorno);
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->retorno = $e->getMessage();
            return response()->json($retorno);
        }
        
    }
    
    public function gradeParaEntradaSaida(Request $request){
        $retorno = new \stdClass();
        try {           
            $grade               = GradeService::montar($request->produto_id);            
            $retorno->tem_erro   = false;
            $retorno->grade      = $grade;
            
            return response()->json($retorno);
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->retorno = $e->getMessage();
            return response()->json($retorno);
        }
        
    }
    
    public function listaJs($produto_id){
        $retorno = new \stdClass();
        /*$retorno->grade            = GradeProduto::where("produto_id", $produto_id)->with("linha")->with("coluna")->get();
        $variacao_grade_linha_id   = $retorno->grade[0]->variacao_grade_linha_id ?? null;
        $variacao_grade_coluna_id  = $retorno->grade[0]->variacao_grade_coluna_id ?? null;    
        $retorno->soma_estoque     = GradeProduto::where("produto_id", $produto_id)->sum("estoque");
        $retorno->linha            = VariacaoGrade::find($variacao_grade_linha_id);
        $retorno->coluna           = VariacaoGrade::find($variacao_grade_coluna_id);*/
        try {
            $grade = GradeService::montar($produto_id);
            $retorno->tem_erro   = false;
            $retorno->retorno    = $grade;            
            return response()->json($retorno);
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->retorno = $e->getMessage();
            return response()->json($retorno);
        }
        
        
    }
    
    public function gerar(Request $request){       
        $req = $request->except(["_token","_method"]);
        $linhas = ItemVariacaoGrade::where("variacao_grade_id", $req["variacao_linha_id"])->get();         
        foreach($linhas as $l){
            $colunas = ItemVariacaoGrade::where("variacao_grade_id", $req["variacao_coluna_id"])->get();
            foreach($colunas as $c){
                $grade = new \stdClass();
                $grade->produto_id = $req["produto_principal_id"];
                $grade->variacao_grade_linha_id = $l->variacao_grade_id;
                $grade->linha_id   = $l->id;
                $grade->variacao_grade_coluna_id = $c->variacao_grade_id;
                $grade->coluna_id  = $c->id;
                $grade->estoque     = 0;
                $grade->estoque_temporario     = 0;
                GradeProduto::Create(objToArray($grade));
            }
        }
        return redirect()->route('admin.produto.edit',$req["produto_principal_id"])->with('msg_sucesso', "Inserido com sucesso.");
    }
    
    public function inserirEstoque(Request $request){
        try {
            $qtde           = getFloat($request->qtde); 
            $retorno        = new \stdClass();            
            $grade          = GradeProduto::find($request->id);
            $produto        = Produto::find($grade->produto_id);           
            $total          = GradeProduto::where("produto_id", $grade->produto_id)->sum("estoque");            
       
            
            $tem_movimento = GradeMovimento::where("grade_id", $grade->id)->first();
            if($tem_movimento){
                throw new \Exception('Não é mais possível movimentar o estoque deste produto por aqui'); 
            }
           
            $mov                    = new \stdClass();
            $mov->tipo_movimento_id = config("constantes.tipo_movimento.ENTRADA_INICIO_ESTOQUE");
            $mov->produto_id        = $produto->id;
            $mov->grade_id          = $grade->id;
            $mov->ent_sai           = 'E';
            $mov->estorno           = 'N';
            $mov->data_movimento    = hoje();
            $mov->qtde_movimento    = $qtde;
            $mov->descricao         = "Início de Estoque - Cadastro Produto";
            if($mov->qtde_movimento > 0){
                $foi = GradeMovimento::Create(objToArray($mov));
            }
              
            $total              = GradeProduto::where("produto_id", $grade->produto_id)->sum("estoque");
            $retorno->tem_erro  = false;
            $retorno->total     = $total; 
            return response()->json($retorno);
            
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return response()->json($retorno);
            
        }
    }
    
    public function listarBanco(){
        $lista = Banco::get();
        echo json_encode($lista);
    }
   
    public function store(Request $request){
        $linhas  = $request->linhas ?? null;
        $colunas = $request->colunas ?? null;
        try {
            if($linhas == null  || $colunas == null ){
                throw new \Exception('Selecione a linha e a coluna para gerar a grade');
            }
            
            for($l=0; $l < count($linhas) ; $l++ ){
                for($c=0; $c < count($colunas) ; $c++ ){
                    $linha = ItemVariacaoGrade::find($linhas[$l]);
                    $coluna = ItemVariacaoGrade::find($colunas[$c]);
                    
                    $grade = new \stdClass();
                    $grade->produto_id              = $request->produto_grade_id;
                    $grade->descricao               = $linha->valor ." / " .$coluna->valor ;
                    $grade->variacao_grade_linha_id = $request->variacao_grade_linha_id;
                    $grade->linha_id                = $linhas[$l];
                    $grade->variacao_grade_coluna_id= $request->variacao_grade_coluna_id;
                    $grade->coluna_id               = $colunas[$c];
                    $grade->estoque                 = 0;
                    $grade->codigo_barra            = zeroEsquerda($grade->produto_id, 5) . zeroEsquerda($grade->linha_id, 3)  . zeroEsquerda($grade->coluna_id, 3);
                    $tem = GradeProduto::where(["produto_id"=>$grade->produto_id,"linha_id" =>$grade->linha_id, "coluna_id" =>$grade->coluna_id ])->first();
                    if(!$tem){
                        $grade = GradeProduto::Create(objToArray($grade));
                    }
                    
                }
                
            }
            
            //Exclui o estoque inicial
            $produto = $grade->produto;
            if($produto->estoque_inicial > 0){
                $mov                    = new \stdClass();
                $mov->tipo_movimento_id = config("constantes.tipo_movimento.ESTORNO_ESTQOUE_INICIAL");
                $mov->produto_id        = $produto->id;
                $mov->ent_sai           = 'S';
                $mov->estorno           = 'N';
                $mov->data_movimento    = hoje();
                $mov->qtde_movimento    = $produto->estoque_inicial;
                $mov->valor_movimento   = $produto->valor_venda;
                $mov->subtotal_movimento= $produto->estoque_inicial * $produto->valor_venda;
                $mov->descricao         = "Estorno de Estoque Inicial - Cadastro Grade";
                MovimentoService::inserir($mov);    
                
                $produto->estoque_inicial = 0;
                $produto->save();
            }
            
            return redirect()->route('admin.produto.edit', $request->produto_grade_id)->with('msg_sucesso', "Inserido com sucesso.");
        } catch (\Exception $e) {
            return redirect()->back()->with('msg_erro', $e->getMessage());
        }
        
        
 
        
    }

    public function show($id)
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["fornecedores"]      = Fornecedor::get();
        $dados["transportadoras"]   = Transportadora::get();
        $dados["produtos"]          = Produto::get();
        $dados["centro_custos"]     = CentroCusto::get();
        $dados["excluirJS"]           = true;
        return view("Admin.Excluir.Create", $dados);
    }
   
    public function edit($id){
        $dados["banco"]     = Banco::find($id);
        $dados["bancos"]    = Banco::get();
        return view('Admin.Cadastro.Banco.Index', $dados);
    }
   
    public function update(Request $request, $id)
    {
        $this->checaPermissao(__FUNCTION__);
        $req     =   $request->except(["_token","_method"]);
        Banco::where("id", $id)->update($req);
        return redirect()->route("admin.banco.index")->with('msg_sucesso', "item alterado com sucesso.");;
    }

    public function destroy( $id){
        try {
            $composicao = GradeProduto::find($id);
            $composicao->delete();
            $retorno = new \stdClass();
            $retorno->retorno   = GradeProduto::where("produto_id", $composicao->produto_id)->get();
            
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
