<?php
namespace App\Service;

use App\Models\CertificadoDigital;
use App\Models\Emitente;
use App\Models\Empresa;
use App\Models\Parametro;
use App\Models\PlanoPreco;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Funcao;
use App\Models\ClassificacaoFinanceiraModel;
use App\Models\ClassificacaoFinanceira;
use App\Models\LojaConfiguracao;
use App\Models\ContaCorrente;
use App\Models\Cliente;
use App\Models\TabelaPreco;
use App\Models\Assinatura;

class SiteService{
    public static function cadastrar($req){
        $planopreco = PlanoPreco::find($req["plano_preco_id"]);        
        // Cria uma empresa
        $empresa = Empresa::Create([            
            "razao_social"      =>$req["empresa"],
            "fone"              =>tira_mascara($req["celular"]),
            "email"             =>$req["email"],
            "pasta"             =>Str::uuid() ,
            "uuid"              =>Str::uuid() ,         
            "status_id"         =>config("constantes.status.PROSPECTO"),
            
        ]);
        
        // Cria um usuario
        $usuario            = new \stdClass();
        $usuario->empresa_id=$empresa->id;
        $usuario->uuid      =Str::uuid() ;
        $usuario->name      =$req["nome"];
        $usuario->email     =$req["email"];
        $usuario->password  =bcrypt($req["senha"]);
        $usuario->telefone  =$req["celular"];
        $usuario->eh_admin  ="S";
        $usuario->status_id =config("constantes.status.ATIVO");       
        
        User::Create(objToArray($usuario));
        
        
        // Cria Assinatura
        $assinatura                     = new \stdClass();
        $assinatura->empresa_id         = $empresa->id;
        $assinatura->plano_preco_id     = $planopreco->id;
        $assinatura->status_id          = config("constantes.status.ATIVO");
        $assinatura->data_aquisicao     = hoje();
        $assinatura->valor_contrato     = 0;
        $assinatura->eh_teste           = "S";
        $assinatura->valor_recorrente   = 0;
        $assinatura->bloqueado_pelo_gestor   = "N";
        $assinatura->liberado_pelo_gestor   = "N";
        $assinatura->dias_bloqueia      =  0;
        Assinatura::Create(objToArray($assinatura));
        
        
        //Criando a tabela de parâmetros da empresa
        $parametro = new \stdClass();
        $parametro->empresa_id          = $empresa->id;
        $parametro->margem_lucro        = 30;
        $parametro->num_casas_decimais  = 2;
        Parametro::Create(objToArray($parametro));
        
        
        
        
        //Criando a tabela de parâmetros da empresa
        $loja = new \stdClass();
        $loja->empresa_id  = $empresa->id;
        LojaConfiguracao::Create(objToArray($loja));
        
        //Criando a tabela de emitente da empresa        
        
        //Criando o Cliente Consumidor
        
        $consumidor = new \stdClass();
        $consumidor->empresa_id         = $empresa->id;
        $consumidor->tipo_cliente       = "F";
        $consumidor->eh_consumidor      = "S";
        $consumidor->cpf_cnpj           = "11111111111";
        $consumidor->nome_razao_social  = "CLIENTE CONSUMIDOR";
        $consumidor->indFinal           = "1";
        $consumidor->logradouro         = "logradouro";
        $consumidor->numero           = "123";
        $consumidor->bairro           = "Bairro";
        $consumidor->uf             = "UF";
        $consumidor->status_id           = config("constantes.status.ATIVO");
        $cliente = Cliente::Create(objToArray($consumidor));
        
        $emitente                     =  new \stdClass();
        $emitente->empresa_id         = $empresa->id;   
        $emitente->cliente_consumidor = $cliente->id;
        $emit                         = Emitente::Create(objToArray($emitente));
        
        $certificado                  = new \stdClass();
        $certificado->empresa_id      = $empresa->id;
        $certificado->emitente_id     = $emit->id;        
        CertificadoDigital::Create(objToArray($certificado));
        
        
        $lista                      = ClassificacaoFinanceiraModel::get();
        foreach($lista as $classificacao){
            $nova_classificacao                 = new ClassificacaoFinanceira();
            $nova_classificacao->empresa_id     = $empresa->id;
            $nova_classificacao->codigo         = $classificacao->codigo;
            $nova_classificacao->descricao      = $classificacao->descricao;
            $nova_classificacao->titulo_grupo   = $classificacao->titulo_grupo;
            $nova_classificacao->ativo          = $classificacao->ativo;
            $nova_classificacao->receita_despesa= $classificacao->receita_despesa;
            $nova_classificacao->save();
        }
        
        
        $conta = new \stdClass();
        $conta->banco_id = 1;
        $conta->empresa_id = $empresa->id; 
        $conta->tipo_conta_corrente_id  = 3;
        $conta->descricao = "Conta Caixa" ;
        $conta->agencia = "000";
        $conta->conta = "0000";
        $conta->pix = "0000";
        
        ContaCorrente::Create(objToArray($conta));
        
        $preco = new \stdClass();
        $preco->empresa_id = $empresa->id;
        $preco->nome    = "Tabela Principal";
        $preco->padrao  = "S";
        TabelaPreco::Create(objToArray($preco));
        
        
    }
    
    
}

