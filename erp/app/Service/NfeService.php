<?php
namespace App\Service;

use App\Models\Emitente;
use App\Models\Nfe;
use NFePHP\Common\Certificate;

class NfeService{
    private static $configJson;
    private static $certificado_digital;
    private static $tools;
    private static $pastaAmbiente; 
    
    
    
    public static function lerCertificado($certificado){
        $retorno = new \stdClass();
        try {
            $detalhe            =  Certificate::readPfx($certificado->certificado_arquivo_binario, $certificado->certificado_senha);
            
            $cert               = new \stdClass();
            $cert->inicio       = $detalhe->publicKey->validFrom->format('d/m/Y H:i:s');
            $cert->expiracao    = $detalhe->publicKey->validTo->format('d/m/Y H:i:s');
            $cert->serial       = $detalhe->publicKey->serialNumber;
            $cert->id           = $detalhe->publicKey->commonName;
            
            $retorno->tem_erro  = false;
            $retorno->titulo    = "Certificado Digital";
            $retorno->erro      = "";
            $retorno->retorno   = $cert;
            return $retorno;
            
        } catch (\Exception $e) {
            $retorno->tem_erro  = true;
            $retorno->titulo    = "Erro ao ler Certificado Digital";
            $retorno->erro      = $e->getMessage();
            return $retorno;
        }
        
        return $retorno;
    }
  
    public static function inutilizar($nfe){        
        $emitente               = Emitente::where("empresa_id", auth()->user()->empresa_id)->first();
        $valores                = new \stdClass();
        $valores->justificativa = "Inutilização do número devido o cancelamento interno da venda";
        $valores->id            = $nfe->id;
        $valores->nSerie        = $nfe->serie;
        $valores->nIni          = $nfe->nNF;
        $valores->nFin          = $nfe->nNF;
        $valores->cnpj          = $emitente->cnpj;
        $valores->tpAmb         = $emitente->ambiente_nfe;       
        $url                    = getenv("APP_URL_API"). "nfe/inutilizarNfe";
        $resultado              = enviarPostJsonCurl($url,json_encode($valores));
        return $resultado;
    }
  
    public function cancelarNfe($nfe, $justificativa){
        $valores                = new \stdClass();
        $valores->id            = $nfe->id;
        $valores->justificativa = $justificativa;        
        $url                    = getenv("APP_URL_API"). "nfe/cancelarNfe";
        $resultado              = enviarPostJsonCurl($url,json_encode($valores));
        return $resultado;
    }

}

