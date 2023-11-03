<?php

namespace App\Http\Requests;

use App\Tenant\UniqueTenant;
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
     * @return array
     */
    public function rules()
    {
        $id = $this->segment(3);
        $regras = [
            'nome_razao_social' => ['required','min:5','max:60',
                new UniqueTenant("clientes", $id)],
            'cpf_cnpj'          => ['required','cpf_ou_cnpj',new UniqueTenant("clientes", $id)],
            'email'             => ['required',  new UniqueTenant("clientes", $id)],
            'logradouro'        => 'required|max:60',
            'numero'            => 'required',
            'bairro'            => 'required|max:60',
            'cep'               => 'required',
            'cidade'            => 'required|max:60',
            'uf'                => 'required',
            'telefone'          => 'max:14',
            'tipo_contribuinte' =>[
                function($attribute, $valor, $resultado){
                    if($this->tipo_cliente =='J' ){
                        if($this->tipo_contribuinte!='9'){
                            if(!$this->rg_ie){
                                return $resultado('A Incrição Estadual é obrigatória para Contribuintes ICMS');
                            }
                        }
                    }
                }
                ],

        ];     
       
        return $regras;
    }
    
    public function messages(){        
        return [
            'nome_razao_social:required' => 'O campo Nome/Razão é obrigatório.',
            'cpf_cnpj:required'          => 'O campo CPF/CNPJ é Obrigatorio.',
            
        ];
    }
}
