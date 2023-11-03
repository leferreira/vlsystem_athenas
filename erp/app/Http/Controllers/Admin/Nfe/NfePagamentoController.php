<?php
namespace App\Http\Controllers\Admin\Nfe;

use App\Http\Controllers\Controller;
use App\Http\Requests\NfePagamentoRequest;
use App\Models\NfeDuplicata;
use App\Models\NfePagamento;

class NfePagamentoController extends Controller{ 
      
    public function store(NfePagamentoRequest $request){
        $retorno = new \stdClass();       
        try {
            $req                = $request->except(["_token","_method"]);
            $req['vPag']        = $req['vPag'] ? getFloat($req['vPag']) : 0;
            NfePagamento::Create($req);
            $lista              = NfePagamento::lista($req["nfe_id"]); 
            $retorno->tem_erro  = false;
            $retorno->erro      = "";
            $retorno->retorno   = $lista;
            return response()->json($retorno);
        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->erro      = $e->getMessage();
            $retorno->retorno   = "";
            return response()->json($retorno);
        }        
        
      }
      
      public function destroy($id){
          $retorno = new \stdClass();
          try {
              $pagamento= NfePagamento::where("id", $id)->first();
              $pagamento->delete();
              $lista = NfePagamento::lista($pagamento->nfe_id); 
              $retorno->tem_erro  = false;
              $retorno->erro      = "";
              $retorno->retorno   = $lista;
              return response()->json($retorno);
          } catch (\Exception $e) {
              $retorno->tem_erro  = true;
              $retorno->erro      = $e->getMessage();
              $retorno->retorno   = "";
              return response()->json($retorno);
          }
          
          
      }
   
}
