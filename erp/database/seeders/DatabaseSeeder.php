<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoProduto;
use App\Models\Fornecedor;
use App\Models\OperadoraCartao;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            
            StatusSeeder::class,
            StatusEntregaSeedr::class,
            BandeiraSeeder::class,
            UnidadeSeeder::class,
            PlanoSeeder::class,
            PlanoPrecoSeeder::class,
            FormaPagtoSeeder::class,
            GestaoGestorSeeder::class,
            EmpresaSeeder::class,
            FornecedorSeeder::class,
            BancoSeeder::class,
            UserSeeder::class,
            TipoProdutoSeeder::class,
            TipoCobrancaSeeder::class,
            ClassificacaoFinanceiraModeloSeeder::class,
            TabelaDicionarioSeeder::class,
            
            ModuloSeeder::class,
            // FuncaoSeeder::class,
            PlanoModuloSeeder::class,
            PermissaoSeeder::class,
            
            
            TipoDespesaSeeder::class,
            TipoMovimentoSeeder::class,
            TipoNfeSeed::class,
            TipoContaCorrenteSeeder::class,
            
            
            EstadoSeeder::class,
            CfopSeeder::class,
            CstCofinsSeeder::class,
            CstIcmsSeeder::class,
            CstIpiSeeder::class,
            CstPisSeeder::class,
            
            TipoContribuinteSeeder::class,
            IcmsEstadoSeeder::class,
            MenuSeeder::class,
            OperadoraCartaoSeeder::class,
            TipoParcelamentoSeeder::class,
            
            
        ]);
    }
}
