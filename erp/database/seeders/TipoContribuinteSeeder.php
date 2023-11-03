<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoContribuinte;

class TipoContribuinteSeeder extends Seeder
{
    
    public function run()
    {
        TipoContribuinte::Create(['tipo_contribuinte'   =>  'Não Contribuinte' ]);
        TipoContribuinte::Create(['tipo_contribuinte'   =>  'Contribuinte' ]);
        TipoContribuinte::Create(['tipo_contribuinte'   =>  'Contribuinte Simples Nacional' ]);
        TipoContribuinte::Create(['tipo_contribuinte'   =>  'Indústria' ]);
        TipoContribuinte::Create(['tipo_contribuinte'   =>  'Indústria Simples' ]);
        TipoContribuinte::Create(['tipo_contribuinte'   =>  'Público' ]);
    }
}

