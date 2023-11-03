<?php

namespace App\Http\Controllers\Admin\Compra;

use App\Http\Controllers\Controller;
use App\Models\Compra;
use App\Models\GradeMovimento;
use App\Models\GradeProduto;
use App\Models\ItemCompra;
use Illuminate\Http\Request;
use App\Service\ItemCotacaoService;
use App\Service\ItemCompraService;

class ItemCompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    
    public function ajustarGrade(Request $request)
    {        
        $retorno  = new \stdClass();
        try {
            $estoque_grade   = $request->estoque_grade ?? null;
            $item            = ItemCompra::find($request->item_compra_id);
            //validar a quantidade
            $soma = 0;
            foreach($estoque_grade as $estoque){
                if($estoque["qtde"]){
                    $qtde = getFloat($estoque["qtde"]);
                    $soma += $qtde;
                }
            }
            
            if($soma != $item->quantidade){
                throw new \Exception('A quantidade de produto da grade ('. $soma .') é diferente da quantidade total ('.$item->quantidade.')  Verifique os dados digitados');
            }
                     
            foreach($estoque_grade as $estoque){
                if($estoque["qtde"]){
                    $grade                  = GradeProduto::find($estoque["id"]);
                    $mov                    = new \stdClass();
                    $mov->tipo_movimento_id = config("constantes.tipo_movimento.SEM_MOVIMENTO");
                    $mov->produto_id        = $item->produto_id;
                    $mov->item_compra_id    = $item->id;
                    $mov->grade_id          = $grade->id;
                    $mov->ent_sai           = 'E';
                    $mov->estorno           = 'N';
                    $mov->data_movimento    = hoje();
                    $mov->qtde_movimento    = $estoque["qtde"];
                    $mov->descricao         = "Entrada Por Compra - Item: #" . $item->id;
                    if($mov->qtde_movimento > 0){
                        GradeMovimento::Create(objToArray($mov));
                    }
                }
            }            
            
            $retorno->tem_erro  = false;
            $retorno->titulo    = "Item Inserido com Sucesso";
            $retorno->erro      = "";
            $retorno->redirect  =  url("admin/compra/edit", $item->compra_id );
          
            
            $retorno->retorno   = $item->compra_id;
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
            $item      = (object) $request->itens[0];            
            ItemCompraService::inserirItem($item);            
            $retorno->tem_erro  = false;
            $retorno->titulo    = "Item Inserido com Sucesso";
            $retorno->erro      = "";
            $retorno->redirect  =  url("admin/compra/edit", $item->compra_id );
            $retorno->retorno   = $item->compra_id;
            return response()->json($retorno);
        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->titulo    = "Erro ao Salvar Compra";
            $retorno->erro      = $e->getMessage();
            return response()->json($retorno);
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
        try{
            GradeMovimento::where("item_compra_id", $id)->delete();
            $h = ItemCompra::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getMessage();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
