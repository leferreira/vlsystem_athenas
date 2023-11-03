<?php

namespace App\Http\Requests;

use App\Tenant\UniqueTenant;
use Illuminate\Foundation\Http\FormRequest;

class ClienteDeliveryRequest extends FormRequest
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
            'password'          => 'required',
        ];     
       
        return $regras;
    }
    
    
}
