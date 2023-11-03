<?php

namespace App\Http\Controllers\Admin\Cadastro;

use App\Http\Controllers\Controller;
use App\Models\Tributacao;
use Illuminate\Http\Request;
use App\Http\Controllers\Acl\PermissaoTrait;

class TributacaoController extends Controller
{
    use PermissaoTrait;
    public function __construct(){
        $this->modelName = 'tributacao';
    }
    
    public function index()
    {
        $this->checaPermissao(__FUNCTION__);
        $dados["lista"] = Tributacao::where('empresa_id', session('empresa_selecionada_id'))->get();
        return view("Admin.Cadastro.Tributacao.Index", $dados);
    }

    
    public function create()
    {
        $this->checaPermissao(__FUNCTION__);
        return view("Admin.Cadastro.Tributacao.Create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $this->checaPermissao(__FUNCTION__);
        
        $req = $request->except(["_token","_method"]);
        $req["empresa_id"] = session('empresa_selecionada_id');
        Tributacao::firstOrCreate($req);
        return redirect()->route('admin.tributacao.index');
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
        $dados["tributacao"]     = Tributacao::find($id);
        $dados["tributacaos"]    = Tributacao::where('empresa_id', session('empresa_selecionada_id'))->get();
        return view('Admin.Cadastro.Tributacao.Index', $dados);
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
        $this->checaPermissao(__FUNCTION__);
        $req     =   $request->except(["_token","_method"]);
        Tributacao::where("id", $id)->update($req);
        return redirect()->route("admin.tributacao.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->checaPermissao(__FUNCTION__);
        try{
            $h = Tributacao::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Ítem apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
