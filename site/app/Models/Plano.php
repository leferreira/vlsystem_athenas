<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plano extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'valor' ];
    
   
    
    public function empresas()
    {
        return $this->hasMany(Empresa::class);
    }
    
    
    public function search($filter = null)
    {
        $results = $this->where('name', 'LIKE', "%{$filter}%")
        ->orWhere('description', 'LIKE', "%{$filter}%")
        ->paginate();
        
        return $results;
    }
    
    
}
