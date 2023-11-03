<?php

namespace Database\Seeders;

use App\Models\StatusPedidoCliente;
use Illuminate\Database\Seeder;

class StatusPedidoDeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StatusPedidoCliente::firstOrCreate([
            'status_pedido'   =>  'Novo'
        ]);
        StatusPedidoCliente::firstOrCreate([
            'status_pedido'   =>  'Aprovado'
        ]);
        StatusPedidoCliente::firstOrCreate([
            'status_pedido'   =>  'Recusado'
        ]);
        StatusPedidoCliente::firstOrCreate([
            'status_pedido'   =>  'Reprovado'
        ]);
        StatusPedidoCliente::firstOrCreate([
            'status_pedido'   =>  'Finalizado'
        ]);
        StatusPedidoCliente::firstOrCreate([
            'status_pedido'   =>  'Carrinho'
        ]);
    }
}
