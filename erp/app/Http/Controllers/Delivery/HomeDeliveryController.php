<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Produto;


class HomeDeliveryController extends Controller
{
    public function index(){
       
        $dados["produtos"] = Produto::all();    
        return view("Delivery.home", $dados);
    }
}
