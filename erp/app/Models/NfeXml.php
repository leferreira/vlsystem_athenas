<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class NfeXml extends Model
{
    use HasFactory, EmpresaTrait;
    protected  $fillable= [
        'nfe_id',
        'empresa_id',
        'chave',
        'xml',
    ];
    
    public function nfe(){
        return $this->belongsTo(Nfe::class, 'nfe_id');
    }
}
