<?php

namespace Database\Seeders;

use App\Models\LojaConfiguracao;
use Illuminate\Database\Seeder;

class LojaConfiguracaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LojaConfiguracao::create([
            'empresa_id'=> 1,
            'nome'      => 'Intelimax Comércio LTDA',
            'link'      => 'mjailton.com.br',
            'rua'       => 'Rua 10',
            'numero'    => 10,
            'bairro'    => 'Cohaserma',
            'cidade'    => 'São Luís',
            'cep'       => '65072-240',
            'telefone'  => '98991275551',
            'email'     => 'mjailton@gmail.com',
            'link_facebook' => '',
            'link_twiter' => '',
            'link_instagram' => '',
            'frete_gratis_valor' => 100,
            'mercadopago_public_key' => '',
            'mercadopago_access_token' => '',
            'latitude'  => '1',
            'longitude' => '1',
            'politica_privacidade' => 1,
            'src_mapa'  => '',
            'cor_principal' => '',
            'google_api' => '',
            'tema_ecommerce' => 1,
            'uf' => 'MA',
        ]);
    }
}
