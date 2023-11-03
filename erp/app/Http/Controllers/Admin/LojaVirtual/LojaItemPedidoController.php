<?php

namespace App\Http\Controllers\Admin\LojaVirtual;

use App\Http\Controllers\Controller;
use App\Models\LojaCategoriaProduto;
use App\Models\LojaItemPedido;
use App\Models\Produto;
use Illuminate\Http\Request;
use App\Service\ItemLojaPedidoService;

class LojaItemPedidoController extends Controller
{
    
    public function index()
    {
        $dados["lista"] = LojaItemPedido::get();
        return view("Admin.Loja.LojaItemPedido.Index", $dados);
    }

    
    public function create()
    {
        $dados["clientes"] = Produto::get();
        $dados["categorias"] = LojaCategoriaProduto::get();
        return view("Admin.Loja.LojaItemPedido.Create", $dados);
    }

    public function store(Request $request)
    {
        $req = $request->except(["_token","_method"]);       
        
        try {
            $dados = (object) $req;
            ItemLojaPedidoService::inserirItem($dados);
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
        $dados["cliente"]     = LojaItemPedido::find($id);
        $dados["clientes"]    = Produto::get();
        $dados["categorias"]  = LojaCategoriaProduto::get();
        return view('Admin.Loja.LojaItemPedido.Create', $dados);
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
        LojaItemPedido::where("id", $id)->update($req);
        return redirect()->route("admin.loja.lojacliente.index");
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
            $h = LojaItemPedido::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Ítem apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
