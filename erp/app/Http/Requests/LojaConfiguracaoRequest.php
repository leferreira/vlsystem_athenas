<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LojaConfiguracaoRequest extends FormRequest
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
            'nome'             => 'required',
            'rua'               => 'required',
            'numero'            => 'required',
            'bairro'            => 'required',
            'cidade'            => 'required',
            'cep'               => 'required',
            'telefone'          => 'required',
            'email'              => 'required',
            'frete_gratis_valor'        => 'required'
        ];
    }
}
