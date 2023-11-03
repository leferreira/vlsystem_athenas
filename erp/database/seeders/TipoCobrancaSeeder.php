<?php

namespace Database\Seeders;

use App\Models\TipoCobranca;
use Illuminate\Database\Seeder;

class TipoCobrancaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {  
       TipoCobranca::Create([ 'tipo_cobranca'  => "Diario", "qtde_dias" => 1 ]);
       TipoCobranca::Create([ 'tipo_cobranca'  => "Semanal", "qtde_dias" => 7 ]);
       TipoCobranca::Create([ 'tipo_cobranca'  => "Quinzenal", "qtde_dias" => 15 ]);
       TipoCobranca::Create([ 'tipo_cobranca'  => "Mensal", "qtde_dias" => 30 ]);
       TipoCobranca::Create([ 'tipo_cobranca'  => "Bimestral", "qtde_dias" => 60 ]);
       TipoCobranca::Create([ 'tipo_cobranca'  => "Trimestral", "qtde_dias" => 90 ]);
       TipoCobranca::Create([ 'tipo_cobranca'  => "Semestral", "qtde_dias" => 180 ]);
       TipoCobranca::Create([ 'tipo_cobranca'  => "Anual", "qtde_dias" => 360 ]);
       TipoCobranca::Create([ 'tipo_cobranca'  => "Bienal", "qtde_dias" => 720 ]);
        
    }
}
