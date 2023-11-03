<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BandeiraAdministradora extends Model
{
    use HasFactory;
    protected $fillable = [
        'descricao','administradora_cartao_id', "bandeira_id","tipo_parcelamento_id",'forma_pagto_id'
    ];
    
    public function administradora(){
        return $this->belongsTo(AdministradoraCartao::class, 'administradora_cartao_id');
    }
    
    public function bandeira(){
        return $this->belongsTo(Bandeira::class, 'bandeira_id');
    }
    
    public function tipo(){
        return $this->belongsTo(TipoParcelamento::class, 'tipo_parcelamento_id');
    }
    
    public function forma_pagto(){
        return $this->belongsTo(FormaPagto::class, 'forma_pagto_id');
    }
}
