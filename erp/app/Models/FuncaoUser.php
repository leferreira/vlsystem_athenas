<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuncaoUser extends Model
{
    use HasFactory;
    protected $table = 'funcao_user';
    public $fillable = ['funcao_id','user_id'];
    
    public function funcao(){
        return $this->belongsTo(Funcao::class, 'funcao_id');
    }
    
    public function usuario(){
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
