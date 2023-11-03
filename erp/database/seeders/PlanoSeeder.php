<?php

namespace Database\Seeders;

use App\Models\Plano;
use Illuminate\Database\Seeder;

class PlanoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){        
        Plano::Create([
            'nome'          => 'Plano Básico',
            'limite_usuario'=> 1,
            'limite_nfe'    => 0,
            'limite_nfce'   => 0,
            'limite_pdv'    => 0,
            'valor_setup'   => 100
        ]);
        
        Plano::Create([
            'nome'          => 'Plano Econômico',
            'limite_usuario'=> 3,
            'limite_nfe'    => 10,
            'limite_nfce'   => 10,
            'limite_pdv'    => 1,
            'valor_setup'   => 100
        ]);
        
        Plano::Create([
            'nome'          => 'Plano Premium',
            'limite_usuario'=> 5,
            'limite_nfe'    => 100,
            'limite_nfce'   => 100,
            'limite_pdv'    => 3,
            'destaque'      => 'S',
            'valor_setup'   => 100
        ]);
        
        Plano::Create([
            'nome'          => 'Plano Ouro',
            'limite_usuario'=> 10,
            'limite_nfe'    => -1,
            'limite_nfce'   => -1,
            'limite_pdv'    => 8,
            'valor_setup'   => 100
        ]);
        
    }
}
