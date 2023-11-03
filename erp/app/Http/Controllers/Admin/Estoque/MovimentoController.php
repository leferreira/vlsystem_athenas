<?php

namespace App\Http\Controllers\Admin\Estoque;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Movimento;
use App\Models\Produto;
use App\Service\ConstanteService;
use App\Service\MovimentoService;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;

class MovimentoController extends Controller
{
    
    public function index(){
        $filtro                     = new \stdClass();
        $filtro->data1              = $_GET["data1"] ?? hoje();
        $filtro->data2              = $_GET["data2"] ?? hoje();
        $filtro->produto_id         = $_GET["produto_id"] ?? null ;        
        $filtro->entrada_saida      = $_GET["entrada_saida"] ?? null;
        $filtro->tipo_movimento_id  = $_GET["tipo_movimento_id"] ?? null;
        $filtro->origem_movimento   = $_GET["origem_movimento"] ?? null; 
        
        $dados["filtro"]            = $filtro;      
        $dados["lista"]             = MovimentoService::historico($filtro)->get();     
        $dados["produtos"]          = Produto::get();
        
        $dados["produto"]           = Produto::find($filtro->produto_id);
        
        return view("Admin.Estoque.Movimento.Index", $dados);
    }
    
    public function selecionarProduto(){
        $dados["produtos"]          = Produto::get();
        $dados["categorias"]        = Categoria::get();
        return view("Admin.Estoque.Movimento.SelecionarProduto", $dados);
    }
    
    public function verMovimento($id_produto=null){
        
        $filtro                     = new \stdClass();
        $filtro->data1              = $_GET["data1"] ?? hoje();
        $filtro->data2              = $_GET["data2"] ?? hoje();
        if($id_produto){
            $filtro->produto_id         = $id_produto  ;
        }else{
            $filtro->produto_id         = $_GET["produto_id"] ?? null ;
        }
        
        
        $filtro->entrada_saida      = $_GET["entrada_saida"] ?? null;
        $filtro->tipo_movimento_id  = $_GET["tipo_movimento_id"] ?? null;
        $filtro->origem_movimento   = $_GET["origem_movimento"] ?? null;      
        $dados["lista"]             = MovimentoService::historico($filtro)->get(); 
        
        $dados["soma_entrada"]      = MovimentoService::historico($filtro)->where("ent_sai",'E')->sum("subtotal_movimento");
        $dados["soma_saida"]        = MovimentoService::historico($filtro)->where("ent_sai",'S')->sum("subtotal_movimento");
        $dados["qtde_entrada"]      = MovimentoService::historico($filtro)->where("ent_sai",'E')->sum("qtde_movimento");
        $dados["qtde_saida"]        = MovimentoService::historico($filtro)->where("ent_sai",'S')->sum("qtde_movimento");
        
        $dados["produtos"]          = Produto::get();
        $dados["produto"]           = Produto::find($filtro->produto_id);
        $dados["filtro"]            = $filtro;
        return view("Admin.Estoque.Movimento.HistoricoProduto", $dados);
    }
    
    
    public function filtro() {
        $filtro                     = new \stdClass();
        $filtro->data1              = $_GET["data1"];
        $filtro->data2              = $_GET["data2"];
        $filtro->produto_id         = $_GET["produto_id"];
        $filtro->entrada_saida      = $_GET["entrada_saida"];
        $filtro->origem_movimento   = $_GET["origem_movimento"]; 
        
        $dados["lista"]             = MovimentoService::historico($filtro)->get(); 
        $dados["produtos"]          = Produto::get();     
        $dados["filtro"]            = $filtro;
        if($filtro->produto_id){
            $dados["soma_entrada"]  = MovimentoService::historico($filtro)->where("ent_sai",'E')->sum("subtotal_movimento");
            $dados["soma_saida"]    = MovimentoService::historico($filtro)->where("ent_sai",'S')->sum("subtotal_movimento");
            
            return view("Admin.Estoque.Movimento.HistoricoProduto", $dados);
        }else{
            return view("Admin.Estoque.Movimento.Historico", $dados);
        }
        
        
    }
    
    public function selecionarRelatorio(){
        
        $dados["status_financeiro"]     = ConstanteService::listaStatusFinanceiro();
        $dados["status"]                = ConstanteService::listaStatusVenda();
        $dados["produtos"]              = Produto::get();
        
        return view("Admin.Estoque.Movimento.SelecionarRelatorio", $dados);
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
        
        if($filtro->tipo_relatorio =="entradas"){
            $view ="Admin.Pdf.Lista_Entrada";
        }else if($filtro->tipo_relatorio =="saidas"){
            $view ="Admin.Pdf.Lista_Saida";
        }else if($filtro->tipo_relatorio =="movimento_geral"){
            $view ="Admin.Pdf.Movimento_Geral";
        }else if($filtro->tipo_relatorio =="movimento_produto"){
            $view ="Admin.Pdf.Movimento_Produto";
        }
        
        return view($view, $dados);
    }
    
    public function create()
    {
        //
    }

  
    public function store(Request $request)
    {
        //
    }

   
    
    public function show($id_produto){
        $dados["produto"]       = Produto::find($id_produto);
        $dados["lista"]         = Movimento::where("produto_id", $id_produto)->get();
        $dados["soma_entrada"]  = Movimento::where("ent_sai",'E')->where("produto_id", $id_produto)->sum("subtotal_movimento");
        $dados["soma_saida"]    = Movimento::where("ent_sai",'S')->where("produto_id", $id_produto)->sum("subtotal_movimento");
        $dados["qtde_entrada"]  = Movimento::where("ent_sai",'E')->where("produto_id", $id_produto)->sum("qtde_movimento");
        $dados["qtde_saida"]    = Movimento::where("ent_sai",'S')->where("produto_id", $id_produto)->sum("qtde_movimento");
        $dados["produtos"]      = Produto::get();
        return view("Admin.Estoque.Movimento.Estoque", $dados);
    }

    
    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
}
