<?php

namespace App\Http\Controllers\Admin\Configuracao;

use App\Http\Controllers\Controller;
use App\Models\Perfil;
use App\Models\PerfilUser;
use App\Models\Status;
use App\Models\User;
use App\Models\UserEmpresa;
use Illuminate\Http\Request;

class PerfilUsuarioController extends Controller
{
    
    public function index()
    {
        $dados["usuarios"] = UserEmpresa::where('empresa_id', session('empresa_selecionada_id'))->get();
        return view("Admin.Configuracao.Usuario.Index", $dados);
    }

    
    public function create()
    {        
        $dados["status"] = Status::all();
        $dados["perfis"] = Perfil::where('empresa_id', session('empresa_selecionada_id'))->get();
        return view("Admin.Configuracao.Usuario.Create", $dados);
    }


    
    public function store(Request $request){
        try{
            $req                = $request->except(["_token","_method"]);
            PerfilUser::Create($req);           
            return redirect()->route("admin.usuario.perfis", $req["user_id"] )->with('msg_sucesso', "Cadastro realizado com sucesso.");
        }catch (\Exception $e){
            return redirect()->back()->with('msg_erro', "Houve um problema na tentativa de cadastro [{$e->getMessage()}]");
        }
        
    }

      
    public function atribuirPerfilUsuario(Request $request, $id){
        try{
            $h = User::find($id);
            $h->addPerfil($request->perfil);
            return redirect()->back()->with('msg_sucesso', "Perfil atribuído com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getMessage();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
    
    public function excluirPerfilUsuario(Request $request, $id){
        try{
            $h = User::find($id);
            $h->dropPerfil($request->perfil);
            return redirect()->back()->with('msg_sucesso', "Perfil apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getMessage();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod] f");
        }
    }
    
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        $dados["lista"] = Perfil::all();
        $dados["perfil"] = Perfil::find($id);
        $dados["perfils"] = Perfil::all();
        return view('Admin.Perfil.Index', $dados);
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
        Perfil::where("id", $id)->update($req);
        return redirect()->route("perfil.index");
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
            $h = PerfilUser::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Ítem apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
