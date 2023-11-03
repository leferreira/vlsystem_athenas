<?php

namespace App\Http\Controllers\Admin\Pdv;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Acl\PermissaoTrait;
use App\Http\Requests\NumeroCaixaRequest;
use App\Models\Assinatura;
use App\Models\PdvCaixaNumero;
use Illuminate\Support\Facades\Auth;

class PdvNumeroCaixaController extends Controller
{
    use PermissaoTrait;
    public function __construct()
    {
        $this->modelName = 'pdv_num_pdv';
        
    }
    
    public function index()
    {
        $dados["lista"] = PdvCaixaNumero::get();
        return view("Admin.Pdv.NumeroCaixa.Index", $dados);
    }
    
       
    public function store(NumeroCaixaRequest $request){
        $this->checaPermissao(__FUNCTION__);
        $pdvs = PdvCaixaNumero::get();
        $assinatura = Assinatura::where("empresa_id", Auth::user()->empresa_id)->where("status_id", config("constantes.status.ATIVO"))->first();
      
        if( count($pdvs)  >= $assinatura->planopreco->plano->limite_pdv){
            return redirect()->route("admin.numerocaixa.index")->with('msg_erro', "Você alcançou o limite de PDVs contratado no seu plano.");
        }
        $req = $request->except(["_token","_method"]);      
        
        PdvCaixaNumero::Create($req);
        return redirect()->route('admin.numerocaixa.index')->with('msg_sucesso', "Inserido com sucesso.");
    }

    public function show($id)
    {
        //
    }
   
    public function edit($id){
        $dados["numerocaixa"]     = PdvCaixaNumero::find($id);
        $dados["lista"]         = PdvCaixaNumero::get();
        return view('Admin.Pdv.NumeroCaixa.Index', $dados);
    }
   
    public function update(NumeroCaixaRequest $request, $id)
    {
        $req     =   $request->except(["_token","_method"]);
        PdvCaixaNumero::where("id", $id)->update($req);
        return redirect()->route("admin.numerocaixa.index")->with('msg_sucesso', "item alterado com sucesso.");;
    }

   
    public function destroy($id)
    {
        try{
            $h = PdvCaixaNumero::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
