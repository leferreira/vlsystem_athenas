<?php

namespace App\Http\Controllers\Admin\Cadastro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EnderecoCliente;

class EnderecoClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $retorno = new \stdClass();
        try {
            $req        = $request->except(["_token","_method","endereco_id"]);          
            $id         = $request->endereco_id ?? null;
            if($id){
                $req["id"] = $id;
                EnderecoCliente::where("id", $id)->update($req);
            }else{
                EnderecoCliente::Create($req);
            }
            
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            return response()->json($retorno);
            
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
           return response()->json($retorno);
           
        }
        
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

    public function buscar($id)
    {
        $endereco = EnderecoCliente::find($id);
        return response()->json($endereco);
    }
    
    public function listaPorCliente($id)
    {
        $lista = EnderecoCliente::where("cliente_id", $id)->get();
        return response()->json($lista);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
            $h = EnderecoCliente::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
