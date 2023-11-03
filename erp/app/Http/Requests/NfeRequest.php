<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NfeRequest extends FormRequest
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
     
        $rules =  [
            'cUF'                   => 'required',
            'natOp'                 => 'required',
            'modelo'                => 'required',
            'serie'                 => 'required',
            'cMunFG'                => 'required',            
            
            'xNomeDestinatario'     => 'required',
            'indIEDest'             => 'required',
            'xLgrDestinatario'      => 'required',
            'nroDestinatario'       => 'required',
            'xBairroDestinatario'   => 'required',
            'cMunDestinatario'      => 'required',
            'xMunDestinatario'      => 'required',
            'UFDestinatario'        => 'required',
            
            'cnpjIntermed'          => 'nullable',
            'idCadIntTran'          => 'nullable',
            'tipo_nota_referenciada'=> 'nullable',
            'ref_NFe'               => 'nullable',
            'ref_ano_mes'           => 'nullable',
            'ref_num_nf'            => 'nullable',
            'ref_serie'             => 'nullable',
            
            'tpNF' =>[
                'required',
                function($attribute, $valor, $resultado){
                    $n = array_values(config("constanteNota.tpNf")); 
                    if(!in_array($this->tpNF, $n)){
                        return $resultado('Valor inválido para o campos Tipo de Documento (tpNf) ');
                    }
                 }
              ],
             
              'idDest' =>[
                  'required',
                  function($attribute, $valor, $resultado){
                      $n = array_values(config("constanteNota.idDest"));
                      if(!in_array($this->idDest, $n)){
                          return $resultado('Valor inválido para o campo dentificador de local de destino da 
operação (inDest) ');
                      }
                  }
              ],
              
              'tpImp' =>[
                  'required',
                  function($attribute, $valor, $resultado){
                      $n = array_values(config("constanteNota.tpImp"));
                      if(!in_array($this->tpImp, $n)){
                          return $resultado('Valor inválido para o Formato de Impressão do DANFE  ');
                      }
                  }
              ],
            
              'tpEmis' =>[
                  'required',
                  function($attribute, $valor, $resultado){
                      $n = array_values(config("constanteNota.tpEmis"));
                      if(!in_array($this->tpEmis, $n)){
                          return $resultado('Valor inválido para o campos Tipo de Emissão da NF-e (tpEmis) ');
                      }
                  }
              ],
             
              'indFinal' =>[
                  'required',
                  function($attribute, $valor, $resultado){
                      $n = array_values(config("constanteNota.indFinal"));
                      if(!in_array($this->indFinal, $n)){
                          return $resultado('Valor inválido para o campo indica operação com Consumidor 
final  (indFinal) ');
                      }
                  }
               ],
            
               'indPres' =>[
                   'required',
                   function($attribute, $valor, $resultado){
                       $n = array_values(config("constanteNota.indPres"));
                       if(!in_array($this->indPres, $n)){
                           return $resultado('Valor inválido para o campos Indicador de Presença (indPres) ');
                       }
                   }
             ],
             
             'modFrete' =>[
                 'required',
                 function($attribute, $valor, $resultado){
                     if ($this->modFrete=='9'){
                         if($this->transp_xNome){
                             return $resultado('Você não pode selecionar uma transportadora com o tipo de frete igual a 9 ! ');
                         }
                     }else{
                         if(!$this->transp_xNome){
                             return $resultado('Para o tipo de frete diferente de 9 é necessário selecionar uma transportadora ');
                         }
                     }
                 }
                 ],
                 
            
        ];
       
        if($this->indIntermed==1){
            $rules['cnpjIntermed']  = 'required';
            $rules['idCadIntTran']  = 'required';
        }
        
        if($this->finNFe!=1){
            if($this->tipo_nota_referenciada==1  || $this->tipo_nota_referenciada==2  || $this->tipo_nota_referenciada==7 ){
                $rules['ref_NFe']  = 'required';
            }else if($this->tipo_nota_referenciada==3  || $this->tipo_nota_referenciada==4  || $this->tipo_nota_referenciada==5 || $this->tipo_nota_referenciada==6){
                $rules['ref_ano_mes']  = 'required';
                $rules['ref_num_nf']   = 'required';
                $rules['ref_serie']    = 'required';
            }else{
                $rules['tipo_nota_referenciada']    = 'required';
            }
        }
        
        return $rules;
    }
}
