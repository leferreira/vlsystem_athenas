<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NfeDuplicata extends Model
{
    use HasFactory;
    protected $fillable = [
        'nfe_id',
        'nDup',
        'tPag',
        'indPag',
        'dVenc',
        'vDup',
        'obs'
    ];
    
    public static function listaPorNfe($id_nfe){
        $lista = NfeDuplicata::where("nfe_id", $id_nfe)->get();
        $retorno = array();
        foreach ($lista as $c){
            $pagto              = FormaPagto::find($c->tPag); 
            $conta              = new \stdClass();
            $conta->id          = $c->id;
            $conta->nfe_id      = $c->nfe_id ;
            $conta->tPag        = $c->tPag;
            $conta->nDup        = $c->nDup;
            $conta->dVenc       = $c->dVenc;
            $conta->vDup        = $c->vDup;
            $conta->forma_pagto = $pagto->forma_pagto;  
            $retorno[]          = $conta;
        }
        
        return $retorno;
    }
}
