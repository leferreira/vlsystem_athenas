<?php

namespace App\Http\Requests;

use App\Tenant\UniqueTenant;
use Illuminate\Foundation\Http\FormRequest;

class LocalizacaoRequest extends FormRequest
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
        $id = $this->segment(3);
        return [
            'localizacao' => [
                'required',
                'max:255',                
                new UniqueTenant("localizacaos", $id)
            ],            
        ];
    }

    
   
}
