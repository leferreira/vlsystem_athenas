<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\EmpresaTrait;

class VendaRecorrente extends Model
{
    use HasFactory, EmpresaTrait;
    protected $fillable = [
        'empresa_id', 'produto_recorrente_id', 'vendedor_id', 'cliente_id', 'tipo_cobranca_id','status_id','modelo_contrato_id',
        'status_financeiro_id','valor_total','valor_primeira_parcela','valor_recorrente','data_contrato','primeiro_vencimento',
        'duracao','data_inicio', 'data_fim','qtde_recorrencia','total_desconto','valor_liquido','valor_total'
    ];
    
    public function itens(){
        return $this->hasMany(ItemVendaRecorrente::class, 'venda_recorrente_id', 'id');
    }    
    public function empresa(){
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
    public function cliente(){
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
    
    public function modeloContrato(){
        return $this->belongsTo(ModeloContrato::class, 'modelo_contrato_id');
    }
    
    public function vendedor(){
        return $this->belongsTo(Vendedor::class, 'vendedor_id');
    }
    
    public function produto(){
        return $this->belongsTo(ProdutoRecorrente::class, 'produto_recorrente_id');
    }
    
    public function cobrancas(){
        return $this->hasMany(Cobranca::class, 'venda_recorrente_id', 'id');
    }
    
    public function tipoCobranca(){
        return $this->belongsTo(TipoCobranca::class, 'tipo_cobranca_id');
    }
    
    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }
    
    public function status_financeiro(){
        return $this->belongsTo(Status::class, 'status_financeiro_id');
    }
    
    public static function somarTotal($id){
        $venda          = VendaRecorrente::find($id);
        $total_venda    = ItemVendaRecorrente::where("venda_recorrente_id", $id)->sum("subtotal");
        $total_desconto = ItemVendaRecorrente::where("venda_recorrente_id", $id)->sum("total_desconto_item");
        $total_liquido  = ItemVendaRecorrente::where("venda_recorrente_id", $id)->sum("subtotal_liquido");
       
        
        $venda->valor_total = $total_venda;
        $venda->total_desconto = $total_desconto;
        $venda->valor_liquido = $total_liquido;
        if($venda->valor_recorrente <=0){
            $venda->valor_recorrente = getFloat($venda->valor_liquido/12);
        }else{
            $venda->valor_recorrente = getFloat($venda->valor_liquido/$venda->qtde_recorrencia);
        }
        $venda->save();
    }
    
    public static function dadosContrato($venda_id){
        $venda        = VendaRecorrente::find($venda_id); 
        $array_chaves = array();
        $array_campos = array();
        $array_valor  = array();
        $empresa = Empresa::find($venda->empresa_id);
        $cliente = $venda->cliente;
        $dicionarios=  TabelaDicionario::lista();
        
        foreach ($dicionarios as $d){            
            if($d->tabela=="empresa"){
                foreach($d->itens as $item){
                    $array_chaves[] = $item->chave;
                    $array_campos[] = $item->campo;
                    $campo = $item->campo ;
                    $array_valor[]  = $empresa->$campo;
                }
            }            
            if($d->tabela=="cliente"){
                foreach($d->itens as $item){
                    $array_chaves[] = $item->chave;
                    $array_campos[] = $item->campo;
                    $campo = $item->campo ;
                    $array_valor[]  = $cliente->$campo;
                }
            }            
            if($d->tabela=="contrato"){
                foreach($d->itens as $item){
                    $array_chaves[] = $item->chave;
                    $array_campos[] = $item->campo;
                    $campo = $item->campo ;
                    $array_valor[]  = $venda->$campo;
                }
            }
            
        }
        
        $retorno = new \stdClass();
        $retorno->chaves = $array_chaves;
        $retorno->campos = $array_campos;
        $retorno->valor  = $array_valor;
        
        return $retorno;
    }
}
