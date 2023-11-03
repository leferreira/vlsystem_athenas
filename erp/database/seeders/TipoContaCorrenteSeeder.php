<?php

namespace Database\Seeders;

use App\Models\TipoContaCorrente;
use Illuminate\Database\Seeder;

class TipoContaCorrenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoContaCorrente::Create([ 'tipo_conta'  => "Conta Corrente" ]);
        TipoContaCorrente::Create([ 'tipo_conta'  => "Poupança" ]);
        TipoContaCorrente::Create([ 'tipo_conta'  => "Carteira/Caixa" ]);
        TipoContaCorrente::Create([ 'tipo_conta'  => "Investimento" ]);
        TipoContaCorrente::Create([ 'tipo_conta'  => "Cartão Crédito" ]);
        TipoContaCorrente::Create([ 'tipo_conta'  => "Outros" ]);
    }
}
