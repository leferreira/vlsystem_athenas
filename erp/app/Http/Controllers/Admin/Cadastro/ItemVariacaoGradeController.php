<?php

namespace App\Http\Controllers\Admin\Cadastro;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Acl\PermissaoTrait;
use App\Http\Requests\ItemVariacaoGradeRequest;
use App\Models\VariacaoGrade;
use App\Models\ItemVariacaoGrade;
use App\Models\GradeProduto;
use Illuminate\Http\Request;

class ItemVariacaoGradeController extends Controller
{
    use PermissaoTrait;
    public function __construct(){
        $this->modelName = 'itemvariacaograde';
    }
    
    
    public function index()
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["lista"]             = ItemVariacaoGrade::get();
        $dados["variacoes"]         = VariacaoGrade::get();
        $dados["variacaoGradeJs"]   = true;
        return view("Admin.Cadastro.ItemVariacaoGrade.Index", $dados);
    }
    
    public function create()
    {
        $this->checaPermissao(__FUNCTION__);
        return view("Admin.Cadastro.ItemVariacaoGrade.Create");
    }

    public function salvarJs(ItemVariacaoGradeRequest $request){
        $retorno = new \stdClass();
        try {
            $item                    = new \stdClass();
            $item->variacao_grade_id = $request->variacao_grade_id;
            $item->valor             = $request->valor;
            $tem = ItemVariacaoGrade::where(["variacao_grade_id"=>$item->variacao_grade_id , "valor"=>$item->valor])->first();
            if($tem){
                throw(new \Exception('Ja existem um registro com este valor.'));
            }
            ItemVariacaoGrade::Create(objToArray($item));
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            $retorno->lista     = $this->listarItens($request->linha_id, $request->coluna_id, $request->produto_id);
            return response()->json($retorno);
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return $retorno;
        }
        
    }
    
    public function listarItens($linha_id, $coluna_id, $produto_id){
        $retorno = new \stdClass();
        try {
            $linhas  = ItemVariacaoGrade::where("variacao_grade_id", $linha_id)->get();
            $colunas = ItemVariacaoGrade::where("variacao_grade_id", $coluna_id)->get();
            foreach($linhas as $l){
                $linha_selecionada = GradeProduto::where(["produto_id"=>$produto_id,"linha_id" =>$l->id ])->first();
                $l->selecionado = 'N';
                if($linha_selecionada){
                    $l->selecionado = 'S';
                }
            }
            
            foreach($colunas as $c){
                $coluna_selecionada = GradeProduto::where(["produto_id"=>$produto_id,"coluna_id" =>$c->id ])->first();
                $c->selecionado = 'N';
                if($coluna_selecionada){
                    $c->selecionado = 'S';
                }
            }            
            
            $retorno->linhas  = $linhas;
            $retorno->colunas = $colunas;
            $retorno->linha   = VariacaoGrade::find($linha_id);
            $retorno->coluna  = VariacaoGrade::find($coluna_id);
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            
            return $retorno;
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return $retorno;
            
        }
    }
    
    public function lista($linha_id, $coluna_id, $produto_id){
        $retorno = $this->listarItens($linha_id, $coluna_id, $produto_id);
        return response()->json($retorno);
    }
    
    public function store(ItemVariacaoGradeRequest $request){ 
        try {
            $item                    = new \stdClass();
            $item->variacao_grade_id = $request->variacao_grade_id;
            $item->valor             = $request->valor;
            $tem = ItemVariacaoGrade::where(["variacao_grade_id"=>$item->variacao_grade_id , "valor"=>$item->valor])->first();
            if($tem){
                throw(new \Exception('Ja existe um registro com este valor.'));
            }
            ItemVariacaoGrade::Create(objToArray($item));
            return redirect()->route('admin.itemvariacaograde.index')->with('msg_sucesso', "Inserido com sucesso.");
         
        } catch (\Exception $e) {
            return redirect()->route('admin.itemvariacaograde.index')->with('msg_erro', "Erro: ". $e->getMessage());
        }
        
        
    }

    public function show($id)
    {
        //
    }
   
    public function edit($id){
        $this->checaPermissao(__FUNCTION__);
        $dados["itemvariacaograde"] = ItemVariacaoGrade::find($id);
        $dados["lista"]             = ItemVariacaoGrade::get();
        $dados["variacoes"]         = VariacaoGrade::get();
        $dados["variacaoGradeJs"]   = true;
        return view('Admin.Cadastro.ItemVariacaoGrade.Index', $dados);
    }
   
    
    public function update(ItemVariacaoGradeRequest $request, $id)
    {
        $this->checaPermissao(__FUNCTION__);
        $req     =   $request->except(["_token","_method"]);
        ItemVariacaoGrade::where("id", $id)->update($req);
        return redirect()->route("admin.itemvariacaograde.index")->with('msg_sucesso', "item alterado com sucesso.");;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->checaPermissao(__FUNCTION__);
        try{
            $h = ItemVariacaoGrade::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
