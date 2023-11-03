<?php

namespace App\Http\Controllers;

use App\Service\AssinaturaService;
use Illuminate\Routing\Controller;


class AssinaturaController extends Controller
{
    
    public function cobrancas($id){ 
        $dados["lista"]     = AssinaturaService::cobrancas($id);      
        return view("Cobranca.Index", $dados);
                
    }
    
    
   
}
