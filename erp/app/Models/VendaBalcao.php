<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class VendaBalcao extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable = [
        'empresa_id', 'cliente_id', 'vendedor_id', 'usuario_id','data_venda','valor_venda','valor_frete','desconto_valor',
        'desconto_per', 'valor_desconto', 'valor_total_liquido', 'observacao'
    ];
    

    
    public function itens(){
        return $this->hasMany(ItemVenda::class, 'venda_id', 'id');
    }
}
