<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogMercadoPago extends Model
{
    use HasFactory;
    protected $fillable = [
        'empresa_id', 'cliente_id','transacao','loja_pedido_id','pdv_venda_id','cobranca_id','fatura_id'
    ];
}
