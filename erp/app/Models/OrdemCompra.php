<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use App\Tenant\Traits\EmpresaTrait;

class OrdemCompra extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable = [
        "id",
        "empresa_id",
        "status_id",
        "usuario_id",
        "fornecedor_id",
        "cotacao_id",
        "data_emissao",
        "valor_total",
        "avulsa",
        "data_atendimento",
        "data_aprovacao"];
    
    public function status(){
        return $this->belongsTo(Status::class,"status_id","id");
    }
    
    public function fornecedor(){
        return $this->belongsTo(Fornecedor::class,"fornecedor_id","id");
    }
    
    public function cotacao(){
        return $this->belongsTo(Cotacao::class,"cotacao_id","id");
    }    
     
    public static function atualizaTotal($id_ordem){
        $total = ItemOrdemCompra::where("ordem_compra_id", $id_ordem)
        ->select(DB::raw('sum(item_ordem_compras.subtotal) as total'))->first();
        OrdemCompra::where("id",$id_ordem)->update(["valor_total"=>$total->total]);
    }
    
}
