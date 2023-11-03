<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
   
    public function run()
    {
        foreach (config("constantes.status") as $chave=>$valor){
            Status::Create([
                'status'    => $chave,
                'descricao' => $chave,
            ]);
        }
      /*  $t1 = Status::firstOrCreate([
            'status' => 'ativo',
            'descricao' => 'Utilizada para indicar que um recurso/modelo está ATIVO',
        ]);
        $t2 = Status::firstOrCreate([
            'status' => 'inativo',
            'descricao' => 'Utilizada para indicar que um recurso/modelo está INATIVO',
        ]);
        $t3 = Status::firstOrCreate([
            'status' => 'deletado',
            'descricao' => 'Utilizada para indicar que um recurso/modelo foi DELETADO e não deve ser utilizado',
        ]);
        $t4 = Status::firstOrCreate([
            'status' => 'novo',
            'descricao' => 'Utilizada para indicar que um recurso/modelo é novo',
        ]);
        $t5 = Status::firstOrCreate([
            'status' => 'pendente',
            'descricao' => 'Utilizada para indicar que um recurso/modelo foi está pendente de outros recursos para continuar seu FLUXO',
        ]);
        $t6 = Status::firstOrCreate([
            'status' => 'cancelado',
            'descricao' => 'Indica que algo foi cancelado automaticamente ou via administrativa',
        ]);
        $t7 = Status::firstOrCreate([
            'status' => 'finalizado',
            'descricao' => 'Indica que algo encerrou seu fluxo natural',
        ]);
        $t8 = Status::firstOrCreate([
            'status' => 'enviado',
            'descricao' => 'Quando couber o status ENVIADO para um recurso',
        ]);
        
        $t9 = Status::firstOrCreate([
            'status' => 'pendente',
            'descricao' => 'Quando uma acomodação está reservada (em processo de compra)',
        ]);
        $t10 = Status::firstOrCreate([
            'status' => 'indisponivel',
            'descricao' => 'Quando uma acomodação está temporariamente indiponível',
        ]);
        $t11 = Status::firstOrCreate([
            'status' => 'ocupado',
            'descricao' => 'Quando uma acomodação foi comprada',
        ]);
        $t12 = Status::firstOrCreate([
            'status' => 'disponivel',
            'descricao' => 'Quando uma acomodação está disponivel',
        ]);
        $t13 = Status::firstOrCreate([
            'status' => 'obrigatorio',
            'descricao' => 'quando um elemento é obrigatório para o sistema',
        ]);
        */
        print 'Status Iniciais setados com sucesso';
    }
}
