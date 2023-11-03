<?php

namespace App\Http\Controllers\Admin\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Movimento;
use App\Models\Produto;
use App\Models\Venda;
use App\Service\ConstanteService;
use App\Service\MovimentoService;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;

class FinanceiroController extends Controller
{
    
  
    
    public function selecionarRelatorio(){
        
        $dados["status_financeiro"]     = ConstanteService::listaStatusFinanceiro();
        $dados["status"]                = ConstanteService::listaStatusVenda();
        $dados["produtos"]              = Produto::get();
        
        return view("Admin.Financeiro.SelecionarRelatorio", $dados);
    }
    
    public function imprimir(Request $request){
        $filtro = new \stdClass();
        $filtro->data1                  = $_GET["data1"] ?? null;
        $filtro->data2                  = $_GET["data2"] ?? null;
        $filtro->status_id              = $_GET["status_id"] ?? null;
        $filtro->status_financeiro_id   = $_GET["status_financeiro_id"] ?? null;
        $filtro->produto_id             = $_GET["produto_id"] ?? null;
        $filtro->tipo_relatorio         = $_GET["tipo_relatorio"] ?? null;
        
        
        $options = new Options();
        $options->setIsRemoteEnabled(true);
        $dompdf = new Dompdf($options);
        $dados["dompdf"]     = $dompdf;
        
        $dados["lista"]      = Cliente::get();
        
        $view = '';
        
        if($filtro->tipo_relatorio =="conta_pagar"){
            $view ="Admin.Pdf.Conta_Pagar";
        }else if($filtro->tipo_relatorio =="conta_receber"){
            $view ="Admin.Pdf.Conta_Receber";
        }else if($filtro->tipo_relatorio =="movimento_geral"){
            $view ="Admin.Pdf.Movimento_Geral";
        }else if($filtro->tipo_relatorio =="movimento_produto"){
            $view ="Admin.Pdf.Movimento_Produto";
        }
        
        return view($view, $dados);
    }
    
  
}
