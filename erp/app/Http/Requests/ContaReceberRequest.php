<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContaReceberRequest extends FormRequest
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
            'cliente_id'          => 'required',
            'data_emissao'        => 'required',
            'valor'            => 'required',         

        ];     
       
        return $regras;
    }
    
   
}
