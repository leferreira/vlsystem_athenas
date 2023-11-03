<?php

namespace App\Http\Requests;

use App\Tenant\UniqueTenant;
use Illuminate\Foundation\Http\FormRequest;

class VendedorRequest extends FormRequest
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
            'nome'              => ['required','min:5','max:60', new UniqueTenant("vendedors", $id)],
            'cpf'               => [ 'cpf', new UniqueTenant("vendedors", $id)],
            'email'             => ['required',  new UniqueTenant("vendedors", $id)],
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
