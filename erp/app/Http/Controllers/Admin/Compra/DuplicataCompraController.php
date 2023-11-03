<?php
namespace App\Http\Controllers\Admin\Compra;

use App\Http\Controllers\Controller;
use App\Models\Compra;
use App\Models\DuplicataCompra;
use App\Service\ConstanteService;
use Illuminate\Http\Request;

class DuplicataCompraController extends Controller{ 
      
    public function inserir(Request $request){
        $req            = $request->except(["_token","_method"]);  
        $compra            = Compra::find($req["compra_id"]);
       
        if($req["forma_de_parcelar"]==2){
            $array_parcela  = explode("-", $req["qtde_parcela"]);          
        }else{
            for($i=1; $i<=$req["qtde_parcela"]; $i++){
                $array_parcela[] = 30 * $i;
            }
        }
        
        
        $valor_total    = $compra->valor_compra;
        $qtde_parcela   = count($array_parcela);
        $parcela        = number_format($valor_total / $qtde_parcela, 2, ".", "");
       
        $soma_parcela          = 0;
        DuplicataCompra::where("compra_id", $req["compra_id"])->delete();
        for($i=0; $i < $qtde_parcela; $i++){
            $duplicata          = new \stdClass();            
            
            $duplicata->compra_id  = $req["compra_id"];
            $duplicata->tPag    = $req["tPag"];
            $duplicata->nDup    = zeroEsquerda($i+1, 3);
            $duplicata->dVenc   = somarData(hoje(), $array_parcela[$i]);
            
            if($i == $qtde_parcela-1){
                $valor_parcela = $valor_total - $soma_parcela;
            }else{
                $valor_parcela = $parcela;
            }
            
            $soma_parcela += $parcela;            
            $duplicata->vDup = $valor_parcela;
             DuplicataCompra::Create(objToArray($duplicata));
            
        }    
        
        $lista = $this->listarDuplicataCompra($req["compra_id"]);
        echo json_encode($lista);
        
      }
      
      public function salvarAlteracao(Request $request){
          $req    = $request->except(["_token","_method"]);
          DuplicataCompra::where("id", $req["id"])->update($req);         
          
          echo json_encode("ok");
          
      }
      
      
      public function alterar(Request $request){
          $req     = $request->except(["_token","_method"]);
          $qtde = DuplicataCompra::where("compra_id", $req["compra_id"])->count("compra_id");
          for($i=0; $i<$req["qtde_parcela"]; $i++){
              $duplicata  = new \stdClass();
              $valor      = getFloat($req["valor_parcela"]);
              $parcela    = $valor / $req["qtde_parcela"];
              
              $duplicata->compra_id  = $req["compra_id"];
              $duplicata->tPag    = $req["tPag"];
              $duplicata->nDup    = zeroEsquerda($i + $qtde+1, 3);
              $duplicata->dVenc   = somarData($req["vencimento"],$i*30);
              $duplicata->vDup    = $parcela;
              DuplicataCompra::Create(objToArray($duplicata));
          }
                    
         // $lista = $this->listarDuplicataCompra($req["compra_id"]);
          echo json_encode($lista);
          
      }
      
      public function listarDuplicataCompra($compra_id){
          $lista = DuplicataCompra::where("compra_id", $compra_id)->get();
          $resultado = array();
          foreach($lista as $l){
              $duplicata          = new \stdClass();
              $duplicata->id      = $l->id;
              $duplicata->compra_id  = $l->compra_id;
              $duplicata->tPag    = $l->tPag;
              $duplicata->pagamento = ConstanteService::getTipoPagamento($l->tPag);
              $duplicata->nDup    = $l->nDup;
              $duplicata->dVenc   = databr($l->dVenc);
              $duplicata->vDup    = $l->vDup;
              $resultado[]        = $duplicata;
          }          
          return (object) $resultado;
      }
      public function excluir($id){ 
          try {
              $duplicata    = DuplicataCompra::where("id", $id)->first();
              $valor_total  = Compra::find($duplicata->compra_id)->valor_compra;
             // $valor_total  = DuplicataCompra::where("compra_id", $duplicata->compra_id)->sum("vDup");
              //exclui o item
              $duplicata->delete();
              $lista      = DuplicataCompra::where("compra_id", $duplicata->compra_id)->get();
              
              if(count($lista)>0){
                  $parcela      = number_format($valor_total / count($lista), 2, ".", "");

                  $i            = 0;
                  $qtde_parcela = count($lista);
                  $soma_parcela = 0;
                  
                  foreach($lista as $d){
                      $d->nDup    = zeroEsquerda($i+1, 3);
                      
                      if($i == $qtde_parcela-1){
                          $valor_parcela = $valor_total - $soma_parcela;
                      }else{
                          $valor_parcela = $parcela;
                      }
                      
                      $soma_parcela += $parcela;
                      $d->vDup = $valor_parcela;
                      $d->save();
                      $i++;
                  }
              }
              echo json_encode("ok");
          } catch (\Exception $e) {
              echo json_encode($e->getMessage());
          }
          
          
          
      }
   
      public function salvar(Request $request){
          $req     = $request->except(["_token","_method"]);
          $req["nDup"] = 1;
          DuplicataCompra::Create($req);
          $lista = DuplicataCompra::where("compra_id", $req["compra_id"])->get();
          echo json_encode($lista);
          
      }
}
