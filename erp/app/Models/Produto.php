<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Tenant\Traits\EmpresaTrait;


class Produto extends Model
{
    use EmpresaTrait;
    
    protected $fillable =[
        'empresa_id',
        'tipo_produto_id',
        'localizacao_id',
        'fornecedor_nota_id', 
        'usa_grade',
        'sku',
        'nome',
       'CEST',
        'gtin',        
        'sku',
        'codigo_barra',
        'gtin_trib',
        'imagem',
        'origem',
        'categoria_id',
        'subcategoria_id',
        'subsubcategoria_id',
        'unidade',
        'unidade_entrada',
        'valor_venda_atacado',
        'valor_atacado_apartir',
        'comissao',
        'fragmentacao_qtde',
        'fragmentacao_unidade',
        'fragmentacao_valor',
        'referencia',
        'qtde_venda',
        'valor_venda_atacado',
        'valor_atacado_apartir',
        'comissao',
        'validade',
        'ultima_compra',
        'valor_maior',
        'valor_venda',
        'valor_custo',
        'margem_lucro',
        'custo_medio',
        'estoque_minimo',
        'estoque_maximo',
        'estoque_inicial',
        'estoque_atual',
        'cfop',
        'pDif',
        'pMVAST',
        'pICMS',
        'pPIS',
        'pCOFINS',
        'pIPI',
        'pRedBC',
        'pRedBCST',
        'ncm',
        'cest',
        'cbenef',
        'tipi',
        'unidade_tributavel',
        'quantidade_tributavel',
        'produto_loja', 
        'produto_delivery',
        'descricao', 
        'controlar_estoque', 'status_id',
        'preco', 'destaque', 'cep', 'largura','comprimento','altura','peso_liquido','peso_bruto',
        'tributado_icms','tributado_ipi','tributado_pis','tributado_cofins','pRedBC',
        ];
    
  
    public function empresa(){
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
    
    public function estoque(){
        return $this->hasOne(Estoque::class, 'produto_id', 'id');
    }
    
    public function grade(){
        return $this->hasMany(GradeProduto::class, 'produto_id', 'id');
    }
    
    public function tributacao(){
        return $this->belongsTo(Tributacao::class, 'tributacao_id');
    }
    
    public function categoria(){
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
    
    public function subcategoria(){
        return $this->belongsTo(SubCategoria::class, 'subcategoria_id');
    }
    
    public function galeria(){
        return $this->hasMany(LojaImagemProduto::class , 'produto_id', 'id');
    }
    
    public function adicionais(){
        return $this->hasMany(ListaComplementoDelivery::class, 'produto_id', 'id');
    }
    
    public function pizza(){
        return $this->hasMany(ProdutoPizza, 'produto_id', 'id');
    }
    
    public function subsubcategoria(){
        return $this->belongsTo(SubSubCategoria::class, 'subsubcategoria_id');
    }
    public static function filtro($filtro, $paginas=0){
        $retorno = Produto::where('produtos.tipo_produto_id', $filtro->tipo);
        
        if($filtro->nome){
            $retorno->where("nome", "like", '%'. $filtro->nome .'%');
        }
               
        
        if($filtro->categoria_id){
            $retorno->where("categoria_id", $filtro->categoria_id);
        }
        
        if($paginas > 0){
            $retorno = $retorno->paginate($paginas);
        }else{
            $retorno = $retorno->get();
        }
            
        return $retorno;
    }
    
    public static function consulta($filtro){
        $retorno = Produto::orderBy($filtro->ordem, $filtro->tipo_ordem);
     
                
        if($filtro->valor){
            if($filtro->operador=="igual"){
                $retorno->where($filtro->campo,  $filtro->valor);
            }else if($filtro->operador=="diferente"){
                $retorno->where($filtro->campo, "!=",  $filtro->valor);
            }else if($filtro->operador=="maior"){
                $retorno->where($filtro->campo, ">",  $filtro->valor);
            }else if($filtro->operador=="menor"){
                $retorno->where($filtro->campo, "<",  $filtro->valor);
            }else if($filtro->operador=="maior_igual"){
                $retorno->where($filtro->campo, ">=", $filtro->valor);
            }else if($filtro->operador=="menor_igual"){
                $retorno->where($filtro->campo, "<=",  $filtro->valor);
            }else if($filtro->operador=="like"){
                $retorno->where($filtro->campo, "like", "%$filtro->valor%");
            }else {
                $retorno->where($filtro->campo,  $filtro->valor);
            }
            
        }        
        
        if($filtro->fornecedor_nota_id){
            $retorno->where("fornecedor_nota_id", $filtro->fornecedor_nota_id);
        }
        
        if($filtro->produto_loja){
            $retorno->where("produto_loja", $filtro->produto_loja);
        }
        
        if($filtro->status_id){
            $retorno->where("status_id", $filtro->status_id);
        }
        
        if($filtro->categoria_id){
            $retorno->where("categoria_id", $filtro->categoria_id);
        }
        
       
        return $retorno->get();
    }
    
    public static function atualizarEstoque($produto_id, $qtde){
        $sql = "UPDATE produto SET
                        estoque_atual = estoque_atual + ($qtde) ,
                        estoque_real  = estoque_real + ($qtde)
                WHERE
                        id = $produto_id";
        DB::update($sql);
    }
    
    public static function reservarEstoque($produto_id, $qtde){
        $sql = "UPDATE produto SET
                        estoque_atual = estoque_atual - ($qtde) ,
                        estoque_reservado  = estoque_reservado + ($qtde)
                WHERE
                        id = $produto_id";
        DB::update($sql);
    }
    
    public static function excluirReservaDeEstoque($produto_id, $qtde){
        $sql = "UPDATE produto SET
                estoque_real        = estoque_real       - ($qtde),
                estoque_reservado   = estoque_reservado  - ($qtde)
                WHERE id    = $produto_id
            ";
        DB::update($sql);
    }
    
    public static function verificaCadastrado($ean, $nome, $referencia){
        $result = null;
        
        $result = Produto:: where('referencia', $referencia)->first();        
        if(!$result){
            $result = Produto::where('nome', $nome)->first();
        }
        
        if(!$result){
            $result = Produto::where('gtin', $ean)->where('gtin', '!=', 'SEM GTIN')->first();
        }        
        return $result;
    }
    
    public static function relatorio($filtro){
        $retorno = Produto::orderBy('produtos.id', 'asc');
        
        
      /*  if($filtro->cliente_id){
            $retorno->where("cliente_id", $filtro->cliente_id);
        }
        
        if($filtro->status_id){
            $retorno->where("status_id", $filtro->status_id);
        }
        
        if($filtro->status_financeiro_id){
            $retorno->where("status_financeiro_id", $filtro->status_financeiro_id);
        }
        
        if($filtro->usuario_id){
            $retorno->where("usuario_id", $filtro->usuario_id);
        }
        
        if($filtro->data2){
            if($filtro->data2){
                $retorno->where("data_venda",">=", $filtro->data1)->where("data_venda","<=", $filtro->data2);
            }else{
                $retorno->where("data_venda", $filtro->data1);
            }
            
        }
        */
        
        return $retorno->get();
    }
   
    
}
