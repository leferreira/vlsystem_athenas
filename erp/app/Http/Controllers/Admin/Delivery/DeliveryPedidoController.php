<?php

namespace App\Http\Controllers\Admin\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\ClienteDelivery;
use App\Models\ConfigNota;
use App\Models\EnderecoDelivery;
use App\Models\PedidoDelivery;
use App\Models\Produto;
use App\Models\Usuario;
use App\Service\PedidoDeliveryService;
use Illuminate\Http\Request;

class DeliveryPedidoController extends Controller
{
    
    public function index()
    {
       // $dados["pedidosPorStatus"] = PedidoDeliveryService::listaPedidoPorStatus(date("Y-m-d"), date('Y-m-d', strtotime('+1 day')) );     
        
        $dados["pedidosPorStatus"] = PedidoDelivery::get();   
        return view("Admin.Delivery.Pedido.Index", $dados);
    }

    public function create(){
        $dados["clientes"] = ClienteDelivery::all();
        $dados["enderecos"] = EnderecoDelivery::all();
        return view("Admin.Delivery.Pedido.Novo", $dados);
    }

 
    
    public function store(Request $request)
    {
       
        $req = $request->except(["_token","_method"]);
        Categoria::firstOrCreate($req);
        return redirect()->route('categoria.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dados["pedido"] = PedidoDelivery::find($id);        
        return view("Admin.Delivery.Pedido.Detalhe", $dados);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dados["categoria"] = Categoria::find($id);
        return view('admin.Categoria.Create', $dados);
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
        $req     =   $request->except(["_token","_method"]);
        Categoria::where("id", $id)->update($req);
        return redirect()->route("categoria.index");
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
            $h = Categoria::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Ítem apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
