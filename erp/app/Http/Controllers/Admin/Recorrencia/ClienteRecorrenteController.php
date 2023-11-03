<?php

namespace App\Http\Controllers\Admin\Recorrencia;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Cobranca;
use App\Models\ItemProdutoRecorrente;
use App\Models\Produto;
use App\Models\ProdutoRecorrente;
use App\Models\VendaRecorrente;

class ClienteRecorrenteController extends Controller{    
    
    public function index(){     
      
        $dados["lista"]             = VendaRecorrente::select('cliente_id')->distinct()->get();
        return view("Admin.Recorrencia.Cliente.Index", $dados);
        
    }
    
    public function cobrancas($cliente_id){  
        $dados["cliente"]           = Cliente::find($cliente_id);
        $dados["vendas"]             = VendaRecorrente::where("cliente_id", $cliente_id)->get();       
        return view("Admin.Recorrencia.Cliente.Cobrancas", $dados);
    }    
    
    public function edit($id){
        $dados["produtorecorrente"]       = ProdutoRecorrente::find($id); 
        $dados["produtos"]                = Produto::where("tipo_produto_id", config("constantes.tipo_produto.PRODUTO"))->get();
        $dados["servicos"]                = Produto::where("tipo_produto_id", config("constantes.tipo_produto.SERVICO"))->get();
        
        $dados["lista_produtos"]          = ItemProdutoRecorrente::where("produto_id", "!=", Null)->where("produto_recorrente_id", $id)->get();
        $dados["lista_servicos"]          = ItemProdutoRecorrente::where("servico_id", "!=", Null)->where("produto_recorrente_id", $id)->get();   
        $dados["servicoJs"]               = true;
        $dados["produtoJs"]               = true;
        $dados["produtoRecorrenteJs"]     = true;
        return view("Admin.Recorrencia.ProdutoRecorrente.Edit", $dados);
    }

    
}
