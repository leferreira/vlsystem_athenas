<?php

namespace App\Http\Controllers\Admin\OrdemServico;

use App\Http\Controllers\Controller;
use App\Models\ItemVenda;
use App\Models\Venda;
use Illuminate\Http\Request;
use App\Models\ProdutoOs;
use App\Models\OrdemServico;
use App\Models\ServicoOs;
use App\Models\AnotacaoOs;

class AnotacaoOsController extends Controller
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
        $req = $request->except(["_token","_method"]);        
        
        try {
            $item = new \stdClass();
            $item->os_id            = $req["os_id"];
            $item->data             = hoje();
            $item->hora             =  agora();
            $item->anotacao         =  $req['anotacao'];
            AnotacaoOs::Create(objToArray($item));
            return redirect()->route('admin.ordemservico.edit', $item->os_id)->with('msg_sucesso', "Inserido com sucesso.");
        } catch (\Exception $e) {
            return redirect()->route('admin.ordemservico.edit', $item->os_id)->with('msg_erro', $e->getMessage());
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
            $h = AnotacaoOs::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
