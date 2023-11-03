<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Duplicata extends Model
{
    use HasFactory;    
    protected $fillable = [
        'venda_id',
        'orcamento_id',
        'nDup',
        'tPag',
        'indPag',
        'dVenc',
        'vDup',
        'obs'
    ];
    
    public function venda(){
        return $this->belongsTo(Venda::class, 'venda_id');
    }
    
    public function orcamento(){
        return $this->belongsTo(Orcamento::class, 'orcamento_id');
    }
}
