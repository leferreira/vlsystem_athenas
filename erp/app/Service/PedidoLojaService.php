<?php
namespace App\Service;

use App\Models\Cidade;
use App\Models\Cliente;
use App\Models\Frete;

class PedidoLojaService{
    public static function salvarCliente($pedido){
        $cliente        = $pedido->cliente;
        $endereco       = $pedido->endereco;
        
        $clienteExist   = Cliente::where('cpf_cnpj', $cliente->cpf)->first();        
        $cidade         = Cidade::where('nome', $endereco->cidade)->first();
        
        if($clienteExist == null){
            //criar novo
            
            $dataCliente = [
                'razao_social'  => "$cliente->nome $cliente->sobre_nome",
                'nome_fantasia' => "$cliente->nome $cliente->sobre_nome",
                'bairro'        => $endereco->bairro,
                'numero'        => $endereco->numero,
                'rua'           => $endereco->rua,
                'cpf_cnpj'      => $cliente->cpf,
                'telefone'      => $cliente->telefone,
                'celular'       => $cliente->telefone,
                'email'         => $cliente->email,
                'cep'           => $endereco->cep,
                'ie_rg'         => '',
                'consumidor_final' => 1,
                'limite_venda'  => 0,
                'cidade_id'     => $cidade->id,
                'contribuinte'  => 1,
                'rua_cobranca'  => '',
                'numero_cobranca' => '',
                'bairro_cobranca' => '',
                'cep_cobranca'  => '',
                'cidade_cobranca_id' => NULL,
                'cod_pais'      => 1058,
                'id_estrangeiro' => '',
                'grupo_id'      => 0
            ];
            
            print_r($dataCliente);
            
            return Cliente::create($dataCliente);
            
        }else{
            //atualiza endereço
            
            $clienteExist->rua      = $endereco->rua;
            $clienteExist->numero   = $endereco->numero;
            $clienteExist->bairro   = $endereco->bairro;
            $clienteExist->cep      = $endereco->cep;
            $clienteExist->cidade_id = $cidade->id;
            
            $clienteExist->save();
            return $clienteExist;
        }
    }
    
    public static function criaFrete($request){        
        $frete = null;        
        if($request->frete != '9'){
            $frete = Frete::create([
                'placa'     => $request->placa ?? '',
                'valor'     => $request->valor_frete,
                'tipo'      => $request->frete,
                'qtdVolumes'=> $request->qtd_volumes ?? 0,
                'uf'        => $request->uf_placa ?? '',
                'numeracaoVolumes' => $request->numeracao_volumes ?? 0,
                'especie'       => $request->especie ?? '',
                'peso_liquido'  => $request->peso_liquido,
                'peso_bruto'    => $request->peso_bruto
            ]);
        }
        
        return $frete;
    }
}

