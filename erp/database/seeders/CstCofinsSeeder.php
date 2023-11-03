<?php

namespace Database\Seeders;

use App\Models\CstCofins;
use Illuminate\Database\Seeder;

class CstCofinsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CstCofins::firstOrCreate(['cst'=>'01', 'tipo'=>'S', 'descricao'     => '01: Operação tributável Cfop::firstOrCreate( Operação alíq. normal Cfop::firstOrCreate(cumul./não cumul.)']);
        CstCofins::firstOrCreate(['cst'=>'02', 'tipo'=>'S', 'descricao'     => '02: Operação tributável Cfop::firstOrCreate(valor da operação Cfop::firstOrCreate(alíquota diferenciada)']);
        CstCofins::firstOrCreate(['cst'=>'03', 'tipo'=>'S', 'descricao'     => '03: Operação tributável Cfop::firstOrCreate(quant. x alíq. por unidade de produto)']);
        CstCofins::firstOrCreate(['cst'=>'04', 'tipo'=>'S', 'descricao'     => '04: Operação tributável Cfop::firstOrCreate(tributação monofásica, alíquota zero)']);
        CstCofins::firstOrCreate(['cst'=>'06', 'tipo'=>'S', 'descricao'     => '06: Operação tributável Cfop::firstOrCreate(alíquota zero)']);
        CstCofins::firstOrCreate(['cst'=>'07', 'tipo'=>'S', 'descricao'     => '07: Operação isenta da contribuição']);
        CstCofins::firstOrCreate(['cst'=>'08', 'tipo'=>'S', 'descricao'     => '08: Operação sem incidência da contribuição']);
        CstCofins::firstOrCreate(['cst'=>'09', 'tipo'=>'S', 'descricao'     => '09: Operação com suspensão da contribuição']);
        CstCofins::firstOrCreate(['cst'=>'49', 'tipo'=>'S', 'descricao'     => '49: Outras Operações de Saída']);
        CstCofins::firstOrCreate(['cst'=>'50', 'tipo'=>null, 'descricao'     => '50: Direito a Crédito. Vinculada Exclusivamente a Receita Tributada no Mercado Interno']);
        CstCofins::firstOrCreate(['cst'=>'51', 'tipo'=>null, 'descricao'     => '51: Direito a Crédito. Vinculada Exclusivamente a Receita Não Tributada no Mercado Interno']);
        CstCofins::firstOrCreate(['cst'=>'52', 'tipo'=>null, 'descricao'     => '52: Direito a Crédito. Vinculada Exclusivamente a Receita de Exportação']);
        CstCofins::firstOrCreate(['cst'=>'53', 'tipo'=>null, 'descricao'     => '53: Direito a Crédito. Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno']);
        CstCofins::firstOrCreate(['cst'=>'54', 'tipo'=>null, 'descricao'     => '54: Direito a Crédito. Vinculada a Receitas Tributadas no Mercado Interno e de Exportação']);
        CstCofins::firstOrCreate(['cst'=>'55', 'tipo'=>null, 'descricao'     => '55: Direito a Crédito. Vinculada a Receitas Não-Trib. no Mercado Interno e de Exportação']);
        CstCofins::firstOrCreate(['cst'=>'56', 'tipo'=>null, 'descricao'     => '56: Direito a Crédito. Vinculada a Rec. Trib. e Não-Trib. Mercado Interno e Exportação']);
        CstCofins::firstOrCreate(['cst'=>'60', 'tipo'=>null, 'descricao'     => '60: Créd. Presumido. Aquisição Vinc. Exclusivamente a Receita Tributada no Mercado Interno']);
        CstCofins::firstOrCreate(['cst'=>'61', 'tipo'=>null, 'descricao'     => '61: Créd. Presumido. Aquisição Vinc. Exclusivamente a Rec. Não-Trib. no Mercado Interno']);
        CstCofins::firstOrCreate(['cst'=>'62', 'tipo'=>null, 'descricao'     => '62: Créd. Presumido. Aquisição Vinc. Exclusivamente a Receita de Exportação']);
        CstCofins::firstOrCreate(['cst'=>'63', 'tipo'=>null, 'descricao'     => '63: Créd. Presumido. Aquisição Vinc. a Rec. Trib. e Não-Trib. no Mercado Interno']);
        CstCofins::firstOrCreate(['cst'=>'64', 'tipo'=>null, 'descricao'     => '64: Créd. Presumido. Aquisição Vinc. a Rec. Trib. no Mercado Interno e de Exportação']);
        CstCofins::firstOrCreate(['cst'=>'65', 'tipo'=>null, 'descricao'     => '65: Créd. Presumido. Aquisição Vinc. a Rec. Não-Trib. Mercado Interno e Exportação']);
        CstCofins::firstOrCreate(['cst'=>'66', 'tipo'=>null, 'descricao'     => '66: Créd. Presumido. Aquisição Vinc. a Rec. Trib. e Não-Trib. Mercado Interno e Exportação']);
        CstCofins::firstOrCreate(['cst'=>'67', 'tipo'=>null, 'descricao'     => '67: Crédito Presumido - Outras Operações']);
        CstCofins::firstOrCreate(['cst'=>'70', 'tipo'=>null, 'descricao'     => '70: Operação de Aquisição sem Direito a Crédito']);
        CstCofins::firstOrCreate(['cst'=>'71', 'tipo'=>null, 'descricao'     => '71: Operação de Aquisição com Isenção']);
        CstCofins::firstOrCreate(['cst'=>'72', 'tipo'=>null, 'descricao'     => '72: Operação de Aquisição com Suspensão']);
        CstCofins::firstOrCreate(['cst'=>'73', 'tipo'=>null, 'descricao'     => '73: Operação de Aquisição a Alíquota Zero']);
        CstCofins::firstOrCreate(['cst'=>'74', 'tipo'=>null, 'descricao'     => '74: Operação de Aquisição sem Incidência da Contribuição']);
        CstCofins::firstOrCreate(['cst'=>'75', 'tipo'=>null, 'descricao'     => '75: Operação de Aquisição por Substituição Tributária']);
        CstCofins::firstOrCreate(['cst'=>'98', 'tipo'=>null, 'descricao'     => '98: Outras Operações de Entrada']);
        CstCofins::firstOrCreate(['cst'=>'99', 'tipo'=>null, 'descricao'     => '99: Outras operações']);
    }
}
