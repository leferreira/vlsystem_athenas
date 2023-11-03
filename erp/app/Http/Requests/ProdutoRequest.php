<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Tenant\UniqueTenant;

class ProdutoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->segment(3);
        $rules =  [
            'nome'=>[
                'required',
                'max:120',
                new UniqueTenant("produtos", $id)
            ],
            'sku'=>[
                'required',
                new UniqueTenant("produtos", $id)
            ],
            'unidade'       => 'required',
            'valor_venda'   => 'required',
            'valor_custo'   => 'required',
            'ncm'           => 'required|min:10|max:10', 
            'produto_loja'  => 'required',
            'largura'       => 'nullable',
            'altura'        => 'nullable',
            'comprimento'   => 'nullable',
            'peso_liquido'  => 'nullable',
            'peso_bruto'    => 'nullable',
            
            
            'fragmentacao_qtde'     => 'nullable',
            'fragmentacao_unidade'  => 'nullable',
            'fragmentacao_valor'    => 'nullable',
        ];
        if($this->produto_loja=="S"){
            $rules['largura']       = 'required';
            $rules['altura']        = 'required';
            $rules['comprimento']   = 'required';
            $rules['peso_liquido']  = 'required';
            $rules['peso_bruto']    = 'required';
        }
        
      
        
        if((floatval($this->fragmentacao_qtde) > 0) || ($this->fragmentacao_unidade) || (floatval($this->fragmentacao_valor) > 0) ){
            $rules['fragmentacao_qtde']     = 'required';
            $rules['fragmentacao_unidade']  = 'required';
            $rules['fragmentacao_valor']    = 'required';
        }
        
        return $rules;
    }
}
