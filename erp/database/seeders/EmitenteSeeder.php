<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Emitente;

class EmitenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     
        
        Emitente::create([
            'empresa_id'            =>  1,
            'razao_social'          =>  'Intelimax Comércio Ltda',
            'nome_fantasia'         =>  'mjailton Cursos',
            'cnpj'                  =>  '37450325000186',
            'ie'                    =>  '11992803',
            'crt'                   => '1',
            'fone'                  =>  '9898988989',
            'email'                 =>  'mjailton@gmail.com',
            'cep'                   =>  '22040002',
            'logradouro'            =>  'Rua Barata Ribeiro',
            'numero'                =>  '191',
            'uf'                    =>  'RJ',
            'cidade'                =>  'Rio de Janeiro',
            'bairro'                =>  'Copacabana',
            'ibge'                  =>  '3304557',
            'pais'                  =>  'Brasil',
            'codPais'               => '1058',            
            
            'cst_csosn_padrao'      => '103',
            'cst_cofins_padrao'     => '07',
            'cst_pis_padrao'        => '07',
            'frete_padrao'          => '9',
            'tipo_pagamento_padrao' => '01',
            'nat_op_padrao_nfe'     => 'Venda de Mercadoria',
            'nat_op_padrao_nfce'    => 'Venda de Mercadoria',
            'ambiente_nfe'          => '2',
            'numero_serie_nfe'      => '1',
            'numero_serie_nfce'     => '1',
            'ultimo_numero_nfe'     => '12',
            'ultimo_numero_nfce'    => '1',
            'ultimo_numero_cte'     => '1',
            'ultimo_numero_mdfe'    => '1',            
            
            'ultimo_numero_mdfe'    => '1',
            'csc'                   => 'A3468346-8954-4160-B494-DCDCA376AE38',
            'csc_id'                => '000001'
            
        ]);
    }
}
