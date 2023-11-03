<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClienteDelivery;

class ClienteDeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClienteDelivery::create([
            'nome'          => 'Manoel',
            'sobre_nome'    => 'Jailton ',
            'senha'         => '81dc9bdb52d04dc20036dbd8313ed055',
            'celular'       => '98991275551',
            'email'         => 'mjailton@gmail.com',
            'token'         => '688214',
            'data_token'    => '2022-01-10 10:43:22',
            'ativo'         => 1
        ]);
    }
}
