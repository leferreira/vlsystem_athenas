<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;
use App\Models\SubMenu;

class MenuSeeder extends Seeder
{
    public function run()    {     
        $conf = Menu::create(['nome' => 'Configuração','cod'=>'menu_configuracao']);
            SubMenu::Create(['menu_id'=> $conf->id, 'cod'=>'submenu_meu_plano',"submenu"=>'Meu Plano']);
            SubMenu::Create(['menu_id'=> $conf->id, 'cod'=>'submenu_minha_empresa', "submenu"=>'Minha Empresa']);
            SubMenu::Create(['menu_id'=> $conf->id, 'cod'=>'submenu_parametro', "submenu"=>'Parâmetros do Sistema']);
            SubMenu::Create(['menu_id'=> $conf->id, 'cod'=>'submenu_emitente', "submenu"=>'Emitente NFE']);
            SubMenu::Create(['menu_id'=> $conf->id, 'cod'=>'submenu_natureza_operacao', "submenu"=>'Natureza Operação']);
            SubMenu::Create(['menu_id'=> $conf->id, 'cod'=>'submenu_certificado_digital', "submenu"=>'Certificado Digital']);
        $cad = Menu::create(['nome' => 'Cadastro','cod'=>'menu_cadastro']);
            SubMenu::Create(['menu_id'=> $cad->id, 'cod'=>'submenu_categoria', "submenu"=>'categoria']);
            SubMenu::Create(['menu_id'=> $cad->id, 'cod'=>'submenu_subcategoria', "submenu"=>'Subcategoria']);
            SubMenu::Create(['menu_id'=> $cad->id, 'cod'=>'submenu_subsubcategoria', "submenu"=>'SubSubcategoria']);
            SubMenu::Create(['menu_id'=> $cad->id, 'cod'=>'submenu_produto', "submenu"=>'Produto']);
            SubMenu::Create(['menu_id'=> $cad->id, 'cod'=>'submenu_cupom', "submenu"=>'Cupom Desconto']);
            SubMenu::Create(['menu_id'=> $cad->id, 'cod'=>'submenu_servico', "submenu"=>'Serviço']);
            SubMenu::Create(['menu_id'=> $cad->id, 'cod'=>'submenu_cliente', "submenu"=>'Cliente']);
            SubMenu::Create(['menu_id'=> $cad->id, 'cod'=>'submenu_tabela_preco', "submenu"=>'Tabela Preço']);
            SubMenu::Create(['menu_id'=> $cad->id, 'cod'=>'submenu_vendedor', "submenu"=>'Vendedor']);
            SubMenu::Create(['menu_id'=> $cad->id, 'cod'=>'submenu_varicao_grade', "submenu"=>'Variação Grade']);
            SubMenu::Create(['menu_id'=> $cad->id, 'cod'=>'submenu_item_variacao', "submenu"=>'Item Variação Grade']);
            SubMenu::Create(['menu_id'=> $cad->id, 'cod'=>'submenu_localizacao', "submenu"=>'Localização']);
            SubMenu::Create(['menu_id'=> $cad->id, 'cod'=>'submenu_fornecedor', "submenu"=>'Fornecedor']);
            SubMenu::Create(['menu_id'=> $cad->id, 'cod'=>'submenu_banco', "submenu"=>'Banco']);
            SubMenu::Create(['menu_id'=> $cad->id, 'cod'=>'submenu_conta_corrente', "submenu"=>'Conta  Corrente']);
            SubMenu::Create(['menu_id'=> $cad->id, 'cod'=>'submenu_transportadora', "submenu"=>'Transportadora']);
        $compra = Menu::create(['nome' => 'Compra','cod'=>'menu_compra']);
            SubMenu::Create(['menu_id'=> $compra->id, 'cod'=>'submenu_lista_compra', "submenu"=>'Lista Compras']);
            SubMenu::Create(['menu_id'=> $compra->id, 'cod'=>'submenu_compra_manual', "submenu"=>'Compra Manual']);
            SubMenu::Create(['menu_id'=> $compra->id, 'cod'=>'submenu_importar_nfe', "submenu"=>'Importar NFE']);
        $venda = Menu::create(['nome' => 'Venda','cod'=>'menu_venda']);
            SubMenu::Create(['menu_id'=> $venda->id, 'cod'=>'submenu_lista_venda', "submenu"=>'Lista Venda']);
            SubMenu::Create(['menu_id'=> $venda->id,'cod'=>'submenu_nova_venda',  "submenu"=>'Nova Venda']);
            SubMenu::Create(['menu_id'=> $venda->id, 'cod'=>'submenu_orcamento', "submenu"=>'Orçamento']);
        $os = Menu::create(['nome' => 'Ordem Servico','cod'=>'menu_os']);
            SubMenu::Create(['menu_id'=> $os->id, 'cod'=>'submenu_ordem_servico', "submenu"=>'Ordem Serviço']);
            SubMenu::Create(['menu_id'=> $os->id, 'cod'=>'submenu_tecnico', "submenu"=>'Técnico']);
            SubMenu::Create(['menu_id'=> $os->id, 'cod'=>'submenu_equipamento', "submenu"=>'Equipamentos']);
            SubMenu::Create(['menu_id'=> $os->id, 'cod'=>'submenu_termo_garantia', "submenu"=>'Termo Garantia']);
        $pedido = Menu::create(['nome' => 'Pedido Cliente','cod'=>'menu_pedido_cliente']);
            SubMenu::Create(['menu_id'=> $pedido->id,'cod'=>'submenu_lista_pedido',  "submenu"=>'lista']);
        $loja = Menu::create(['nome' => 'Loja Virtual','cod'=>'menu_loja_virtual']);
            SubMenu::Create(['menu_id'=> $loja->id, 'cod'=>'submenu_configuracao_loja', "submenu"=>'Configuração da Loja']);
            SubMenu::Create(['menu_id'=> $loja->id, 'cod'=>'submenu_pedidos_loja', "submenu"=>'Pedidos']);
            SubMenu::Create(['menu_id'=> $loja->id, 'cod'=>'submenu_banner_loja', "submenu"=>'Banner']);
        $estoque = Menu::create(['nome' => 'Estoque','cod'=>'menu_estoque']);
            SubMenu::Create(['menu_id'=> $estoque->id, 'cod'=>'submenu_entrada',"submenu"=>'Entrada Avulsa']);
            SubMenu::Create(['menu_id'=> $estoque->id, 'cod'=>'submenu_saida',"submenu"=>'Saída Avulsa']);
            SubMenu::Create(['menu_id'=> $estoque->id, 'cod'=>'submenu_estoque_atual',"submenu"=>'Estoques Atuais']);
            SubMenu::Create(['menu_id'=> $estoque->id, 'cod'=>'submenu_estoque_minimo',"submenu"=>'Estoque Mínimo']);
            SubMenu::Create(['menu_id'=> $estoque->id, 'cod'=>'submenu_vencimento',"submenu"=>'Controle de Vencimento']);
            SubMenu::Create(['menu_id'=> $estoque->id, 'cod'=>'submenu_historico_produto',"submenu"=>'Histórico Produto']);
        $nfe = Menu::create(['nome' => 'Notas Fiscais','cod'=>'menu_nfe']);
            SubMenu::Create(['menu_id'=> $nfe->id, 'cod'=>'submenu_nova_nfe',"submenu"=>'Nova Nfe']);
            SubMenu::Create(['menu_id'=> $nfe->id, 'cod'=>'submenu_lista_nfe',"submenu"=>'Lista Nfe']);
            SubMenu::Create(['menu_id'=> $nfe->id, 'cod'=>'submenu_importar_nfe',"submenu"=>'Importar NFE']);
            SubMenu::Create(['menu_id'=> $nfe->id, 'cod'=>'submenu_inutilizar_numeracao',"submenu"=>'Inutilizar Numeração']);
            SubMenu::Create(['menu_id'=> $nfe->id, 'cod'=>'submenu_lista_nfce',"submenu"=>'Lista NFCE']);
        $pdv = Menu::create(['nome' => 'Pdv','cod'=>'menu_pdv']);
            SubMenu::Create(['menu_id'=> $pdv->id, 'cod'=>'submenu_numero_pdv',"submenu"=>'Numero PDV']);
            SubMenu::Create(['menu_id'=> $pdv->id, 'cod'=>'submenu_caixa_pdv',"submenu"=>'Caixas']);
            SubMenu::Create(['menu_id'=> $pdv->id, 'cod'=>'submenu_sangria',"submenu"=>'Sangria']);
            SubMenu::Create(['menu_id'=> $pdv->id, 'cod'=>'submenu_suplemento',"submenu"=>'Suplemento']);
            SubMenu::Create(['menu_id'=> $pdv->id, 'cod'=>'submenu_venda_pdv',"submenu"=>'Venda']);
        $financeiro = Menu::create(['nome' => 'Financeiro','cod'=>'menu_financeiro']);
            SubMenu::Create(['menu_id'=> $financeiro->id, 'cod'=>'submenu_classificacao',"submenu"=>'Classificação Financeira']);
            SubMenu::Create(['menu_id'=> $financeiro->id, 'cod'=>'submenu_conta_pagar',"submenu"=>'Conta a Pagar']);
            SubMenu::Create(['menu_id'=> $financeiro->id, 'cod'=>'submenu_conta_receber',"submenu"=>'Conta a Receber']);
            SubMenu::Create(['menu_id'=> $financeiro->id, 'cod'=>'submenu_tipo_despesa',"submenu"=>'Tipo de Despesa']);
            SubMenu::Create(['menu_id'=> $financeiro->id, 'cod'=>'submenu_despesa',"submenu"=>'Despesas']);
            SubMenu::Create(['menu_id'=> $financeiro->id, 'cod'=>'submenu_fatura',"submenu"=>'Faturas']);
            SubMenu::Create(['menu_id'=> $financeiro->id, 'cod'=>'submenu_pagamento',"submenu"=>'Pagamentos']);
            SubMenu::Create(['menu_id'=> $financeiro->id, 'cod'=>'submenu_recebimento',"submenu"=>'Recebimentos']);
            SubMenu::Create(['menu_id'=> $financeiro->id, 'cod'=>'submenu_comprovante',"submenu"=>'Comprovantes']);
            SubMenu::Create(['menu_id'=> $financeiro->id, 'cod'=>'submenu_movimento_conta',"submenu"=>'Movimento Conta']);
            SubMenu::Create(['menu_id'=> $financeiro->id, 'cod'=>'submenu_extrato',"submenu"=>'Extrato']);
        
        $relatorio = Menu::create(['nome' => 'Relatorio','cod'=>'menu_relatorio']);
            SubMenu::Create(['menu_id'=> $relatorio->id, 'cod'=>'submenu_rel_produto',"submenu"=>'Relatório Produto']);
            SubMenu::Create(['menu_id'=> $relatorio->id, 'cod'=>'submenu_rel_venda',"submenu"=>'Relatório Venda']);
            SubMenu::Create(['menu_id'=> $relatorio->id, 'cod'=>'submenu_rel_estoque',"submenu"=>'Movimentação Estoque']);
            SubMenu::Create(['menu_id'=> $relatorio->id, 'cod'=>'submenu_rel_conta_receber',"submenu"=>'Relatório Conta Receber']);
            SubMenu::Create(['menu_id'=> $relatorio->id, 'cod'=>'submenu_rel_recebimento',"submenu"=>'Relatório Recebimentos']);
            SubMenu::Create(['menu_id'=> $relatorio->id, 'cod'=>'submenu_rel_conta_pagar',"submenu"=>'Relatório Conta a Pagar']);
            SubMenu::Create(['menu_id'=> $relatorio->id, 'cod'=>'submenu_rel_pagamento',"submenu"=>'Relatório Pagamentos']);
            SubMenu::Create(['menu_id'=> $relatorio->id, 'cod'=>'submenu_rel_movimento_conta',"submenu"=>'Relatório Movimento de Conta']);
            SubMenu::Create(['menu_id'=> $relatorio->id, 'cod'=>'submenu_rel_venda_pdv',"submenu"=>'Relatório Vendas PDV']);
            SubMenu::Create(['menu_id'=> $relatorio->id, 'cod'=>'submenu_rel_venda_loja_virtual',"submenu"=>'Relatório Vendas Loja Virtual']);
           
       
        print 'Todas as permissões do sistema foram criadas com sucesso!';
    }
}
