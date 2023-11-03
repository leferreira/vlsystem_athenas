<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\ProdutoDelivery;


class PedidoWebController extends Controller
{
    public function index(){
       
        $dados["produtos"] = ProdutoDelivery::all();    
        return view("Delivery.Frente.Pedido.Create", $dados);
    }
    
    public function finalizar(){        
        $dados["produtos"] = ProdutoDelivery::all();
        return view("Delivery.Frente.Pedido.Finalizar", $dados);
    }
}
