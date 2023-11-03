<?php

namespace Database\Seeders;

use App\Models\StatusPedidoCliente;
use Illuminate\Database\Seeder;

class StatusPedidoClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StatusPedidoCliente::firstOrCreate([
            'status_pedido'   =>  'Em digitação'
        ]);
        StatusPedidoCliente::firstOrCreate([
            'status_pedido'   =>  'Em Espera'
        ]);
        StatusPedidoCliente::firstOrCreate([
            'status_pedido'   =>  'Em Produção'
        ]);
        StatusPedidoCliente::firstOrCreate([
            'status_pedido'   =>  'Pronto para Faturar'
        ]);
        StatusPedidoCliente::firstOrCreate([
            'status_pedido'   =>  'Faturado'
        ]);
        StatusPedidoCliente::firstOrCreate([
            'status_pedido'   =>  'Excluído'
        ]);
        StatusPedidoCliente::firstOrCreate([
            'status_pedido'   =>  'Recusado'
        ]);
    }
}
