<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PedidoCliente;

class PedidoClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PedidoCliente::Create([
            'data_pedido'   =>  date("Y-m-d"),
            'hora_pedido'   =>  date("H:i:s"),
            'total'         =>  100.0,
            'status_pedido_id'  =>  2 ,
            'cliente_id'    =>  1
        ]);
        
        PedidoCliente::Create([
            'data_pedido'   =>  date("Y-m-d"),
            'hora_pedido'   =>  date("H:i:s"),
            'total'         =>  150.0,
            'status_pedido_id'     =>  2 ,
            'cliente_id'    =>  1
        ]);
    }
}
