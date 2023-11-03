<?php
namespace App\Service;

class UsuarioService
{
    public static function is_adm(){
        $usr = session('user_logged');
        return $usr['adm'];
    }
    
    public static function get_id_user(){
        $usr = session('user_logged');
        return $usr['id'];
    }
    
    function __replace($valor){
        return str_replace(",", ".", $valor);
    }
    /*
    function __set($request){
        if($request->login == 'mjailton' && $request->senha == 'mjailton123'){
            $session = [
                'id' => 10,
                'nome' => 'Mjailton',
                'adm' => 1,
                'ambiente' => 1,
                'delivery' => 1,
                'acesso_cliente' => 1,
                'acesso_fornecedor' => 1,
                'acesso_produto' => 1,
                'acesso_financeiro' => 1,
                'acesso_caixa' => 1,
                'acesso_estoque' => 1,
                'acesso_compra' => 1,
                'acesso_fiscal' => 1
            ];
            session(['user_logged' => $session]);
            
        }
    }*/
}

