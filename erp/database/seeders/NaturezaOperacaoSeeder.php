<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NaturezaOperacao;

class NaturezaOperacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NaturezaOperacao::create([
            'natureza'                  => 'Natureza Padrão - Simples',
            'CFOP_entrada_estadual'     => '1102',
            'CFOP_entrada_inter_estadual' => '1102',
            'CFOP_saida_estadual'       => '5102',
            'CFOP_saida_inter_estadual' => '5102',
            'empresa_id'                => '1',
            
        ]);
    }
}
