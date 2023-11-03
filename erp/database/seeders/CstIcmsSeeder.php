<?php

namespace Database\Seeders;

use App\Models\CstIcms;
use Illuminate\Database\Seeder;

class CstIcmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CstIcms::firstOrCreate(['cst' =>'00', 	 	'tipo'=>'L'  , 'descricao'=> '00: Tributada integralmente']);
        CstIcms::firstOrCreate(['cst' =>'10', 		'tipo'=>'L'  , 'descricao'=> '10: Tributada com cobr. por subst. trib.']);
        CstIcms::firstOrCreate(['cst' =>'20', 		'tipo'=>'L'  , 'descricao'=> '20: Com redução de base de cálculo']);
        CstIcms::firstOrCreate(['cst' =>'30', 		'tipo'=>'L'  , 'descricao'=> '30: Isenta ou não trib com cobr por subst trib']);
        CstIcms::firstOrCreate(['cst' =>'40', 		'tipo'=>'L'  , 'descricao'=> '40: Isenta']);
        CstIcms::firstOrCreate(['cst' =>'41', 		'tipo'=>'L'  , 'descricao'=> '41: Não tributada']);
        CstIcms::firstOrCreate(['cst' =>'50', 		'tipo'=>'L'  , 'descricao'=> '50: Suspesão']);
        CstIcms::firstOrCreate(['cst' =>'51', 		'tipo'=>'L'  , 'descricao'=> '51: Diferimento']);
        CstIcms::firstOrCreate(['cst' =>'60', 		'tipo'=>'L'  , 'descricao'=> '60: ICMS cobrado anteriormente por subst trib']);
        CstIcms::firstOrCreate(['cst' =>'70', 		'tipo'=>'L'  , 'descricao'=> '70: Redução de Base Calc e cobr ICMS por subst trib']);
        CstIcms::firstOrCreate(['cst' =>'90', 		'tipo'=>'L'  , 'descricao'=> '90: Outros']);
        CstIcms::firstOrCreate(['cst' =>'10Part', 	'tipo'=>'L'  , 'descricao'=> 'Partilha 10: Entre UF origem e destino ou definida na legislação com Subst Trib']);
        CstIcms::firstOrCreate(['cst' =>'90Part', 	'tipo'=>'L'  , 'descricao'=> 'Partilha 90: Entre UF origem e destino ou definida na legislação - outros']);
        CstIcms::firstOrCreate(['cst' =>'41ST', 	'tipo'=>'L'  , 'descricao'=> 'Repasse 41: ICMS ST retido em operações interestaduais com repasses do Subst Trib']);
        CstIcms::firstOrCreate(['cst' =>'101', 		'tipo'=>'S'  , 'descricao'=> 'Simples Nacional: 101: Com permissão de crédito']);
        CstIcms::firstOrCreate(['cst' =>'102', 		'tipo'=>'S'  , 'descricao'=> 'Simples Nacional: 102: Sem permissão de crédito']);
        CstIcms::firstOrCreate(['cst' =>'103', 		'tipo'=>'S'  , 'descricao'=> 'Simples Nacional: 103: Isenção do ICMS para faixa de receita bruta']);
        CstIcms::firstOrCreate(['cst' =>'201', 		'tipo'=>'S'  , 'descricao'=> 'Simples Nacional: 201: Com permissão de crédito, com cobr ICMS por Subst Trib']);
        CstIcms::firstOrCreate(['cst' =>'202', 		'tipo'=>'S'  , 'descricao'=> 'Simples Nacional: 202: Sem permissão de crédito, com cobr ICMS por Subst Trib']);
        CstIcms::firstOrCreate(['cst' =>'203', 		'tipo'=>'S'  , 'descricao'=> 'Simples Nacional: 203: Isenção ICMS p/ faixa de receita bruta e cobr do ICMS por ST']);
        CstIcms::firstOrCreate(['cst' =>'300', 		'tipo'=>'S'  , 'descricao'=> 'Simples Nacional: 300: Imune']);
        CstIcms::firstOrCreate(['cst' =>'400', 		'tipo'=>'S'  , 'descricao'=> 'Simples Nacional: 400: Não tributada']);
        CstIcms::firstOrCreate(['cst' =>'500', 		'tipo'=>'S'  , 'descricao'=> 'Simples Nacional: 500: ICMS cobrado antes por subst trib ou antecipação']);
        CstIcms::firstOrCreate(['cst' =>'900', 		'tipo'=>'S'  , 'descricao'=> 'Simples Nacional: 900: Outros']);
    }
}
