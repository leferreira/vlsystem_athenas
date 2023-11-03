<?php
namespace App\Http\Controllers\Admin\Nfe;
use App\Http\Controllers\Controller;
use App\Http\Requests\ItemNotaRequest;
use App\Models\Nfe;
use App\Models\NfeItem;
use App\Service\CofinsService;
use App\Service\IcmsService;
use App\Service\IpiService;
use App\Service\ItemNotafiscalOperacaoService;
use App\Service\ItemNotafiscalService;
use App\Service\NotaFiscalOperacaoService;
use App\Service\PisService;
use Illuminate\Http\Request;


class ItemNotaFiscalController extends Controller{ 
    
    public function inserir(ItemNotaRequest $request){
        $req                = $request->except(["_token","_method"]);
        
        $retorno = new \stdClass();
        try {
            $dados                  = new \stdClass();
            $preco                  = $req["preco"] ? getFloat($req["preco"]) : 0;
            $dados->nfe_id          = $req["nfe_id"];
            $dados->cProd           = $req["produto_id"];
            $dados->produto_id      = $req["produto_id"];            
            $dados->qCom            = $req["qtde"] ? getFloat($req["qtde"]) :  0;    
            $dados->vProd           = $dados->qCom * $preco;
            $dados->preco_original  = $preco;
            $dados->desconto_por_valor        = $req["desconto_por_valor"] ? getFloat($req["desconto_por_valor"]) :  0;
            $dados->desconto_percentual        = $req["desconto_percentual"] ? getFloat($req["desconto_percentual"]) :  0;
      
            
            $dados->desconto_por_unidade = 0;            
            
            if($dados->desconto_por_valor > 0){
                $dados->desconto_por_unidade = $dados->desconto_por_valor;
            }
            
            if($dados->desconto_percentual > 0){
                $dados->desconto_por_unidade = $dados->desconto_percentual * $preco * 0.01;
            }
            $dados->total_desconto_item = $dados->desconto_por_unidade * $dados->qCom;
            $dados->subtotal_liquido    = ($preco - $dados->desconto_por_unidade )  * $dados->qCom;
            $dados->vProd               = $dados->qCom * $preco - ($dados->desconto_por_unidade * $dados->qCom) ;
            $dados->vUnCom              = $preco - $dados->desconto_por_unidade;
            
          
            NfeItem::Create(objToArray($dados));
            $lista              = NfeItem::where("nfe_id",$dados->nfe_id)->get();
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            $retorno->nfe       = Nfe::find($dados->nfe_id);
            $retorno->itens     = $lista;
            
            return response()->json($retorno);
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            $retorno->retorno = "";
            return response()->json($retorno);
        }
    }
    
    
    
    public function inserirSemCalculo(ItemNotaRequest $request){
        $req                = $request->except(["_token","_method"]);
        
        $retorno = new \stdClass();
        try {
            $dados              = new \stdClass();
            
            $dados->produto_id  = $req["produto_id"];
            $dados->quantidade  = $req["qtde"] ? getFloat($req["qtde"]) :  null;
            $preco              = $req["preco"] ? getFloat($req["preco"]) : null;
            $dados->nfe_id      = $req["nfe_id"];
            $dados->subtotal    = $dados->quantidade * $preco;
            
            $tipo_desc          = $req["tipo_desc"];
            $desconto           = $req["val_desconto"] ? getFloat($req["val_desconto"]) : null;
            
            $dados->desconto_item = 0;
            if($desconto){
                if($tipo_desc=="desc_perc"){
                    $dados->desconto_item   =  $preco * $desconto  * 0.01;
                }elseif($tipo_desc=="desc_valor"){
                    $dados->desconto_item   =  $desconto;
                }
                
                $dados->subtotal    = $dados->quantidade * $preco - ($dados->desconto_item * $dados->quantidade) ;
            }
            
            $dados->valor   = $preco - $dados->desconto_item;
            ItemNotafiscalService::inserir($dados);            
            $lista              = NfeItem::where("nfe_id",$dados->nfe_id)->get();
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            $retorno->nfe       = Nfe::find($dados->nfe_id);
            $retorno->itens     = $lista;
            
            return response()->json($retorno);
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            $retorno->retorno = "";
            return response()->json($retorno);
        }
    }
    
   
    
    public function atualizar(Request $request){
        $retorno = new \stdClass();
        $req     = $request->except(["_token","_method"]);
        $id      = $request->id;
        try {
            $item    = (object) $req ;            
            $id_nfe  = $item->nfe_id;
            //Dados da Nota            
            ItemNotafiscalOperacaoService::salvarItemDaNota($item, $id) ;
            ItemNotafiscalService::atualizarTodosCalculos($id_nfe);             
            
            //Totalização da nota
            $lista = NfeItem::where("nfe_id",$id_nfe)->get();
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            $retorno->nfe       = Nfe::find($id_nfe);
            $retorno->itens     = $lista;
            return response()->json($retorno); 
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return response()->json($retorno); 
        }
    }
    
    public function atualizarSemCalculo(Request $request){
        $retorno = new \stdClass();
        $req     = $request->except(["_token","_method"]);
        $id      = $request->id;
        try {
            $item    = (object) $req ;
            $id_nfe  = $item->nfe_id;
            //Dados da Nota            
            ItemNotafiscalOperacaoService::salvarItemDaNota($item, $id) ;
            //Totalização da nota
            $lista = NfeItem::where("nfe_id",$id_nfe)->get();
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            $retorno->nfe       = Nfe::find($id_nfe);
            $retorno->itens     = $lista;
            return response()->json($retorno);
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return response()->json($retorno);
        }
    }
    
    public function excluir($id){
        $retorno = new \stdClass();
        try {
            $item   = NfeItem::find($id);
            
            $id_nfe = $item->nfe_id;
   
            NfeItem::find($id)->delete();                    
            $lista = NfeItem::where("nfe_id",$id_nfe)->get();
            $id_nfe = $item->nfe_id;
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            $retorno->nfe       = Nfe::find($id_nfe);
            $retorno->itens     = $lista; 
            return response()->json($retorno); 
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            $retorno->retorno = "";
            return response()->json($retorno); 
        }
        
   }
   
   public function excluirSemCalculo($id){
       $retorno = new \stdClass();
       try {
           $item   = NfeItem::find($id);
           $id_nfe = $item->nfe_id;
           NfeItem::where("id",$id)->delete();
           
           $lista = NfeItem::where("nfe_id",$id_nfe)->get();
           $id_nfe = $item->nfe_id;
           $retorno->tem_erro  = false;
           $retorno->erro      = "";
           $retorno->nfe       = Nfe::find($id_nfe);
           $retorno->itens     = $lista;
           return response()->json($retorno);
       } catch (\Exception $e) {
           $retorno->tem_erro = true;
           $retorno->erro = $e->getMessage();
           $retorno->retorno = "";
           return response()->json($retorno);
       }
       
   }
   
   public function detalhe($id){
       $retorno = new \stdClass();
       try {
           $item              = NfeItem::where([ "id" => $id])->first();              
           $retorno->tem_erro = false;
           $retorno->retorno  = $item;
           return response()->json($retorno);
       } catch (\Exception $e) {
           $retorno->tem_erro = true;
           $retorno->erro     = "Erro";
           $retorno->retorno  = $e->getMessage();
           return response()->json($retorno);
       }
     
   }
   
   
   
   
   public function recalcular(Request $request){ 
       $req  = $request->except(["_token","_method"]);
       $valores = (object) $req;      
       $retorno = new \stdClass();
       try { 
           $nfeItem = NfeItem::find($valores->id);         
           //IPI
           IpiService::calculo($nfeItem, $valores, true)  ;
           //PIS
           PisService::calculo($nfeItem, $valores, true);
           // Confins
           CofinsService::calculo($nfeItem, $valores, true);
           //ICMS
           IcmsService::calculoICMS($nfeItem, $valores, true);
           
           NotaFiscalOperacaoService::atualizarTotaisDaNota($nfeItem->nfe_id);
           
           NfeItem::where("id", $req["id"] )->update($req);
           $lista = NfeItem::where("nfe_id",$nfeItem->nfe_id)->get();
           $retorno->tem_erro  = false;
           $retorno->erro      = "";
           $retorno->nfe       = Nfe::find($nfeItem->nfe_id);
           $retorno->itens     = $lista;
       return response()->json($retorno);
       } catch (\Exception $e) {
           $retorno->tem_erro = true;
           $retorno->erro = $e->getMessage();
           return response()->json($retorno);
       }      

   }
           
   
 
   
  
}
