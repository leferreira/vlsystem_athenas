<?php
namespace App\Http\Controllers\Admin\Nfe;

use App\Http\Controllers\Controller;
use App\Models\Nfe;
use App\Models\NfeDuplicata;
use App\Service\ConstanteService;
use Illuminate\Http\Request;

class NfeDuplicataController extends Controller{ 
      
    public function inserir(Request $request){
        $req            = $request->except(["_token","_method"]);  
        $nfe            = Nfe::find($req["nfe_id"]);
        
        if($req["forma_de_parcelar"]==2){
            $array_parcela  = explode("-", $req["qtde_parcela"]);          
        }else{
            for($i=1; $i<=$req["qtde_parcela"]; $i++){
                $array_parcela[] = 30 * $i;
            }
        }
                
        $valor_total    = $nfe->vLiq;
        $qtde_parcela   = count($array_parcela);
        $parcela        = number_format($valor_total / $qtde_parcela, 2, ".", "");

        $soma_parcela          = 0;
        NfeDuplicata::where("nfe_id", $req["nfe_id"])->delete();
        for($i=0; $i < $qtde_parcela; $i++){
            $duplicata          = new \stdClass();            
            
            $duplicata->nfe_id  = $req["nfe_id"];
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
             NfeDuplicata::Create(objToArray($duplicata));
            
        }    
        
        $lista = $this->listarDuplicata($req["nfe_id"]);
        echo json_encode($lista);
        
      }
      
      public function salvarAlteracao(Request $request){
          $req    = $request->except(["_token","_method"]);
          NfeDuplicata::where("id", $req["id"])->update($req);         
          
          echo json_encode("ok");
          
      }
      
      
      public function alterar(Request $request){
          $req     = $request->except(["_token","_method"]);
          $qtde = NfeDuplicata::where("nfe_id", $req["nfe_id"])->count("nfe_id");
          for($i=0; $i<$req["qtde_parcela"]; $i++){
              $duplicata  = new \stdClass();
              $valor      = getFloat($req["valor_parcela"]);
              $parcela    = $valor / $req["qtde_parcela"];
              
              $duplicata->nfe_id  = $req["nfe_id"];
              $duplicata->tPag    = $req["tPag"];
              $duplicata->nDup    = zeroEsquerda($i + $qtde+1, 3);
              $duplicata->dVenc   = somarData($req["vencimento"],$i*30);
              $duplicata->vDup    = $parcela;
              NfeDuplicata::Create(objToArray($duplicata));
          }
                    
         // $lista = $this->listarDuplicata($req["nfe_id"]);
          echo json_encode($lista);
          
      }
      
      public function listarDuplicata($nfe_id){
          $lista = NfeDuplicata::where("nfe_id", $nfe_id)->get();
          $resultado = array();
          foreach($lista as $l){
              $duplicata          = new \stdClass();
              $duplicata->id      = $l->id;
              $duplicata->nfe_id  = $l->nfe_id;
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
              $duplicata    = NfeDuplicata::where("id", $id)->first();
              $valor_total  = Nfe::find($duplicata->nfe_id)->vLiq;
             // $valor_total  = NfeDuplicata::where("nfe_id", $duplicata->nfe_id)->sum("vDup");
              //exclui o item
              $duplicata->delete();
              $lista      = NfeDuplicata::where("nfe_id", $duplicata->nfe_id)->get();
              
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
          NfeDuplicata::Create($req);
          $lista = NfeDuplicata::where("nfe_id", $req["nfe_id"])->get();
          echo json_encode($lista);
          
      }
}
