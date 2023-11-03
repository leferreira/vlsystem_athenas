<?php

namespace App\Http\Controllers;


class ErroController extends Controller{    
    public function index(){
        $dados["configuracao"] = null;
        return view("erro", $dados);
    }    
 
      
}
