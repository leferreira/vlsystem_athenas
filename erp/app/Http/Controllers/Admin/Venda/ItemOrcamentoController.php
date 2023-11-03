<?php

namespace App\Http\Controllers\Admin\Venda;

use App\Http\Controllers\Controller;
use App\Models\ItemOrcamento;
use App\Models\Orcamento;
use Illuminate\Http\Request;
use App\Service\ItemOrcamentoService;

class ItemOrcamentoController extends Controller
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $retorno  = new \stdClass();
        
        try {
            $item      = (object) $request->itens[0];
           
            ItemOrcamentoService::inserirItem($item);
            
            $retorno->tem_erro  = false;
            $retorno->titulo    = "Item Inseridocom Sucesso";
            $retorno->erro      = "";
            $retorno->redirect  =  url("admin/orcamento/edit",$item->orcamento_id );
            $retorno->retorno   = $item->orcamento_id;
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
            $h = ItemOrcamento::find($id);
            $h->delete();
            Orcamento::somarTotal($h->orcamento_id);
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
