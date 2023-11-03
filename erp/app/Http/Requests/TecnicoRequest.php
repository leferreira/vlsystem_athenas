<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TecnicoRequest extends FormRequest
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
            'nome'              => 'required|min:5|max:60',
            'logradouro'        => 'required|max:60',
            'numero'            => 'required',
            'bairro'            => 'required|max:60',
            'cep'               => 'required',
            'cidade'            => 'required|max:60',
            'uf'                => 'required',
            'telefone'          => 'max:14',
           

        ];     
       
        return $regras;
    }
    
   
}
