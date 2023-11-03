<?php
namespace App\Service;

use App\Models\Emitente;
use App\Models\Empresa;
use App\Models\Parametro;
use App\Models\PlanoPreco;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\CertificadoDigital;

class SiteService{
    public static function cadastrar($req){     
        $plano = PlanoPreco::first();
        
        // Cria uma empresa
        $empresa = Empresa::Create([
            "plano_preco_id"    =>$plano->id,
            "razao_social"      =>$req["empresa"],
            "fone"              =>tira_mascara($req["celular"]),
            "email"             =>$req["email"],
            "pasta"             =>Str::uuid() ,
            "forma_pagto_id"    =>config('constantes.status.DEPOSITO_BANCARIO'),
            "data_aquisicao"    =>hoje(),
            "valor_contrato"    =>0,
            "data_vencimento"   =>somarData(hoje(),15),
            "data_inicial_vencimento"=>hoje(),
            "valor_recorrente"  =>0,
            "dias_bloqueia"     =>0,
            "status_id"         =>config("constantes.status.PROSPECTO"),
            "status_plano_id"   =>config("constantes.status.PLANO_DEMO")
        ]);       
        // Cria um usuario
        $usuario = new \stdClass();
        $usuario->empresa_id=$empresa->id;
        $usuario->name      =$req["nome"];
        $usuario->email     =$req["email"];
        $usuario->password  =bcrypt($req["senha"]);
        $usuario->telefone  =$req["celular"];
        $usuario->status_id =config("constantes.status.ATIVO");
       
       
        User::Create(objToArray($usuario));
        
        //Criando a tabela de parâmetros da empresa
        $parametro = new \stdClass();
        $parametro->empresa_id  = $empresa->id;
        Parametro::Create(objToArray($parametro));
        
        //Criando a tabela de emitente da empresa
        
        
       $emitente =  new \stdClass(); 
       $emitente->empresa_id         = $empresa->id;
       $emitente->nat_op_padrao_nfce = "Venda de Mercadoria";
       $emitente->nat_op_padrao_nfe  = "Venda de Mercadoria";            

       $emit =Emitente::Create(objToArray($emitente));
        
       $certificado = new \stdClass();
       $certificado->empresa_id       = $empresa->id;
       $certificado->emitente_id      = $emit->id;
            
       CertificadoDigital::Create(objToArray($certificado));
    }
}

