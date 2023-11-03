<?php

namespace App\Http\Controllers\Admin\Configuracao;

use App\Http\Controllers\Controller;
use App\Models\NaturezaOperacao;
use App\Models\Parametro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParametroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $dados["parametro"] = Parametro::where("empresa_id",Auth::user()->empresa_id)->first();
        $dados["naturezas"] = NaturezaOperacao::all();
        return view("Admin.Configuracao.Parametro.Create", $dados);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dados["naturezas"] = NaturezaOperacao::all();
        return view("Admin.Parametro.Create", $dados);
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
        $req["margem_lucro"] = getFloat($req["margem_lucro"]);
    
        Parametro::Create($req);
        return redirect()->route('parametro.index');
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
        
        $dados["parametro"] = Parametro::find($id);
        return view('admin.Parametro.Create', $dados);
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
        $req                          = $request->except(["_token","_method"]);  
        $req["margem_lucro"]          = getFloat($req["margem_lucro"]);
        $req["estoque_minimo_padrao"] = getFloat($req["estoque_minimo_padrao"]);
        $req["estoque_maximo_padrao"] = getFloat($req["estoque_maximo_padrao"]);
        Parametro::where("id", $id)->update($req);
        return redirect()->route("admin.parametro.index")->with('msg_sucesso', "Registro atualizado  com sucesso.");
    }

    
    public function destroy($id)
    {
        try{
            $h = Parametro::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Ítem apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
