<?php

namespace App\Http\Controllers\Admin\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\CentroCusto;
use App\Models\FinComprovanteFatura;
use App\Models\FinPagamento;
use App\Models\FormaPagto;
use App\Models\Fornecedor;
use Illuminate\Http\Request;
use Str;

class ComprovanteController extends Controller
{
    
    public function index()
    {
        $dados["lista"]         = FinComprovanteFatura::get();
        return view("Admin.Financeiro.Comprovante.Index", $dados);
    }
    
   
    public function create()
    {
        $dados["formaPagto"]    = FormaPagto::all();
        $dados["fornecedores"]  = Fornecedor::get();
        $dados["centro_custos"] = CentroCusto::get();
        $dados["pagamentos"] = array();
        return view("Admin.Financeiro.Pagamento.Create", $dados);
    }

    
    public function store(Request $request)
    {
        $req = $request->except(["_token","_method"]);
        $empresa            = auth()->user()->empresa;
        $req["data_emissao"]    = hoje();
        $req["confirmado"]      = "N";
        $req["valor_pago"]      = getFloat($req["valor_pago"] ?? 0);
        if ($request->hasFile('file') && $request->file->isValid()) {
            $file               = $request->file('file');
            $extensao           = $file->getClientOriginalExtension();
            $nomeImagem         = Str::random(25) . ".".$extensao;
            $pasta              = "upload/".$empresa->pasta ."/comprovantes/";
            //$pasta              = "storage/".$empresa->pasta ."/produtos/";
            $file->move(public_path($pasta), $nomeImagem);
            $req['nome_arquivo']= $pasta . $nomeImagem;
        }
        FinComprovanteFatura::Create(objToArray($req));
   
        return redirect()->route('comprovante.index')->with('msg_sucesso', "Inserido com sucesso.");
    }

  
    
    
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
            $h = FinPagamento::find($id);
            $h->delete();
            return redirect()->back()->with('msg_sucesso', "item apagado com sucesso.");
        }catch (\Exception $e){
            $cod = $e->getCode();
            return redirect()->back()->with('msg_erro', "Houve um problema ao apagar [$cod]");
        }
    }
}
