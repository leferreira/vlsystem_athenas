<?php

namespace Database\Seeders;

use App\Models\Permissao;
use Illuminate\Database\Seeder;

class PermissaoSeeder extends Seeder
{
    public function run()    {     
        $modulos    = config('permissoes.modulos');
        $acoes      = config('permissoes.acoes');
        foreach ($modulos as $modulo){
            foreach ($acoes as $acao){
                Permissao::firstOrCreate([
                    'permissao'=>"$modulo-$acao",
                    'descricao'=>"Permite o usuário $acao um(a) $modulo",
                    'tipo' =>'acao'
                ]);
            }
        }
       
        $menus   = config('permissoes.menus');
        foreach ($menus as $menu){
            Permissao::firstOrCreate([
                'permissao'=>"$menu",
                'descricao'=>"Permite o usuário abrir o menu $menu",
                'tipo' =>'menu'
            ]);
        }
        
        $submenus      = config('permissoes.submenus');
        foreach ($submenus as $submenu){
            Permissao::firstOrCreate([
                'permissao'=>"$submenu",
                'descricao'=>"Permite o usuário abrir o submenu $submenu",
                'tipo' =>'submenu'
            ]);
        }
        print 'Todas as permissões do sistema foram criadas com sucesso!';
    }
}
