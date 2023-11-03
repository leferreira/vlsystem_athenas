<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DeliveryConfig;

class ConfigDeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DeliveryConfig::create([
            'link_face'         => 'facebook',
            'link_twiteer'      => 'twiter',
            'link_google'       => 'google',
            'link_instagram'    => 'instagram',
            'telefone'          => '98 99127 5551',
            'endereco'          => 'Rua do Delivery',
            'tempo_medio_entrega' => '30',
            'tempo_maximo_cancelamento'  => '40',
            'valor_entrega'     => '10.00',
            'nome_exibicao_web' => 'Delivery Mjailton',
            'latitude'          => '10',
            'longitude'         => '10',
            'valor_km'          => 1,
            'entrega_gratis_ate'=> '0',
            'maximo_km_entrega' => '4',
            'maximo_adicionais' => '4',
            'maximo_adicionais_pizza' => 4,
        ]);
    }
}
