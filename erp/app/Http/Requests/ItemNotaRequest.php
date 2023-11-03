<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemNotaRequest extends FormRequest
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
        $regras = [
            'nfe_id'           => 'required',
            'produto_id'       => 'required',
            'qtde'             => 'required',
            'preco'            => 'required',
            'unidade'          => 'required',
        ];
        
        return $regras;;
    }
    
    public function messages()
    {
       return  [
            'nfe_id.required'       => 'Selecione uma Nota Fiscal',
            'produto_id.produto_id' => 'Selecione um Produto',
            'qtde.required'         => 'Selecione a Quantidade',
            'preco.required'        => 'Selecione o Preco',
            'unidade.required'      => 'Selecione a Unidade',
        ];
        
    }
}
