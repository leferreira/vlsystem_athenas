<?php

namespace App\Http\Requests;

use App\Tenant\UniqueTenant;
use Illuminate\Foundation\Http\FormRequest;

class VariacaoGradeRequest extends FormRequest
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
        $regras = [
            'variacao'         => 
                [
                    'required',
                    new UniqueTenant("variacao_grades", $id)
                 ],
            
        ];
        
        return $regras;
    }

    
   
}
