<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variacao extends Model{    
    use HasFactory;
    public $fillable = ['grade_id','variacao'];
    
    public function grade(){
        return $this->belongsTo(Grade::class);
    }
}
