<?php

namespace App\Http\Controllers\Admin\Relatorio;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use Dompdf\Dompdf;

class RelProdutoController extends Controller
{   
    
    public function lista(){
        $dados["usuario"]   = auth()->user();
        $dados["lista"]     = Produto::get();
        
        $p = view('Admin.Relatorios.Produto.ListaProduto', $dados);
        
        $domPdf = new Dompdf(["enable_remote" => true]);
        $domPdf->loadHtml($p);        
        $pdf = ob_get_clean();        
        $domPdf->setPaper("A4");
        $domPdf->render();
        $domPdf->stream("arqivo.pdf",["Attachment"=>false]);
    }
    
    
    
    
  
}
