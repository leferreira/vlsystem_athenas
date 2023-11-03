<?php
namespace App\Http\Controllers\Admin\Pdv;

use App\Http\Controllers\Controller;
use App\Models\PdvDuplicata;
use App\Models\PdvVenda;
use App\Models\Venda;
use App\Service\ConstanteService;
use Illuminate\Http\Request;

class PdvDuplicataController extends Controller{ 
      
    public function inserir(Request $request){
        $req            = $request->except(["_token","_method"]);  
        $venda            = PdvVenda::find($req["venda_id"]);
      
        if($req["forma_de_parcelar"]==2){
            $array_parcela  = explode("-", $req["qtde_parcela"]);          
        }else{
            for($i=1; $i<=$req["qtde_parcela"]; $i++){
                $array_parcela[] = 30 * $i;
            }
        }
        
        
        $valor_total    = $venda->valor_liquido;
        $qtde_parcela   = count($array_parcela);
        $parcela        = number_format($valor_total / $qtde_parcela, 2, ".", "");
        $soma_parcela          = 0;
        PdvDuplicata::where("venda_id", $req["venda_id"])->delete();
        for($i=0; $i < $qtde_parcela; $i++){
            $duplicata          = new \stdClass();            
            
            $duplicata->venda_id  = $req["venda_id"];
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
            PdvDuplicata::Create(objToArray($duplicata));
            
        }    
        
        $lista = $this->listarDuplicata($req["venda_id"]);
        echo json_encode($lista);
        
      }
      
      public function salvarAlteracao(Request $request){
          $req    = $request->except(["_token","_method"]);
          PdvDuplicata::where("id", $req["id"])->update($req);         
          
          echo json_encode("ok");
          
      }
      
      
      public function alterar(Request $request){
          $req     = $request->except(["_token","_method"]);
          $qtde = PdvDuplicata::where("venda_id", $req["venda_id"])->count("venda_id");
          for($i=0; $i<$req["qtde_parcela"]; $i++){
              $duplicata  = new \stdClass();
              $valor      = getFloat($req["valor_parcela"]);
              $parcela    = $valor / $req["qtde_parcela"];
              
              $duplicata->venda_id  = $req["venda_id"];
              $duplicata->tPag    = $req["tPag"];
              $duplicata->nDup    = zeroEsquerda($i + $qtde+1, 3);
              $duplicata->dVenc   = somarData($req["vencimento"],$i*30);
              $duplicata->vDup    = $parcela;
              PdvDuplicata::Create(objToArray($duplicata));
          }
                    
         // $lista = $this->listarDuplicata($req["venda_id"]);
          echo json_encode($lista);
          
      }
      
      public function listarDuplicata($venda_id){
          $lista = PdvDuplicata::where("venda_id", $venda_id)->get();
          $resultado = array();
          foreach($lista as $l){
              $duplicata          = new \stdClass();
              $duplicata->id      = $l->id;
              $duplicata->venda_id  = $l->venda_id;
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
              $duplicata    = PdvDuplicata::where("id", $id)->first();
              $valor_total  = PdvVenda::find($duplicata->venda_id)->valor_liquido;
             // $valor_total  = Duplicata::where("venda_id", $duplicata->venda_id)->sum("vDup");
              //exclui o item
              $duplicata->delete();
              $lista      = PdvDuplicata::where("venda_id", $duplicata->venda_id)->get();
              
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
          PdvDuplicata::Create($req);
          $lista = PdvDuplicata::where("venda_id", $req["venda_id"])->get();
          echo json_encode($lista);
          
      }
}
