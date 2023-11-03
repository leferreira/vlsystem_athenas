<?php

namespace Database\Seeders;

use App\Models\LojaCliente;
use Illuminate\Database\Seeder;

class LojaClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LojaCliente::create([
            'empresa_id'    => 1,
            'nome'          => 'Manoel',
            'sobre_nome'    => 'Jailton ',
            'cpf'           => '78589452387',
            'email'         => 'mjailton@gmail.com',
            'telefone'      => '98991275551',
            'senha'         => '81dc9bdb52d04dc20036dbd8313ed055',
            'status_id'     => config("constante.status.ATIVO")
        ]);
    }
}
