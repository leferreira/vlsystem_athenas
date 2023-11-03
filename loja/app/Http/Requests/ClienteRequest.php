<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nome'      => 'required|max:90',
            'email'     => 'required|max:90',
            'senha'     => 'required|min:6',
            'cpf'       => 'required',
            
            'rua'       => 'required|max:80',
            'numero'    => 'required|max:10',
            'bairro'    => 'required|max:90',
            'cidade'    => 'required|max:90',
            
            'uf'        => 'required|max:2|min:2',
            'cep'       => 'required|max:9',
            'complemento'=> 'max:60'
        ];
    }
}
