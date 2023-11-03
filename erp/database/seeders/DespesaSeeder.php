<?php

namespace Database\Seeders;

use App\Models\FinDespesa;
use Illuminate\Database\Seeder;

class DespesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FinDespesa::firstOrCreate([
            'conta_id' => '204',
            'despesa' => 'Água'
        ]);
        FinDespesa::firstOrCreate([
            'conta_id' => '188',
            'despesa' => 'Telefone'
        ]);
        FinDespesa::firstOrCreate([
            'conta_id' => '197',
            'despesa' => 'IPTU'
        ]);
        FinDespesa::firstOrCreate([
            'conta_id' => '198',
            'despesa' => 'IPVA'
        ]);
        FinDespesa::firstOrCreate([
            'conta_id' => '242',
            'despesa' => 'Aluguel'
        ]);
        FinDespesa::firstOrCreate([
            'conta_id' => '184',
            'despesa' => 'Combustível'
        ]);
        FinDespesa::firstOrCreate([
            'conta_id' => '205',
            'despesa' => 'Material Escolar'
        ]);
    }
}
