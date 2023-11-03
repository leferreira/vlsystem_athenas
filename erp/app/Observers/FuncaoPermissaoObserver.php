<?php

namespace App\Observers;

use App\Models\Categoria;
use Str;
use App\Models\FuncaoPermissao;
use App\Models\Permissao;
use App\Models\Menu;

class FuncaoPermissaoObserver
{
    public function created(FuncaoPermissao $funcaopermissao)
    {
        if($funcaopermissao->submenu_id){
            
        }
    }
    
    public function deleted(Categoria $categoria)
    {
        $categoria->url = Str::kebab($categoria->categoria);
    }
}
