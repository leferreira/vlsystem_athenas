<?php

namespace Database\Seeders;

use App\Models\Estado;
use Illuminate\Database\Seeder;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Estado::firstOrCreate([
            'estado'   =>  'Acre',
            'uf'     =>  'AC',
            'ibge' =>  '12'
        ]);
        
        Estado::firstOrCreate([
            'estado'   =>  'Alagoas',
            'uf'     =>  'AL',
            'ibge' =>  '27'
        ]);
        Estado::firstOrCreate([
            'estado'   =>  'Amapá',
            'uf'     =>  'AP',
            'ibge' =>  '16'
        ]);
        Estado::firstOrCreate([
            'estado'   =>  'Amazonas',
            'uf'     =>  'AM',
            'ibge' =>  '13'
        ]);
        Estado::firstOrCreate([
            'estado'   =>  'Bahia',
            'uf'     =>  'BA',
            'ibge' =>  '29'
        ]);
        Estado::firstOrCreate([
            'estado'   =>  'Ceará',
            'uf'     =>  'CE',
            'ibge' =>  '23'
        ]);
        Estado::firstOrCreate([
            'estado'   =>  'Distrito Federal',
            'uf'     =>  'DF',
            'ibge' =>  '53'
        ]);
        Estado::firstOrCreate([
            'estado'   =>  'Espírito Santo',
            'uf'     =>  'ES',
            'ibge' =>  '32'
        ]);
        Estado::firstOrCreate([
            'estado'   =>  'Goiás',
            'uf'     =>  'GO',
            'ibge' =>  '52'
        ]);
        Estado::firstOrCreate([
            'estado'   =>  'Maranhão',
            'uf'     =>  'MA',
            'ibge' =>  '21'
        ]);
        Estado::firstOrCreate([
            'estado'   =>  'Mato Grosso do Sul',
            'uf'     =>  'MS',
            'ibge' =>  '50'
        ]);
        Estado::firstOrCreate([
            'estado'   =>  'Mato Grosso',
            'uf'     =>  'MT',
            'ibge' =>  '51'
        ]);
        Estado::firstOrCreate([
            'estado'   =>  'Minas Gerais',
            'uf'     =>  'MG',
            'ibge' =>  '31'
        ]);
        Estado::firstOrCreate([
            'estado'   =>  'Paraná',
            'uf'     =>  'PR',
            'ibge' =>  '41'
        ]);
        Estado::firstOrCreate([
            'estado'   =>  'Paraíba',
            'uf'     =>  'PB',
            'ibge' =>  '25'
        ]);
        Estado::firstOrCreate([
            'estado'   =>  'Pará',
            'uf'     =>  'PA',
            'ibge' =>  '15'
        ]);
        Estado::firstOrCreate([
            'estado'   =>  'Pernambuco',
            'uf'     =>  'PE',
            'ibge' =>  '26'
        ]);
        Estado::firstOrCreate([
            'estado'   =>  'Piauí',
            'uf'     =>  'PI',
            'ibge' =>  '22'
        ]);
        Estado::firstOrCreate([
            'estado'   =>  'Rio de Janeiro',
            'uf'     =>  'RJ',
            'ibge' =>  '33'
        ]);
        Estado::firstOrCreate([
            'estado'   =>  'Rio Grande do Norte',
            'uf'     =>  'RN',
            'ibge' =>  '24'
        ]);
        Estado::firstOrCreate([
            'estado'   =>  'Rio Grande do Sul',
            'uf'     =>  'RS',
            'ibge' =>  '43'
        ]);
        Estado::firstOrCreate([
            'estado'   =>  'Rondônia',
            'uf'     =>  'RO',
            'ibge' =>  '11'
        ]);
        Estado::firstOrCreate([
            'estado'   =>  'Roraima',
            'uf'     =>  'RR',
            'ibge' =>  '14'
        ]);
        Estado::firstOrCreate([
            'estado'   =>  'Santa Catarina',
            'uf'     =>  'SC',
            'ibge' =>  '42'
        ]);
        Estado::firstOrCreate([
            'estado'   =>  'Sergipe',
            'uf'     =>  'SE',
            'ibge' =>  '28'
        ]);
        Estado::firstOrCreate([
            'estado'   =>  'São Paulo',
            'uf'     =>  'SP',
            'ibge' =>  '35'
        ]);
        Estado::firstOrCreate([
            'estado'   =>  'Tocantins',
            'uf'     =>  'TO',
            'ibge' =>  '17'
        ]);
    }
}
