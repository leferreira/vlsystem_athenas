<?php

namespace Database\Seeders;

use App\Models\CstIpi;
use Illuminate\Database\Seeder;

class CstIpiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CstIpi::firstOrCreate(['cst' =>'00',  'tipo'=>'E',		'descricao'     =>'00: Entrada com recuperação de crédito']);
        CstIpi::firstOrCreate(['cst' =>'01',  'tipo'=>'E',		'descricao'     =>'01: Entrada tributada com alíquota zero']);
        CstIpi::firstOrCreate(['cst' =>'02',  'tipo'=>'E',		'descricao'     =>'02: Entrada isenta']);
        CstIpi::firstOrCreate(['cst' =>'03',  'tipo'=>'E',		'descricao'     =>'03: Entrada não-tributada']);
        CstIpi::firstOrCreate(['cst' =>'04',  'tipo'=>'E',		'descricao'     =>'04: Entrada imune']);
        CstIpi::firstOrCreate(['cst' =>'05',  'tipo'=>'E',		'descricao'     =>'05: Entrada com suspensão']);
        CstIpi::firstOrCreate(['cst' =>'49',  'tipo'=>'E',		'descricao'     =>'49: Outras entradas']);
        CstIpi::firstOrCreate(['cst' =>'50',  'tipo'=>'S',		'descricao'     =>'50: Saída tributada']);
        CstIpi::firstOrCreate(['cst' =>'51',  'tipo'=>'S',		'descricao'     =>'51: Saída tributada com alíquota zero']);
        CstIpi::firstOrCreate(['cst' =>'52',  'tipo'=>'S',		'descricao'     =>'52: Saída isenta']);
        CstIpi::firstOrCreate(['cst' =>'53',  'tipo'=>'S',		'descricao'     =>'53: Saída não-tributada']);
        CstIpi::firstOrCreate(['cst' =>'54',  'tipo'=>'S',		'descricao'     =>'54: Saída imune']);
        CstIpi::firstOrCreate(['cst' =>'55',  'tipo'=>'S',		'descricao'     =>'55: Saída com suspensão']);
        CstIpi::firstOrCreate(['cst' =>'99',  'tipo'=>'S',		'descricao'     =>'99: Outras saídas']);
    }
}
