<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmitenteRequest extends FormRequest
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

    
    public function rules()
    {
      /*  $regras = [
            'razao_social'      => 'required|min:2|max:60',
            'fone'              => 'max:14',
            'im'                =>[
                function($attribute, $valor, $resultado){
                    if($this->cnae){
                         return $resultado('Ao inserir o Cnae é obrigatório a inserção da Inscrição Municipal');                        
                    }
                }
                ],
        ];*/
        
        $regras = [
            'razao_social'      => 'required|min:2|max:60',
            'cnpj'              => 'required',
            'logradouro'        => 'required|max:60',
            'numero'            => 'required',
            'bairro'            => 'required|max:60',
            'cep'               => 'required',
            'cidade'            => 'required|max:60',
            'uf'                => 'required',
            'ibge'              => 'required',
            'fone'              => 'max:14',
            'im'                =>[
                function($attribute, $valor, $resultado){
                    if($this->cnae){
                        return $resultado('Ao inserir o Cnae é obrigatório a inserção da Inscrição Municipal');
                    }
                }
            ],
        ];
        
        return $regras;
    }
}
