<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Parametro extends Model
{
    use HasFactory;
    protected $fillable = [
        'empresa_id', 'num_casa_qtde', 'num_casa_preco', 'num_paginacao', 'baixar_estoque_venda', 'lancar_financeiro_venda', 
        'conta_bancaria_padrao', 'ambiente_nfe', 'numero_serie_nfe', 'ambiente_nfce', 'numero_serie_nfce', 
        'csc', 'csc_id', 'baixar_estoque_venda_balcao', 'baixar_estoque_venda_balcao', 'lancar_financeiro_venda_balcao', 
        'preco_venda_padrao_pdv', 'conta_bancaria_padrao_pdv', 'lancar_estoque_compra', 'lancar_financeiro_compra'
    ];
}
