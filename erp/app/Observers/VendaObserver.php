<?php

namespace App\Observers;

use App\Models\Venda;
use Illuminate\Support\Facades\Auth;


class VendaObserver
{
    public function creating(Venda $venda){    
        
        $venda->total_desconto_item = $venda->total_desconto_item != null ? getFloat($venda->total_desconto_item) : 0;
        $venda->total_seguro        = $venda->total_seguro != null ? getFloat($venda->total_seguro) : 0;
        $venda->despesas_outras     = $venda->despesas_outras != null ? getFloat($venda->despesas_outras) : 0;   
        $venda->valor_venda         = $venda->valor_venda != null ? getFloat($venda->valor_venda) : 0;
        $venda->valor_frete         = $venda->valor_frete != null ? getFloat($venda->valor_frete) : 0;
        $venda->valor_liquido       = $venda->valor_venda != null ? getFloat($venda->valor_venda) : 0;
        $venda->enviou_financeiro   = 'S';
        $venda->status_financeiro_id= config("constantes.status.ABERTO");
        $venda->status_id           = config("constantes.status.DIGITACAO");
        $venda->usuario_id          = Auth::user()->getAuthIdentifier();
        
    }
        
        
    public function updating(Venda $venda){
        
    }
    public function created(Venda $venda){     
       /* if($venda->pedido_cliente_id){
            $pedido                   = PedidoCliente::where("id", $venda['pedido_id'])->first();
            $pedido->venda_id         = $venda->id;
            $pedido->data_atendimento = hoje();
            $pedido->status_id        = config("constantes.status.FINALIZADO");
            $pedido->save();
        }*/
  
    }
    
   
}
