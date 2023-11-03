<?php

namespace App\Http\Controllers\Admin\Pdv;

use App\Http\Controllers\Controller;
use App\Http\Requests\PdvCaixaRequest;
use App\Models\PdvCaixa;
use Illuminate\Http\Request;

class PdvCaixaController extends Controller
{
    
    public function index()
    {
        $dados["lista"] = PdvCaixa::get();       
        return view("Admin.Pdv.Caixa.Index", $dados);
    }
           
    public function store(Request $request){        
        $req = $request->except(["_token","_method"]);
        $req["data_abertura"] = hoje();
        $req["hora_abertura"] = agora();
        $req["usuario_abriu_id"] = auth()->user()->id;
        $req["status_id"] = config("constantes.status.ABERTO");
        PdvCaixa::Create($req);
        echo json_encode("ok");
    }

    public function show($id)
    {
        //
    }
   
    public function edit($id){
        $dados["caixanumero"]     = PdvCaixa::find($id);
        $dados["lista"]         = PdvCaixa::get();
        return view('Admin.Pdv.PdvCaixa.Index', $dados);
    }
   
    
    public function update(PdvCaixaRequest $request, $id)
    {
        $req     =   $request->except(["_token","_method"]);
        PdvCaixa::where("id", $id)->update($req);
        return redirect()->route("admin.caixanumero.index")->with('msg_sucesso', "item alterado com sucesso.");;
    }
    
    public function buscarCaixaPorNumero($id){
        $lista = PdvCaixa::where("caixanumero_id", $id)->get();
        echo json_encode($lista);
    }
    
    public function destroy($id)
    {
        try{
            $h = PdvCaixa::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
