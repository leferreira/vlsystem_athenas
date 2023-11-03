<?php

namespace App\Http\Controllers\Admin\Compra;

use App\Http\Controllers\Controller;
use App\Models\ItemOrdemCompra;
use App\Models\OrdemCompra;
use Illuminate\Http\Request;

class ItemOrdemCompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $req = $request->all();
     
       $tem = ItemOrdemCompra::where("ordem_compra_id",$req["ordem_compra_id"])->where("produto_id", $req["produto_id"])->first();
       if(!$tem){
           ItemOrdemCompra::create($req);
       }  
       OrdemCompra::atualizaTotal($req["ordem_compra_id"]);
       $lista = ItemOrdemCompra::where("ordem_compra_id", $req["ordem_compra_id"])->with("produto")->get(); 
       return response()->json($lista);
       
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
    public function edit($id) {        
        $dados["itens"] = ItemOrdemCompra::where("ordem_compra_id", $id)->get();
        $dados["ordem"] = OrdemCompra::where("id", $id)->first();     
        $dados["ordemCompraJs"] = true;
        return view("Admin.ItemOrdemCompra.Create",$dados);
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
        $item = ItemOrdemCompra::where("id",$id)->first();
        $id_ordem = $item->ordem_compra_id;
        $item->delete();
        OrdemCompra::atualizaTotal($id_ordem);
        $lista = ItemOrdemCompra::listaPorIdOrdemCompra($id_ordem);
        return response()->json($lista);
    }
}
