<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\NaturezaOperacao;

class NaturezaOperacaoRequest extends FormRequest
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
            'descricao'       => 'required',
            'tipo'           => 'required',
            'indPres'        => 'required',
            'devolucao'      => 'required',
            'padrao' =>[
                function($attribute, $valor, $resultado){
                    if($this->padrao){
                        $tem = NaturezaOperacao::where("padrao", $this->padrao)->first();
                        if($tem){
                            if ($this->method() == 'POST') 
                                return $resultado('Só pode haver uma Natureza de Operação Padrão para este valor:');
                        }
                    }                    
                }
               ],
        ];
    }
}
