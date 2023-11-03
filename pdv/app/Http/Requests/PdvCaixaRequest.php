<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PdvCaixaRequest extends FormRequest
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
        return [
            'caixa_numero_id'    => 'required',
        ];
    }    
 
    public function messages()
    {
        return [
            'caixa_numero_id.required' => 'É necessário selecionar número do caixa primeiramente, faça o cadastro no ERP',
            'valor_abertura.required' => 'É necessário inserir um valor inicial para o caixa',
        ];
    }
}
