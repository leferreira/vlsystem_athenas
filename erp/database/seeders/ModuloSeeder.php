<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Modulo;

class ModuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {      
        Modulo::Create(['nome' => 'Venda'        , 'menu'=>'modulo_venda'             ]);
        Modulo::Create(['nome' => 'Compra'       , 'menu'=>'modulo_compra'           ]);
        Modulo::Create(['nome' => 'Loja_Virtual' , 'menu'=>'modulo_loja_virtual'     ]);
       // Modulo::Create(['nome' => 'Ordem Serviço', 'menu'=>'modulo_os'               ]);
        Modulo::Create(['nome' => 'Nfe'          , 'menu'=>'modulo_nfe'              ]);
        Modulo::Create(['nome' => 'PDV'          , 'menu'=>'modulo_pdv'              ]);
        Modulo::Create(['nome' => 'Pedido'       , 'menu'=>'modulo_pedido_cliente'   ]);
        Modulo::Create(['nome' => 'Financeiro'   , 'menu'=>'modulo_financeiro'       ]);
        Modulo::Create(['nome' => 'Estoque'      , 'menu'=>'modulo_estoque'          ]);
     }
}
