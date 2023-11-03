<?php

namespace Database\Seeders;

use App\Models\CstPis;
use Illuminate\Database\Seeder;

class CstPisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CstPis::firstOrCreate(['cst'=>'01', 'tipo'=>'S',	'descricao'     =>'01: Operação tributável (BC = Operação alíq. normal (cumul./não cumul.)']);
        CstPis::firstOrCreate(['cst'=>'02', 'tipo'=>'S',	'descricao'     =>'02: Operação tributável (BC = valor da operação (alíquota diferenciada)']);
        CstPis::firstOrCreate(['cst'=>'03', 'tipo'=>'S',	'descricao'     =>'03: Operação tributável (BC = quant. x alíq. por unidade de produto)']);
        CstPis::firstOrCreate(['cst'=>'04', 'tipo'=>'S',	'descricao'     =>'04: Operação tributável (tributação monofásica, alíquota zero)']);
        CstPis::firstOrCreate(['cst'=>'06', 'tipo'=>'S',	'descricao'     =>'06: Operação tributável (alíquota zero)']);
        CstPis::firstOrCreate(['cst'=>'07', 'tipo'=>'S',	'descricao'     =>'07: Operação isenta da contribuição']);
        CstPis::firstOrCreate(['cst'=>'08', 'tipo'=>'S',	'descricao'     =>'08: Operação sem incidência da contribuição']);
        CstPis::firstOrCreate(['cst'=>'09', 'tipo'=>'S',	'descricao'     =>'09: Operação com suspensão da contribuição']);
        CstPis::firstOrCreate(['cst'=>'49', 'tipo'=>'S',	'descricao'     =>'49: Outras Operações de Saída']);
        CstPis::firstOrCreate(['cst'=>'50', 'tipo'=>NULL,	'descricao'     =>'50: Direito a Crédito. Vinculada Exclusivamente a Receita Tributada no Mercado Interno']);
        CstPis::firstOrCreate(['cst'=>'51', 'tipo'=>NULL,	'descricao'     =>'51: Direito a Crédito. Vinculada Exclusivamente a Receita Não Tributada no Mercado Interno']);
        CstPis::firstOrCreate(['cst'=>'52', 'tipo'=>NULL,	'descricao'     =>'52: Direito a Crédito. Vinculada Exclusivamente a Receita de Exportação']);
        CstPis::firstOrCreate(['cst'=>'53', 'tipo'=>NULL,	'descricao'     =>'53: Direito a Crédito. Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno']);
        CstPis::firstOrCreate(['cst'=>'54', 'tipo'=>NULL,	'descricao'     =>'54: Direito a Crédito. Vinculada a Receitas Tributadas no Mercado Interno e de Exportação']);
        CstPis::firstOrCreate(['cst'=>'55', 'tipo'=>NULL,	'descricao'     =>'55: Direito a Crédito. Vinculada a Receitas Não-Trib. no Mercado Interno e de Exportação']);
        CstPis::firstOrCreate(['cst'=>'56', 'tipo'=>NULL,	'descricao'     =>'56: Direito a Crédito. Vinculada a Rec. Trib. e Não-Trib. Mercado Interno e Exportação']);
        CstPis::firstOrCreate(['cst'=>'60', 'tipo'=>NULL,	'descricao'     =>'60: Créd. Presumido. Aquisição Vinc. Exclusivamente a Receita Tributada no Mercado Interno']);
        CstPis::firstOrCreate(['cst'=>'61', 'tipo'=>NULL,	'descricao'     =>'61: Créd. Presumido. Aquisição Vinc. Exclusivamente a Rec. Não-Trib. no Mercado Interno']);
        CstPis::firstOrCreate(['cst'=>'62', 'tipo'=>NULL,	'descricao'     =>'62: Créd. Presumido. Aquisição Vinc. Exclusivamente a Receita de Exportação']);
        CstPis::firstOrCreate(['cst'=>'63', 'tipo'=>NULL,	'descricao'     =>'63: Créd. Presumido. Aquisição Vinc. a Rec. Trib. e Não-Trib. no Mercado Interno']);
        CstPis::firstOrCreate(['cst'=>'64', 'tipo'=>NULL,	'descricao'     =>'64: Créd. Presumido. Aquisição Vinc. a Rec. Trib. no Mercado Interno e de Exportação']);
        CstPis::firstOrCreate(['cst'=>'65', 'tipo'=>NULL,	'descricao'     =>'65: Créd. Presumido. Aquisição Vinc. a Rec. Não-Trib. Mercado Interno e Exportação']);
        CstPis::firstOrCreate(['cst'=>'66', 'tipo'=>NULL,	'descricao'     =>'66: Créd. Presumido. Aquisição Vinc. a Rec. Trib. e Não-Trib. Mercado Interno e Exportação']);
        CstPis::firstOrCreate(['cst'=>'67', 'tipo'=>NULL,	'descricao'     =>'67: Crédito Presumido - Outras Operações']);
        CstPis::firstOrCreate(['cst'=>'70', 'tipo'=>NULL,	'descricao'     =>'70: Operação de Aquisição sem Direito a Crédito']);
        CstPis::firstOrCreate(['cst'=>'71', 'tipo'=>NULL,	'descricao'     =>'71: Operação de Aquisição com Isenção']);
        CstPis::firstOrCreate(['cst'=>'72', 'tipo'=>NULL,	'descricao'     =>'72: Operação de Aquisição com Suspensão']);
        CstPis::firstOrCreate(['cst'=>'73', 'tipo'=>NULL,	'descricao'     =>'73: Operação de Aquisição a Alíquota Zero']);
        CstPis::firstOrCreate(['cst'=>'74', 'tipo'=>NULL,	'descricao'     =>'74: Operação de Aquisição sem Incidência da Contribuição']);
        CstPis::firstOrCreate(['cst'=>'75', 'tipo'=>NULL,	'descricao'     =>'75: Operação de Aquisição por Substituição Tributária']);
        CstPis::firstOrCreate(['cst'=>'98', 'tipo'=>NULL,	'descricao'     =>'98: Outras Operações de Entrada']);
        CstPis::firstOrCreate(['cst'=>'99', 'tipo'=>NULL,	'descricao'     =>'99: Outras operações']);    
    }
}
