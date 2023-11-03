<?php

namespace App\Http\Controllers;


use App\Service\ProdutoService;
use Illuminate\Routing\Controller;

class ProdutoController extends Controller
{
    public function pesquisa(){
        $q          = $_GET["q"];
        $produtos   = ProdutoService::pesquisaPorNome($q);
        return response()->json($produtos);
    }
}
