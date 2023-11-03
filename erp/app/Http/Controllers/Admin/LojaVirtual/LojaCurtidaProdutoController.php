<?php

namespace App\Http\Controllers\Admin\LojaVirtual;

use App\Http\Controllers\Controller;
use App\Models\LojaCategoriaProduto;
use App\Models\LojaCurtidaProduto;
use App\Models\Produto;
use Illuminate\Http\Request;

class LojaCurtidaProdutoController extends Controller
{
    
    public function index()
    {
        $dados["lista"] = LojaCurtidaProduto::get();
        return view("Admin.Loja.LojaCurtidaProduto.Index", $dados);
    }

    
    public function create()
    {
        $dados["clientes"] = Produto::get();
        $dados["categorias"] = LojaCategoriaProduto::get();
        return view("Admin.Loja.LojaCurtidaProduto.Create", $dados);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){      
        
        $req = $request->except(["_token","_method"]);
        $req["empresa_id"] = session('empresa_selecionada_id');
        LojaCurtidaProduto::Create($req);
        return redirect()->route('admin.loja.lojacliente.index');
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
        $dados["cliente"]     = LojaCurtidaProduto::find($id);
        $dados["clientes"]    = Produto::get();
        $dados["categorias"]  = LojaCategoriaProduto::get();
        return view('Admin.Loja.LojaCurtidaProduto.Create', $dados);
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
        LojaCurtidaProduto::where("id", $id)->update($req);
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
            $h = LojaCurtidaProduto::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Ítem apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
