<?php

namespace App\Http\Controllers\Admin\LojaVirtual;

use App\Http\Controllers\Controller;
use App\Models\LojaPacote;
use App\Models\Produto;
use Illuminate\Http\Request;
use App\Models\LojaItemPacote;
use App\Http\Requests\LojaProdutoRequest;
use App\Http\Requests\LojaPacoteRequest;

class LojaPacoteController extends Controller
{
    
    public function index()
    {
        $dados["lista"] = LojaPacote::get();
        return view("Admin.Loja.LojaPacote.Index", $dados);
    }

    
    public function create()
    {
        $dados["lojaPacoteJs"] = true;
        return view("Admin.Loja.LojaPacote.Novo", $dados);
    }

    public function store(LojaPacoteRequest $request){
        $retorno = new \stdClass();
        try{
            $result = LojaPacote::create([
                "nome"          => $request->nome,
                "descricao"     => $request->descricao,
                "status_id"    => $request->status_id ,
                "valor"         => $request->valor
                ]);
            if($result){
                foreach($request->itens as $item){
                    LojaItemPacote::create([
                        "loja_produto_id" => $item["codigo"],
                        "loja_pacote_id"  => $result->id,
                        "quantidade"      => $item["quantidade"]
                    ]);
                }            
                $retorno->tem_erro  = false;
                $retorno->titulo    = "Operqção Realizada com sucesso";
                $retorno->erro      = "";
            }else{
                $retorno->tem_erro  = true;
                $retorno->titulo    = "Não foi possível inserir os dados";
                $retorno->erro      = $errors->all();
            }
        }catch (\Exception $e){
            $retorno->tem_erro  = true;
            $retorno->titulo    = "Erro ao tentar inserir";
            $retorno->erro      = $e->getMessage();
         }
        echo json_encode($retorno);
        
        
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $dados["pacote"]       = LojaPacote::find($id);
        $dados["lojaPacoteJs"] = true;
        $dados["lista"]        = LojaItemPacote::where("loja_pacote_id", $id)->get();
        return view("Admin.Loja.LojaPacote.Edit", $dados);
    }

    public function update(Request $request, $id){
        $req     =   $request->except(["_token","_method"]);
        LojaPacote::where("id", $id)->update($req);
        return redirect()->route("admin.loja.lojapacote.index");
    }

    public function destroy($id){
        try{
            $h = LojaPacote::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Ítem apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
