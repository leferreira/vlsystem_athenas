<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoNfe;

class TipoNfeSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config("constantes.tipo_notafiscal") as $chave=>$valor){
            TipoNfe::Create([
                'id'      => $valor,
                'tipo'    => $chave,
            ]);
        }
        
    }
}
