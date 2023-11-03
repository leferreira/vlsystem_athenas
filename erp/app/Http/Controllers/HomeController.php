<?php

namespace App\Http\Controllers;

use App\Models\FinFatura;
use App\Models\LojaPedido;
use App\Models\NaturezaOperacao;
use App\Models\PedidoCliente;
use App\Models\Produto;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        //  i(auth()->user()->permissoesFuncao());
        $empresa            = auth()->user()->empresa;
        
        $dados["empresa"]           = $empresa;
        $dados["naturezaoperacao"]  = NaturezaOperacao::first();
        $dados["certificado_arquivo_binario"] = $empresa->certificado_digital->certificado_arquivo_binario ?? null;
        $dados["certificado_senha"] = $empresa->certificado_digital->certificado_senha ?? null;
        $dados["produto"]           = Produto::first();
        $dados["pedidos_loja"]      = LojaPedido::get();
        
        $dados["pedidos_pendentes"] = PedidoCliente::where('status_id', config("constantes.status.ABERTO"))->get();
        // $dados["config_loja"]       = LojaConfiguracao::first();
        $dados["fatura_aberta"]     = FinFatura::where("status_id", config("constantes.status.ABERTO"))->first();
        $dados["graficoJs"]         = true;
        return view("Admin.home", $dados);
    }
}
