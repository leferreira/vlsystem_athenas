<?php

namespace App\Http\Controllers\Delivery\Balcao;

use App\Http\Controllers\Controller;
use App\Models\PedidoDelivery;
use App\Models\ClienteDelivery;
use App\Models\Status;


class HomeBalcaoController extends Controller
{
    public function index(){
        
        $dados["pedidos"]   = PedidoDelivery::all();
        $dados["clientes"]  = ClienteDelivery::all();
        $dados["status"]    = Status::all();
        return view("Delivery.Balcao.home", $dados);
    }
}
