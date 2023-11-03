<?php

namespace App\Http\Controllers\Admin\Compra;

use App\Http\Controllers\Controller;
use App\Models\CentroCusto;
use App\Models\Fornecedor;
use App\Models\OrdemCompra;
use App\Models\Produto;
use App\Models\Transportadora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Service\ItemOrdemCompraService;


class OrdemCompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados["lista"] = OrdemCompra::all();
        return view("Admin.Compra.OrdemCompra.Index", $dados);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()    {
        $dados["fornecedores"]      = Fornecedor::where('empresa_id', session('empresa_selecionada_id'))->get();
        $dados["transportadoras"]   = Transportadora::where('empresa_id', session('empresa_selecionada_id'))->get();
        $dados["produtos"]          = Produto::where('empresa_id', session('empresa_selecionada_id'))->get();
        $dados["centro_custos"]     = CentroCusto::where('empresa_id', session('empresa_selecionada_id'))->get();
        $dados["ordemCompraJs"]     = true;
        return view("Admin.Compra.OrdemCompra.Create", $dados);
        
    }

    
    public function store(Request $request)
    {        
        $ordemcompra = $request->venda;
        $result = OrdemCompra::create([
            'empresa_id'        => session('empresa_selecionada_id'),
            'status_id'         => config("constantes.status.ATIVO"),
            'fornecedor_id'    => $ordemcompra["fornecedor_id"],
            'data_emissao'      => $ordemcompra["data_emissao"],
            'usuario_id'        => Auth::user()->id,
            'data_emissao'      => $ordemcompra["data_emissao"],
            'prazo_recebimento' => $ordemcompra["prazo_recebimento"],
            'valor_total'       => $ordemcompra["valor_total"],
            'observacao'        => $ordemcompra["observacao"],
            
        ]);
        
        ItemOrdemCompraService::salvarItens($result->id, $ordemcompra['itens']);  
        echo json_encode($result);
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
        //
    }
}
