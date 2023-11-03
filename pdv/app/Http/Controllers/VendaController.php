<?php

namespace App\Http\Controllers;
use App\Service\CaixaService;
use App\Service\NotaFiscalService;
use App\Service\VendaService;
use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use NFePHP\POS\DanfcePos;
use App\Service\PdvService;

class VendaController extends Controller{
    
    public function inserirItem(Request $request){
        $req     =   $request->except(["_token","_method"]);
        $retorno = new \stdClass();
        try {            
            $resultado            = PdvService::inserirItem($req);
            $retorno->tem_erro    = false;
            $retorno->erro        = "";
            $retorno->retorno     = $resultado;
            return response()->json($retorno);
            
        } catch (\Exception $e) {
            $retorno->tem_erro    = true;
            $retorno->erro        = $e->getMessage();
            $retorno->retorno     = "";
            return response()->json($retorno);
        }
    }
    
    public function aplicarCupom(Request $request){
        $req     =   $request->except(["_token","_method"]);
        $retorno = new \stdClass();
        try {
            $resultado            = PdvService::aplicarCupom($req);
            $retorno->tem_erro    = false;
            $retorno->erro        = "";
            $retorno->retorno     = $resultado;
            return response()->json($retorno);
            
        } catch (\Exception $e) {
            $retorno->tem_erro    = true;
            $retorno->erro        = $e->getMessage();
            $retorno->retorno     = "";
            return response()->json($retorno);
        }
    }
    
    public function excluirCupom($venda_id){
        $retorno = new \stdClass();
        try {
            $resultado            = PdvService::excluirCupom($venda_id);
            $retorno->tem_erro    = false;
            $retorno->erro        = "";
            $retorno->retorno     = $resultado;
            return redirect()->route("pdv.index");
            
        } catch (\Exception $e) {
            $retorno->tem_erro    = true;
            $retorno->erro        = $e->getMessage();
            $retorno->retorno     = "";
            return redirect()->route("pdv.index")->with("msg_erro", $e->getMessage());
        }
    }
    
    public function salvarPagamento(Request $request){
        $req            = $request->except(["_token","_method"]);
        $retorno = new \stdClass();
        try {
            $resultado            = VendaService::salvarPagamento($req);
            $retorno->tem_erro    = false;
            $retorno->erro        = "";
            $retorno->retorno     = $resultado;
            return response()->json($retorno);
            
        } catch (\Exception $e) {
            $retorno->tem_erro    = true;
            $retorno->erro        = $e->getMessage();
            $retorno->retorno     = "";
            return response()->json($retorno);
        }
    }
    
    public function excluirDuplicata($id, $id_venda){
        $retorno = new \stdClass();
        try {
            $resultado            = VendaService::excluirDuplicata($id, $id_venda);
            $retorno->tem_erro    = false;
            $retorno->erro        = "";
            $retorno->retorno     = $resultado;
            return response()->json($retorno);
            
        } catch (\Exception $e) {
            $retorno->tem_erro    = true;
            $retorno->erro        = $e->getMessage();
            $retorno->retorno     = "";
            return response()->json($retorno);
        }
    }
    
    public function finalizarVenda(Request $request){
        
        $retorno = new \stdClass();
        try {
            $venda                = new \stdClass();
            $venda->caixa_id      = $request->venda["caixa_id"];
            $venda->venda_id      = $request->venda["venda_id"];
            $venda->cliente_cnpj  = ($request->venda["cliente_cnpj"]) ? tira_mascara($request->venda["cliente_cnpj"]) : null;
            $venda->cliente_cpf   = ($request->venda["cliente_cpf"]) ? tira_mascara($request->venda["cliente_cpf"]) : null;
            $venda->tem_pendencia = ($request->venda["tem_pendencia"]) ? "S" : "N";
            $resultado            = VendaService::finalizarVenda($venda);                      
            return response()->json($resultado);
            
        } catch (\Exception $e) {
            $retorno->tem_erro    = true;
            $retorno->erro        = $e->getMessage();
            $retorno->retorno     = "";
            return response()->json($retorno);
        }
    }
    
    public function cancelarVenda(Request $request){
        
        $retorno = new \stdClass();
        try {
            $venda                = new \stdClass();
            $venda->venda_id      = $request->venda_id;
            $resultado            = VendaService::cancelarVenda($venda);
            return response()->json($resultado);
            
        } catch (\Exception $e) {
            $retorno->tem_erro    = true;
            $retorno->erro        = $e->getMessage();
            $retorno->retorno     = "";
            return response()->json($retorno);
        }
    }
    
    public function armazenarVenda(Request $request){
        VendaService::armazenarVenda($request->all());
        return redirect()->route('pdv.index');
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public function detalhes($id_venda){
        $dados["venda"]       = VendaService::getVenda($id_venda);
        return view('Venda.Detalhe', $dados);
    }
   
    
    
    
    
    
    
    public function ver(){
        $caixas = CaixaService::listaCaixaAbertoPorUsuario(session("usuario_pdv_logado")->uuid);
        if($caixas){
            if(count($caixas) ==1){
                return redirect()->route('caixa.venda', $caixas[0]->id);
            }else{
                return redirect()->route('caixa.caixasAberto');
            }
        }else{
            return redirect()->back()->with("msg_erro", "Para visualizar as vendas é necessário que tenha pelo menos um caixa aberto");
        }
        
    }    
        
    public function danfce($chave){
        $retorno = new \stdClass();
        try {      
                
            $url         = getenv("APP_URL_API"). "nfce/danfce/" . $chave;                
            $resultado   = enviarGetCurlSDecode($url);          
            header("Content-type: application/pdf");
            i($resultado);           
            
        } catch (\Exception $e) {
            $retorno->tem_erro    = true;
            $retorno->erro        = $e->getMessage();
            $retorno->retorno     = "";
            return response()->json($retorno);
        }
         
    }
    
    
    
    public function imprimir($chave){
        $retorno        = new \stdClass();
        $printer_ip     = '127.0.0.1'; // IP da impressora
        $printer_porta  = 80; // Porta de conexão
        
        try {
            $connector = new NetworkPrintConnector($printer_ip, $printer_porta);           
        } catch (\Exception $ex) {
            die('Não foi possível conectar com a impressora.');
        }        
        
        try {
            $usuario        = session('usuario_pdv_logado');
            $pastaAmbiente = ($usuario->ambiente == "1") ? "producao" : "homologacao";
            $path           = getenv("APP_XML")."storage/". $usuario->empresa_pasta."/xml/nfce/".$pastaAmbiente."/autorizadas/" .$chave."-nfce.xml" ;
            $xml = file_get_contents($path);            
            $danfcepos = new DanfcePos($connector);
            
            /* $logopath = 'logo.png';
             $danfcepos->logo($logopath);*/
            
            $danfcepos->loadNFCe($xml);
          
            $danfcepos->imprimir();
            echo "veio";
            
        } catch (\Exception $e) {
            $retorno->tem_erro    = true;
            $retorno->erro        = $e->getMessage();
            $retorno->retorno     = "";
            return response()->json($retorno);
        }
        
        
        
        
        
        
        
    }
    public function imprimirNfcePelaVenda($id_venda){
        $url         = getenv("APP_URL_API"). "nfce/imprimirDanfcePelaVenda/" . $id_venda;
        
        $resultado   = enviarGetCurlSDecode($url);
        header("Content-type: application/pdf");
        echo $resultado;
    }
    
    public function salvarItensDaVendaNoBanco(Request $request){
        
        $retorno = new \stdClass();
        try {          
           
            $dados = new \stdClass();
            $dados->itens         = $request->itens;
            $dados->venda_id      = $request->venda_id;  
            $dados->cliente_cnpj  = ($request->cliente_cnpj) ? tira_mascara($request->cliente_cnpj) : null;
            $dados->cliente_cpf   = ($request->cliente_cpf) ? tira_mascara($request->cliente_cpf) : null;  
         
            $resultado            = VendaService::salvarItens($dados);
            $retorno->tem_erro    = false;
            $retorno->erro        = "";
            $retorno->retorno     = $resultado;            
            return response()->json($retorno);
            
        } catch (\Exception $e) {
            $retorno->tem_erro    = true;
            $retorno->erro        = $e->getMessage();
            $retorno->retorno     = "";
            return response()->json($retorno);
        }
    }
    
    public function salvar(Request $request){  
        $retorno = new \stdClass();
       try {         
           $venda                = new \stdClass();
           $venda->empresa_id    = session("usuario_pdv_logado")->empresa_uuid;
           $venda->caixa_id      = $request->venda["caixa_id"]; 
           $venda->venda_id      = $request->venda["venda_id"];
           $venda->data_venda    = hoje();
           $venda->hora_venda    = agora();
           $venda->usuario_id    = session("usuario_pdv_logado")->uuid;
           $venda->valor_total   = $request->venda["total"];
           $venda->cliente_cnpj  = $request->venda["cliente_cnpj"];
           $venda->cliente_cpf   = $request->venda["cliente_cpf"];
           $venda->total_receber = $request->venda["total"] - $request->venda["desconto"];
           $venda->valor_desconto= $request->venda["desconto"] ;
           
           $v                    = new \stdClass();
           $v->venda             = $venda;
           $v->itens             = $request->venda["itens"];
           $v->pagamentos        = $request->venda["pagamentos"];               
           $resultado            = VendaService::salvar($v); 
           $retorno->tem_erro    = false;
           $retorno->erro        = "";
           $retorno->retorno     = $resultado;
           
           return response()->json($retorno);
          
       } catch (\Exception $e) {
           $retorno->tem_erro    = true;
           $retorno->erro        = $e->getMessage();
           $retorno->retorno     = "";
           return response()->json($retorno);
       }
    }
   
   
    public function excluirItem($id, $id_venda){
        $retorno = new \stdClass();
        try {
            $resultado            = VendaService::excluirItem($id, $id_venda);
            $retorno->tem_erro    = false;
            $retorno->erro        = "";
            $retorno->retorno     = $resultado;
            return response()->json($retorno);
            
        } catch (\Exception $e) {
            $retorno->tem_erro    = true;
            $retorno->erro        = $e->getMessage();
            $retorno->retorno     = "";
            return response()->json($retorno);
        }
    }
    
    
    
    
    public function enviarDescontoAcrescimento(Request $request){
        $req                                = $request->except(["_token","_method"]);
        $req["acrescimo_percentual_total"]	= $req["acrescimo_percentual_total"] ? getFloat($req["acrescimo_percentual_total"]) : 0 ;
        $req["acrescimo_por_valor_total"]	= $req["acrescimo_por_valor_total"] ? getFloat($req["acrescimo_por_valor_total"]) : 0 ;
        $req["desconto_percentual_total"]	= $req["desconto_percentual_total"] ? getFloat($req["desconto_percentual_total"]) : 0 ;
        $req["desconto_por_valor_total"]    = $req["desconto_por_valor_total"] ? getFloat($req["desconto_por_valor_total"]) : 0 ;        
        
        $retorno        = new \stdClass();
        try {
            $resultado            = VendaService::enviarDescontoAcrescimento($req);
            $retorno->tem_erro    = false;
            $retorno->erro        = "";
            $retorno->retorno     = $resultado;
            return response()->json($retorno);
            
        } catch (\Exception $e) {
            $retorno->tem_erro    = true;
            $retorno->erro        = $e->getMessage();
            $retorno->retorno     = "";
            return response()->json($retorno);
        }
    }
    
    public function transmitirPelaVenda($id_venda){
        $retorno = NotaFiscalService::transmitirPelaVenda($id_venda);
        echo json_encode($retorno);
    }
    
    
    public function salvar_e_transmitir($id_venda){
        $nota = VendaService::getDadosParaGerarNfcePelaVenda($id_venda);
        if($nota){
            $nfce = VendaService::inserirNfcePelaVenda($nota);
            $retorno = NotaFiscalService::transmitirNfce($nfce->id_nfce);
            echo json_encode($retorno);
        }
        
        
    }
    public function inserirNfcePelaVenda($id_venda){
        $nota = VendaService::getDadosParaGerarNfcePelaVenda($id_venda);
        echo json_encode($nota);
        exit;
        if($nota){
            $nota = VendaService::inserirNfcePelaVenda($nota);
            echo json_encode($nota);
        }
    }
   
   /* public function cupom($id){
        $venda = PdvVenda::find($id);
        $p     = view('Pdv.Venda.Cupom')->with('venda', $venda);
        
        //return $p;
        $domPdf = new Dompdf(["enable_remote" => true]);
        $domPdf->loadHtml($p);
        
        $pdf = ob_get_clean();
        
        $domPdf->setPaper("A4");
        $domPdf->render();
        $domPdf->stream("arqivo.pdf",["Attachment"=>false]);
    }
    */
    
    
   
}
