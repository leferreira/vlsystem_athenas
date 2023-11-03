<?php

namespace App\Observers;

use App\Models\Compra;
use Illuminate\Support\Facades\Auth;


class CompraObserver
{
    public function creating(Compra $compra){    
        
           
        $compra->valor_compra        = $compra->valor_compra != null ? getFloat($compra->valor_compra) : 0;
        $compra->valor_frete         = $compra->valor_frete != null ? getFloat($compra->valor_frete) : 0;
        $compra->valor_total         = $compra->valor_total != null ? getFloat($compra->valor_total) : 0;
        
        $compra->desconto_valor      = $compra->desconto_valor != null ? getFloat($compra->desconto_valor) : 0;
        $compra->desconto_per        = $compra->desconto_per != null ? getFloat($compra->desconto_per) : 0;
        $compra->valor_total         = $compra->valor_total != null ? getFloat($compra->valor_total) : 0;
        $compra->total_desconto_item = $compra->total_desconto_item != null ? getFloat($compra->total_desconto_item) : 0;
        $compra->total_seguro        = $compra->total_seguro != null ? getFloat($compra->total_seguro) : 0;
        $compra->despesas_outras     = $compra->despesas_outras != null ? getFloat($compra->despesas_outras) : 0;
        
        $compra->enviou_financeiro   = 'S';
        $compra->enviou_estoque      = 'N';
        $compra->status_financeiro_id= config("constantes.status.ABERTO");
        $compra->status_id           = config("constantes.status.DIGITACAO");
        $compra->usuario_id          = Auth::user()->getAuthIdentifier();
        
    }
        
        
    public function updating(Compra $compra){
        
    }
    public function created(Compra $compra){     
       /* if($compra->pedido_cliente_id){
            $pedido                   = PedidoCliente::where("id", $compra['pedido_id'])->first();
            $pedido->compra_id         = $compra->id;
            $pedido->data_atendimento = hoje();
            $pedido->status_id        = config("constantes.status.FINALIZADO");
            $pedido->save();
        }*/
  
    }
    
   
}
