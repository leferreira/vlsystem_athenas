<?php

namespace App\Http\Controllers\Admin\LojaVirtual;

use App\Http\Controllers\Controller;
use App\Http\Requests\LojaConfiguracaoRequest;
use App\Models\LojaConfiguracao;
use Illuminate\Support\Str;

class LojaConfiguracaoController extends Controller
{
    
    public function index(){
        $empresa = auth()->user()->empresa;
        $dados["configuracao"] = LojaConfiguracao::where("empresa_id", $empresa->id)->first();
        return view("Admin.Loja.LojaConfiguracao.Create", $dados);
    }

    public function store(LojaConfiguracaoRequest $request){    
        $req = $request->except(["_token","_method", "file"]);        
        $req['frete_gratis_valor'] =  ($req['frete_gratis_valor']) ? moedaEn($req['frete_gratis_valor']) : null;
        $file               = $request->file('file');
        $empresa = auth()->user()->empresa;
        if($file){
            $extensao           = $file->getClientOriginalExtension();
            $nomeImagem         = Str::random(25) . ".".$extensao;
            $request->merge([ 'path' => $nomeImagem ]);
            $pasta              = "storage/".$empresa->pasta ."/imagens/";
            $upload             = $file->move(public_path($pasta), $nomeImagem); 
            $req["logo"]        = $pasta . $nomeImagem; 
        }  
        
        LojaConfiguracao::Create($req);
       
        return redirect()->route('admin.lojaconfiguracao.index');
    }

    public function update(LojaConfiguracaoRequest $request, $id){
        $req                =   $request->except(["_token","_method", "file"]);  
        $req['frete_gratis_valor'] =  ($req['frete_gratis_valor']) ? moedaEn($req['frete_gratis_valor']) : null;
        $file               = $request->file('file');
        $empresa = auth()->user()->empresa;
        if($file){
            $extensao           = $file->getClientOriginalExtension();
            $nomeImagem         = Str::random(25) . ".".$extensao;
            $request->merge([ 'path' => $nomeImagem ]);
            $pasta              = "storage/".$empresa->pasta ."/imagens/";
            $upload             = $file->move(public_path($pasta), $nomeImagem);
            $req["logo"]        = $pasta . $nomeImagem; 
        }
        
        LojaConfiguracao::where("id", $id)->update($req);
        return redirect()->route("admin.lojaconfiguracao.index");
    }

    public function destroy($id){
        try{
            $h = LojaConfiguracao::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "Ítem apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
