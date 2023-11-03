<?php

namespace App\Http\Controllers;

use App\Service\CobrancaService;
use Illuminate\Routing\Controller;

class CartaoController extends Controller
{
 
    public function ver($uuid){
        $cobranca = CobrancaService::detalhe($uuid);  
       
        if(!$cobranca){
            return redirect()->route('cobranca.index')->with('msg_erro', "Cobrança Não encontrada.");
        }
        $dados["cobranca"] = $cobranca;
        $dados["pagamentoJs"]       = true;
        return view("Pagamento.Cartao", $dados);
                
    }
    
 
 }
