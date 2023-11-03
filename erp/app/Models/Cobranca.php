<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cobranca extends Model
{
    use HasFactory;
    protected $fillable = [
        'venda_recorrente_id', 'descricao','cliente_id', 'status_id', 'valor', 'data_cadastro','data_vencimento',
        'data_pagamento','status_financeiro_id','fin_recebimentos','uuid','obs','num_parcela','ult_parcela'
    ];
    
    public function venda(){
        return $this->belongsTo(VendaRecorrente::class, 'venda_recorrente_id');
    }
    public function cliente(){
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
       
    
    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }
    
    public function status_financeiro(){
        return $this->belongsTo(Status::class, 'status_financeiro_id');
    }
}
