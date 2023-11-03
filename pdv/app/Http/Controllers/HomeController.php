<?php

namespace App\Http\Controllers;


class HomeController extends Controller
{
       
    public function index()
    {    
       // i(session("usuario_pdv_logado"));
        return view("home");
    }

   
}
