<?php

namespace App\Http\Controllers\Admin\Pdv;

use App\Http\Controllers\Controller;
use App\Http\Requests\PdvVendaRequest;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\FormaPagto;
use App\Models\Nfce;
use App\Models\PdvVenda;
use App\Models\Produto;
use App\Models\Transportadora;
use App\Models\Tributacao;
use App\Models\Venda;
use App\Service\ConstanteService;
use Illuminate\Support\Facades\Auth;
use App\Models\PdvCaixa;
use App\Models\PdvCaixaNumero;
use Illuminate\Http\Request;
use App\Models\PdvItemVenda;
use App\Models\PdvDuplicata;
use App\Models\NaturezaOperacao;
use App\Models\Emitente;
use App\Service\ItemPdvVendaService;
use App\Service\MovimentoService;

class PdvVendaAnteriorController extends Controller
{
    
    public function index()
    {
        
    }    
    
    
    public function create(){
        
       
    } 
    
  
    
    public function store(PdvVendaRequest $request){        
       
    }
    
    
    
     
    
    
    
    
    
    public function gerarNfcePelaVenda($id){
        $pdvvenda        = PdvVenda::find($id);
        $nfce            = Nfce::where("venda_id",$id)->first();
        if(!$nfce){
            PdvVenda::inserirNfcePelaVenda($pdvvenda);
        }
        return redirect()->route("admin.notafiscal.listaNfce");
    }
    
    
    public function show($id)
    {
        
    }
   
   
  
   
    public function update(PdvVendaRequest $request, $id)
    {
        $req     =   $request->except(["_token","_method"]);
        Venda::where("id", $id)->update($req);
        return redirect()->route("admin.pdvvenda.index")->with('msg_sucesso', "item alterado com sucesso.");;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
    }
}
