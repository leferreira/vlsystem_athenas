<?php

namespace App\Http\Controllers\Admin\LojaVirtual;

use App\Http\Controllers\Controller;
use App\Service\TesteService;

class LojaTesteController extends Controller
{
    
    public function gerar(){
        TesteService::gerarLoja();
        return redirect()->route('admin.index')->with("msg_sucesso", "Banco gerado");
    }

    
    
}
