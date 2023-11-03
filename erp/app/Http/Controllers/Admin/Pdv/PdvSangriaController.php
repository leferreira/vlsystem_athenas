<?php

namespace App\Http\Controllers\Admin\Pdv;

use App\Http\Controllers\Controller;
use App\Http\Requests\PdvSangriaRequest;
use App\Models\PdvSangria;

class PdvSangriaController extends Controller
{    
    public function index()
    {
        $dados["lista"]     = PdvSangria::get();
        return view("Admin.Pdv.Sangria.Index", $dados);
    }
    
       
    public function store(PdvSangriaRequest $request){        
        $req = $request->except(["_token","_method"]);
        PdvSangria::Create($req);
        return redirect()->route('admin.caixanumero.index')->with('msg_sucesso', "Inserido com sucesso.");
    }

    public function show($id)
    {
        //
    }
   
    public function edit($id){
        $dados["caixanumero"]     = PdvSangria::find($id);
        $dados["lista"]         = PdvSangria::get();
        return view('Admin.Pdv.PdvSangria.Index', $dados);
    }
   
    public function update(PdvSangriaRequest $request, $id)
    {
        $req     =   $request->except(["_token","_method"]);
        PdvSangria::where("id", $id)->update($req);
        return redirect()->route("admin.caixanumero.index")->with('msg_sucesso', "item alterado com sucesso.");;
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
            $h = PdvSangria::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
