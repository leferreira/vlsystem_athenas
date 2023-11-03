<?php

namespace App\Http\Requests;

use App\Tenant\UniqueTenant;
use Illuminate\Foundation\Http\FormRequest;

class UsuarioUpdateRequest extends FormRequest
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
        return [
            'name'      => 'required',
            'email'     => ['required', 'min:3', 'max:255', new UniqueTenant("users", $id)],
            'telefone'      => 'celular_com_ddd',
       ];
    }
    
    
    public function messages() {
        
        return [
            'telefone.celular_com_ddd' => 'Telefone não válido, use o formato (99)9999-9999 !'
        ];
    }
}
