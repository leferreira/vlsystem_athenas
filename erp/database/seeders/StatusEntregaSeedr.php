<?php

namespace Database\Seeders;

use App\Models\StatusEntrega;
use Illuminate\Database\Seeder;

class StatusEntregaSeedr extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config("constantes.status_entrega") as $chave=>$valor){
            StatusEntrega::Create([
                'status'    => $chave,
            ]);
        }
    }
}
