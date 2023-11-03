<?php

namespace App\Http\Controllers\Delivery\Web;

use App\Http\Controllers\Controller;
use App\Models\Produto;


class HomeWebController extends Controller
{
    public function index(){
       
        $dados["produtos"] = Produto::get();    
        return view("Delivery.Web.home", $dados);
    }
}
