<?php

namespace App\Http\Controllers\Acl;

use App\Http\Controllers\Controller;
use App\Models\Funcao;
use App\Models\FuncaoPermissao;
use App\Models\Permissao;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FuncaoUser;

class FuncaoUsuarioController extends Controller
{
    protected $funcao, $usuario;
    
    public function __construct(Funcao $funcao, User $usuario)
    {
        $this->funcao       = $funcao;
        $this->usuario    = $usuario;
        
        //$this->middleware(['can:profiles']);
    }
    
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        $req         = $request->except(["_token","_method"]);
        
        FuncaoUser::firstOrCreate ($req);
        return redirect()->route('admin.usuario.funcoes',$req["user_id"]);
    }  
    
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $dados["funcao"] = Funcao::find($id);
        $dados["funcaos"] = Funcao::all();
        return view('Funcao.Create', $dados);
    }
    
    public function update(Request $request, $id)
    {
        $req     =   $request->except(["_token","_method"]);
        Permissao::where("id", $id)->update($req);
        return redirect()->route("permissao.index");
    }

    public function destroy($id)
    {
        try{
            $h = FuncaoUser::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
