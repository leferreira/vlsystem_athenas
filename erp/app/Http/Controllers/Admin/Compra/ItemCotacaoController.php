<?php

namespace App\Http\Controllers\Admin\Compra;

use App\Http\Controllers\Controller;
use App\Service\ItemCotacaoService;


class ItemCotacaoController extends Controller
{
    public function aprovar($item_cotacao_id, $cotacao_id){        
        ItemCotacaoService::aprovar($item_cotacao_id, $cotacao_id);
        return redirect()->route("cotacao.comparar", $cotacao_id);
    }
}
