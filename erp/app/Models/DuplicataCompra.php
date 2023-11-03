<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DuplicataCompra extends Model
{
    use HasFactory;
    protected $fillable = [
        'compra_id',
        'nDup',
        'tPag',
        'indPag',
        'dVenc',
        'vDup',
        'obs'
    ];
    
    public function compra(){
        return $this->belongsTo(Compra::class, 'compra_id');
    }
    
}
