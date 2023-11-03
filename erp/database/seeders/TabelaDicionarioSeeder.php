<?php

namespace Database\Seeders;

use App\Models\TabelaDicionario;
use Illuminate\Database\Seeder;

class TabelaDicionarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TabelaDicionario::Create(['tabela' =>'empresa', 'campo' => 'razao_social', "chave"=>'[emp_razao_social]']);
        TabelaDicionario::Create(['tabela' =>'empresa', 'campo' => 'cpf_cnpj', "chave"=>'[emp_cpf_cnpj]']);
        TabelaDicionario::Create(['tabela' =>'empresa', 'campo' => 'ie', "chave"=>'[emp_inscricao_estadual]']);
        TabelaDicionario::Create(['tabela' =>'empresa', 'campo' => 'logradouro', "chave"=>'[emp_endereco]']);
        TabelaDicionario::Create(['tabela' =>'empresa', 'campo' => 'numero', "chave"=>'[emp_numero]']);
        TabelaDicionario::Create(['tabela' =>'empresa', 'campo' => 'bairro', "chave"=>'[emp_bairro]']);
        TabelaDicionario::Create(['tabela' =>'empresa', 'campo' => 'cep', "chave"=>'[emp_cep]']);
        TabelaDicionario::Create(['tabela' =>'empresa', 'campo' => 'uf', "chave"=>'[emp_uf]']);
        TabelaDicionario::Create(['tabela' =>'empresa', 'campo' => 'estado', "chave"=>'[emp_estado]']);
        TabelaDicionario::Create(['tabela' =>'empresa', 'campo' => 'cidade', "chave"=>'[emp_cidade]']);
        TabelaDicionario::Create(['tabela' =>'empresa', 'campo' => 'email', "chave"=>'[emp_email]']);
        TabelaDicionario::Create(['tabela' =>'empresa', 'campo' => 'representante', "chave"=>'[emp_representante]']);
        
        TabelaDicionario::Create(['tabela' =>'cliente', 'campo' => 'nome_razao_social', "chave"=>'[cli_razao_social]']);
        TabelaDicionario::Create(['tabela' =>'cliente', 'campo' => 'nome_fantasia', "chave"=>'[cli_nome_fantasia]']);
        TabelaDicionario::Create(['tabela' =>'cliente', 'campo' => 'cpf_cnpj', "chave"=>'[cli_cpf_cnpj]']);
        TabelaDicionario::Create(['tabela' =>'cliente', 'campo' => 'rg_ie', "chave"=>'[cli_inscricao_estadual]']);
        TabelaDicionario::Create(['tabela' =>'cliente', 'campo' => 'representante', "chave"=>'[cli_representante]']);
        TabelaDicionario::Create(['tabela' =>'cliente', 'campo' => 'cep', "chave"=>'[cli_cep]']);
        TabelaDicionario::Create(['tabela' =>'cliente', 'campo' => 'logradouro', "chave"=>'[cli_endereco]']);
        TabelaDicionario::Create(['tabela' =>'cliente', 'campo' => 'numero', "chave"=>'[cli_numero]']);
        TabelaDicionario::Create(['tabela' =>'cliente', 'campo' => 'bairro', "chave"=>'[cli_bairro]']);
        TabelaDicionario::Create(['tabela' =>'cliente', 'campo' => 'uf', "chave"=>'[cli_uf]']);
        TabelaDicionario::Create(['tabela' =>'cliente', 'campo' => 'cidade', "chave"=>'[cli_cidade]']);
        TabelaDicionario::Create(['tabela' =>'cliente', 'campo' => 'email', "chave"=>'[cli_email]']);
        
        TabelaDicionario::Create(['tabela' =>'contrato', 'campo' => 'data_inicio', "chave"=>'[cont_data_ini]']);
        TabelaDicionario::Create(['tabela' =>'contrato', 'campo' => 'data_fim', "chave"=>'[cont_data_fim]']);
        TabelaDicionario::Create(['tabela' =>'contrato', 'campo' => 'data_extenso', "chave"=>'[cont_data_contrato_extenso]']);
        TabelaDicionario::Create(['tabela' =>'contrato', 'campo' => 'valor_total', "chave"=>'[cont_total_bruto]']);
        TabelaDicionario::Create(['tabela' =>'contrato', 'campo' => 'total_desconto', "chave"=>'[cont_desconto]']);
        TabelaDicionario::Create(['tabela' =>'contrato', 'campo' => 'valor_liquido', "chave"=>'[cont_total_pagar]']);
        TabelaDicionario::Create(['tabela' =>'contrato', 'campo' => 'total_extenso', "chave"=>'[cont_total_pagar_extenso]']);
        TabelaDicionario::Create(['tabela' =>'contrato', 'campo' => 'qtde_recorrencia', "chave"=>'[cont_num_parcelas]']);
        TabelaDicionario::Create(['tabela' =>'contrato', 'campo' => 'valor_recorrente', "chave"=>'[cont_valor_parcelas]']);
        TabelaDicionario::Create(['tabela' =>'contrato', 'campo' => 'valor_recorrente_extenso', "chave"=>'[cont_valor_parcelas_extenso]']);
        TabelaDicionario::Create(['tabela' =>'contrato', 'campo' => 'valor_parcela_sem_desconto', "chave"=>'[cont_valor_parcelas_sem_desconto]']);
        
        /*TabelaDicionario::Create(['tabela' =>'contrato', 'campo' => '', "chave"=>'[cont_forma_pagamento]']);
        TabelaDicionario::Create(['tabela' =>'contrato', 'campo' => '', "chave"=>'[cont_detalhe_servicos]']);
        TabelaDicionario::Create(['tabela' =>'contrato', 'campo' => '', "chave"=>'[cont_entrada]']);
        TabelaDicionario::Create(['tabela' =>'contrato', 'campo' => '', "chave"=>'[cont_dia_vencimento]']);
        TabelaDicionario::Create(['tabela' =>'contrato', 'campo' => '', "chave"=>'[cont_data_ini_cobranca]']);*/
        TabelaDicionario::Create(['tabela' =>'contrato', 'campo' => 'id', "chave"=>'[cont_id]']);
        
        
        
    }
}
