<?php
namespace Database\Seeders;
use App\Models\StatusOrdemCompra;
use Illuminate\Database\Seeder;

class StatusOrdemCompraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StatusOrdemCompra::firstOrCreate([
            'status_ordem_compra'   =>  'Em digitação'
        ]);
        
        StatusOrdemCompra::firstOrCreate([
            'status_ordem_compra'   =>  'Aguardando Aprovação'
        ]);
        
        StatusOrdemCompra::firstOrCreate([
            'status_ordem_compra'   =>  'Aprovado'
        ]);
        
        StatusOrdemCompra::firstOrCreate([
            'status_ordem_compra'   =>  'Autorizado'
        ]);
        
        StatusOrdemCompra::firstOrCreate([
            'status_ordem_compra'   =>  'Finalizado'
        ]);
        
        StatusOrdemCompra::firstOrCreate([
            'status_ordem_compra'   =>  'Cancelado'
        ]);
    }
}
