<?php

namespace App\Http\Controllers\Admin\Financeiro;

use App\Http\Controllers\Controller;
use App\Http\Requests\CentroCustoRequest;
use App\Models\CentroCusto;
use Illuminate\Http\Request;

class CentroCustoController extends Controller
{
    
    public function index()
    {
        $dados["centrocustos"] = CentroCusto::get();
        return view("Admin.Financeiro.CentroCusto.Index", $dados);
    }

    
    public function create()
    {
        return view("Admin.Financeiro.CentroCusto.Create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CentroCustoRequest $request){        
        $req = $request->except(["_token","_method"]);
        $req["empresa_id"] = session('empresa_selecionada_id');
        CentroCusto::firstOrCreate($req);
        return redirect()->route('admin.centrocusto.index')->with('msg_sucesso', "Inserido com sucesso.");
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
    public function edit($id){
        $dados["centrocusto"]     = CentroCusto::find($id);
        $dados["centrocustos"]    = CentroCusto::get();
        return view('Admin.Financeiro.CentroCusto.Index', $dados);
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
        CentroCusto::where("id", $id)->update($req);
        return redirect()->route("admin.centrocusto.index")->with('msg_sucesso', "item alterado com sucesso.");;
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
            $h = CentroCusto::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
