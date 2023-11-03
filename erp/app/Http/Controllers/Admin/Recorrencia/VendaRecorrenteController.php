<?php

namespace App\Http\Controllers\Admin\Recorrencia;

use App\Http\Controllers\Controller;
use App\Models\Cobranca;
use App\Models\ModeloContrato;
use App\Models\ProdutoRecorrente;
use App\Models\TipoCobranca;
use App\Models\VendaRecorrente;
use App\Models\Vendedor;
use App\Service\ConstanteService;
use App\Service\ItemVendaRecorrenteService;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;

class VendaRecorrenteController extends Controller{    
    
    public function index(){      
        $filtro = new \stdClass();
        $filtro->data1      = hoje();
        $filtro->data2      = hoje();
        $filtro->status_id  = null;
        $filtro->cliente_id = null;
        
        $dados["lista"]                 = VendaRecorrente::get();
        $dados["status"]                = ConstanteService::listaStatusVenda();
        $dados["status_financeiro"]     = ConstanteService::listaStatusFinanceiro();
        $dados["filtro"]                = $filtro;
        
        return view("Admin.Recorrencia.VendaRecorrente.Index", $dados);   
        
    }
    
    public function create(){      
      
        $dados["vendedores"]        = Vendedor::get();
        $dados["produtos"]          = ProdutoRecorrente::get();
        $dados["tipos"]             = TipoCobranca::get();
        $dados["modelos"]           = ModeloContrato::get();
        
        $dados["clienteJs"]         = true;
        $dados["vendaRecorrenteJs"] = true;        
        return view("Admin.Recorrencia.VendaRecorrente.Create", $dados);
    }    
    
    public function edit($id){
        
        $venda                      = VendaRecorrente::find($id);
        $dados["venda"]             = $venda;
        $dados["cliente"]           = $venda->cliente;
        $dados["vendedor"]          = $venda->vendedor;
        $dados["modelos"]           = ModeloContrato::get();
        $dados["produtos"]          = ProdutoRecorrente::get();
        $dados["tipos"]             = TipoCobranca::get();
        $dados["vendedores"]        = Vendedor::get();
        $dados["cobrancas"]         = Cobranca::where("venda_recorrente_id", $id)->get();
        $dados["clienteJs"]         = true;
        $dados["vendaRecorrenteJs"] = true;  
        return view("Admin.Recorrencia.VendaRecorrente.Edit", $dados);
    }
    
    public function salvar(Request $request){
        
        $retorno  = new \stdClass();        
        try {
            $item                       = (object) $request->itens[0];
            
            $venda = new \stdClass();
            $venda->vendedor_id             = $request->vendedor_id ;
            $venda->modelo_contrato_id      = $request->modelo_contrato_id ;
            $venda->cliente_id              = $request->cliente_id ;
            $venda->tipo_cobranca_id        = $request->tipo_cobranca_id ;
            $venda->data_inicio             = $request->data_inicio ;
            $venda->valor_primeira_parcela  = 0;
            $venda->status_id               = config('constantes.status.DIGITACAO');
            $venda->status_financeiro_id    = config('constantes.status.ABERTO');
            $venda->valor_recorrente        = 0;
            $venda->valor_total             = 0;
            $venda->valor_primeira_parcela  = 0;
            $vendaRecorrente                = VendaRecorrente::Create(objToArray($venda));
            if($vendaRecorrente){
                $item->venda_recorrente_id = $vendaRecorrente->id;
                ItemVendaRecorrenteService::inserirItem($item);
            }
            
            $retorno->tem_erro  = false;
            $retorno->titulo    = "Venda Salva com Sucesso";
            $retorno->erro      = "";
            $retorno->redirect  =  url("admin/vendarecorrente/".$vendaRecorrente->id."/edit") ;
            $retorno->retorno   = $vendaRecorrente->id;
            return response()->json($retorno);
            
        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->titulo    = "Erro ao Salvar Venda";
            $retorno->erro      = $e->getMessage();
            return response()->json($retorno);
        }
        
    }
    
    public function pdf($venda_id){        
        $venda           = VendaRecorrente::find($venda_id);
        $dicionario      = VendaRecorrente::dadosContrato($venda_id);
        $procura         = $dicionario->chaves;
        $troca           = $dicionario->valor;
        
        $textoBase       = $venda->modeloContrato->conteudo;
        $textoBase       = str_replace($procura, $troca, $textoBase);
        $dados["contrato"] = $textoBase;
        $dados["venda"] = $venda;
        
        
        
        $p = view('Admin.Recorrencia.VendaRecorrente.Pdf', $dados);
        
        //return $p;
        $domPdf = new Dompdf(["enable_remote" => true]);
        $domPdf->loadHtml($p);
        
        $pdf = ob_get_clean();
        
        $domPdf->setPaper("A4");
        $domPdf->render();
        $domPdf->stream("arqivo.pdf",["Attachment"=>false]);
        //$domPdf->stream("relatorio de venda $venda->id.pdf");
        
        
        
        
        
       
        return view('Admin.Recorrencia.VendaRecorrente.Pdf', $dados);
    }
    
    public function novaCobranca($id){
        $dados["tipos"]             = TipoCobranca::get();
        $dados["vendarecorrente"]   = VendaRecorrente::find($id);
        return view("Admin.Financeiro.Cobranca.Create", $dados);
    }
    
    public function gerarCobranca(Request $request){
        $req = $request->except(["_token","_method","qtde"]);
        try {
            $req["status_financeiro_id"]    = config('constantes.status.ABERTO');
            $req["valor_recorrente"]        = getFloat($req["valor_recorrente"]);
            $recorrencia                    = VendaRecorrente::find($request->venda_recorrente_id);
            $tipo_cobranca                  = TipoCobranca::find($req["tipo_cobranca_id"]);
            
            $qtde = $request->qtde;
            for($i=0; $i<$qtde; $i++){
                $cobranca = new \stdClass();
                $cobranca->venda_recorrente_id  = $recorrencia->id;
                $cobranca->cliente_id           = $recorrencia->cliente_id;
                $cobranca->descricao            = $req["descricao"] ?? "Cobrança Recorrente "  ;
                $cobranca->status_id            = config('constantes.status.ATIVO');
                $cobranca->status_financeiro_id = config('constantes.status.ABERTO');
                $cobranca->valor                = $recorrencia->valor_recorrente;
                $cobranca->data_cadastro        = hoje();
                $cobranca->num_parcela		    = $i + 1;
                $cobranca->ult_parcela		    = $qtde;
                $cobranca->data_vencimento      = somarData($req["primeiro_vencimento"], $tipo_cobranca->qtde_dias * $i);
                Cobranca::Create(objToArray($cobranca));
            }
            
            $recorrencia->primeiro_vencimento = $request->primeiro_vencimento;
            $recorrencia->qtde_recorrencia = $qtde;
            $recorrencia->valor_recorrente =  getFloat($request->valor_recorrente);            
            $recorrencia->save();
            
            return redirect()->route('admin.vendarecorrente.edit', $recorrencia->id)->with('msg_sucesso', "Inserido com sucesso.");
            
        } catch (\Exception $e) {
            return redirect()->back()->with('msg_erro', $e->getMessage());
        }
    }
    
    public function store(Request $request){
        $req = $request->except(["_token","_method","qtde"]);
        try {          
            $req["status_id"]               = config('constantes.status.DIGITACAO');
            $req["status_financeiro_id"]    = config('constantes.status.ABERTO');
            $req["valor_primeira_parcela"]  = getFloat($req["valor_primeira_parcela"]);
            $req["valor_recorrente"]        = getFloat($req["valor_recorrente"]);
            $recorrencia = VendaRecorrente::Create($req); 
            $tipo_cobranca = TipoCobranca::find($req["tipo_cobranca_id"]);
            $qtde = $request->qtde;
            $j=1;
            for($i=0; $i<$qtde; $i++){
                $valor = $recorrencia->valor_recorrente;
                if($i==0){
                    $valor = $req["valor_primeira_parcela"];
                    
                }
                $cobranca = new \stdClass();
                $cobranca->venda_recorrente_id  = $recorrencia->id;
                $cobranca->cliente_id           = $recorrencia->cliente_id;
                $cobranca->status_id            = config('constantes.status.ATIVO');
                $cobranca->status_financeiro_id = config('constantes.status.ABERTO');
                $cobranca->descricao            = $recorrencia->produto->descricao . "#Cobr:".$j++;
                $cobranca->valor                = $valor;
                $cobranca->data_cadastro        = hoje();
                $cobranca->data_vencimento      = somarData($req["primeiro_vencimento"], $tipo_cobranca->qtde_dias * $i);
                Cobranca::Create(objToArray($cobranca));
            }
            return redirect()->route('admin.vendarecorrente.edit', $recorrencia->id)->with('msg_sucesso', "Inserido com sucesso.");
            
        } catch (\Exception $e) {
            return redirect()->back()->with('msg_erro', $e->getMessage());
        }
     }
    
     public function update(Request $request, $id){
         
         $req                    = $request->except(["_token","_method",  "file"]);
         
         try {
             $req["valor_primeira_parcela"]  = getFloat($req["valor_primeira_parcela"]);
             $req["valor_recorrente"]        = getFloat($req["valor_recorrente"]);             
             
             ProdutoRecorrente::where("id", $id)->update(objToArray($req));
             return redirect()->route('admin.produtorecorrente.index')->with('msg_sucesso', "Produto Inserido com sucesso.");
             
         } catch (\Exception $e) {
             return redirect()->back()->with('msg_erro', $e->getMessage());
         }
     }
     
     

   
    
}
