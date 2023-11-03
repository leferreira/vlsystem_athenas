<?php
namespace App\Service;

use App\Models\PedidoDelivery;
use App\Models\StatusPedidoDelivery;

class PedidoDeliveryService{    
    public static function filtro($dataInicial, $dataFinal, $id_status){
        $pedidos = PedidoDelivery::whereBetween('data_registro', [$dataInicial,$dataFinal])
        ->where('status_pedido_id', $id_status)
        ->get();       
        
        return $pedidos;
    }
    
    public static function listaPedidoPorStatus($dataInicial, $dataFinal){
        $lista_status = StatusPedidoDelivery::all();
        foreach($lista_status as $s){
            $pedidos = self::filtro($dataInicial, $dataFinal, $s->id);
            $s->pedidos = $pedidos;            
        }        
        return $lista_status;
    }
}

