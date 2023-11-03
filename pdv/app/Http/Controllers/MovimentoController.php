<?php

namespace App\Http\Controllers;



class MovimentoController extends Controller{       
    public function index(){
        //$dados["lista"] = MovimentoService::lista(100);
        //$dados["produtos"] = Service::lista("produto");
        return view('Caixa.Create', $dados);
    }  
    
  
    
}
