<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DespesaRequest extends FormRequest
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
            'descricao'         => 'required',
            'fornecedor_id'          => 'required',
            'tipo_despesa_id'          => 'required',
            'data_lancamento'        => 'required',
            'valor_despesa'            => 'required',         

        ];     
       
        return $regras;
    }
    
 
}
