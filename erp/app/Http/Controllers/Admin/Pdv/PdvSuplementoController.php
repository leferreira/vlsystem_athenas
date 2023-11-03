<?php

namespace App\Http\Controllers\Admin\Pdv;

use App\Http\Controllers\Controller;
use App\Http\Requests\PdvSuplementoRequest;
use App\Models\PdvSuplemento;

class PdvSuplementoController extends Controller
{
    
    public function index()
    {
        $dados["lista"] = PdvSuplemento::get();
        return view("Admin.Pdv.Suplemento.Index", $dados);
    }    
       
    public function store(PdvSuplementoRequest $request){        
        $req = $request->except(["_token","_method"]);
        PdvSuplemento::Create($req);
        return redirect()->route('admin.suplemento.index')->with('msg_sucesso', "Inserido com sucesso.");
    }

    public function show($id)
    {
        //
    }
   
    public function edit($id){
        $dados["suplemento"]     = PdvSuplemento::find($id);
        $dados["lista"]         = PdvSuplemento::get();
        return view('Admin.Pdv.Suplemento.Index', $dados);
    }
   
    public function update(PdvSuplementoRequest $request, $id)
    {
        $req     =   $request->except(["_token","_method"]);
        PdvSuplemento::where("id", $id)->update($req);
        return redirect()->route("admin.suplemento.index")->with('msg_sucesso', "item alterado com sucesso.");;
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
            $h = PdvSuplemento::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
