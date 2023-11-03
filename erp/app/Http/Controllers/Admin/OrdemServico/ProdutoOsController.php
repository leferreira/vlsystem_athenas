<?php

namespace App\Http\Controllers\Admin\OrdemServico;

use App\Http\Controllers\Controller;
use App\Models\ItemVenda;
use App\Models\Venda;
use Illuminate\Http\Request;
use App\Models\ProdutoOs;
use App\Models\OrdemServico;

class ProdutoOsController extends Controller
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
            $item->os_id             = $req["os_id"];
            $item->produto_id        = $req['produto_id'];
            $item->quantidade        =  getFloat($req['quantidade']);
            $item->unidade           =  $req['unidade'];
            $item->valor             =  getFloat($req['valor']);
            $item->subtotal          =  getFloat($req['valor']) * getFloat($req['quantidade']);
            $item->desconto_por_valor = $req["desconto_por_valor"] ;
            $item->desconto_percentual = $req["desconto_percentual"];
            $item->desconto_por_unidade = 0;
            
            if($item->desconto_por_valor > 0){
                $item->desconto_por_unidade = $item->desconto_por_valor;
            }
            
            if($item->desconto_percentual > 0){
                $item->desconto_por_unidade = $item->desconto_percentual * $item->valor * 0.01;
            }
            $item->total_desconto_item  =  $item->desconto_por_unidade * $item->quantidade;
            $item->subtotal_liquido     =  ($item->valor - $item->desconto_por_unidade )  * $item->quantidade;            
            ProdutoOs::Create(objToArray($item));
            echo json_encode(["tem_erro"=>false, "msg_erro"=>""]);
        } catch (\Exception $e) {
            echo json_encode($e->getMessage());
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
            $h = ProdutoOs::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
