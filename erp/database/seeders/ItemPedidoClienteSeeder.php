<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ItemPedidoCliente;

class ItemPedidoClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ItemPedidoCliente::Create([
            'produto_id'        =>  1,
            'pedido_id'         =>  1,
            'qtde'              =>  1 ,
            'valor'             =>  100,
            'subtotal'          =>  100
        ]);
        
        ItemPedidoCliente::Create([
            'produto_id'        =>  2,
            'pedido_id'         =>  2,
            'qtde'              =>  1 ,
            'valor'             =>  150,
            'subtotal'          =>  150
        ]);
    }
}
