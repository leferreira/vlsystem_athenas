<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdvDuplicata extends Model
{
    use HasFactory;
    protected $fillable = [
        'venda_id',
        'nDup',
        'tPag',
        'indPag',
        'dVenc',
        'vDup',
        'obs'
    ];
    
    public function venda(){
        return $this->belongsTo(PdvVenda::class, 'pdvvenda_id');
    }
}
