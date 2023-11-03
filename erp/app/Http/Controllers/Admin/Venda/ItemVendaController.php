<?php

namespace App\Http\Controllers\Admin\Venda;

use App\Http\Controllers\Controller;
use App\Models\GradeMovimento;
use App\Models\GradeProduto;
use App\Models\ItemVenda;
use App\Models\Venda;
use App\Service\ItemVendaService;
use Illuminate\Http\Request;

class ItemVendaController extends Controller
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

  
    public function create()
    {
        //
    }
    
    public function ajustarGrade(Request $request)
    {
        $retorno  = new \stdClass();
        try {
            $estoque_grade   = $request->estoque_grade ?? null;
           
            $item            = ItemVenda::find($request->item_venda_id);
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
                    $mov->item_venda_id    = $item->id;
                    $mov->grade_id          = $grade->id;
                    $mov->ent_sai           = 'S';
                    $mov->estorno           = 'N';
                    $mov->data_movimento    = hoje();
                    $mov->qtde_movimento    = $estoque["qtde"];
                    $mov->descricao         = "Entrada Por Venda - Item: #" . $item->id;
                    if($mov->qtde_movimento > 0){
                        GradeMovimento::Create(objToArray($mov));
                    }
                }
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
    

  
    public function store(Request $request)
    {
        $retorno  = new \stdClass();        
        try {            
            
            $item      = (object) $request->itens[0];          
            ItemVendaService::inserirItem($item);           
            //fazet saida se for grade
            
              
            $retorno->tem_erro  = false;
            $retorno->titulo    = "Item Inseridocom Sucesso";
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

    
    public function edit($id)
    {
        //
    }

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
            $h = ItemVenda::find($id);
            $h->delete();
            Venda::somarTotal($h->venda_id);
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
