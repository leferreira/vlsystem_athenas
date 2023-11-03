<?php

namespace App\Http\Controllers\Admin\Configuracao;

use App\Http\Controllers\Controller;
use App\Http\Requests\TributacaoRequest;
use App\Models\NaturezaOperacao;
use App\Models\Tributacao;
use App\Models\TributacaoProduto;
use Illuminate\Http\Request;
use App\Models\TributacaoEstado;
use App\Models\TributacaoIva;

class TributacaoController extends Controller
{
    
    public function index()
    {        
        $dados["lista"] = NaturezaOperacao::get();
        return view("Admin.Configuracao.NaturezaOperacao.Index", $dados);
    }
    
    public function create()
    {
        $dados["naturezas"] = NaturezaOperacao::all();
        return view("Admin.Configuracao.NaturezaOperacao.Create", $dados);
    }

    public function inserirProduto(Request $request){
        $req = $request->except(["_token","_method"]);
        try {
             TributacaoProduto::Create($req);
             $lista = TributacaoProduto::where("tributacao_id", $req["tributacao_id"] )->get();
             $retorno = new \stdClass();
             $retorno->retorno = array();
             foreach($lista as $p){
                 $resultado                = new \stdClass();
                 $resultado->id            = $p->id;
                 $resultado->produto_id    = $p->produto->id;
                 $resultado->nome          = $p->produto->nome;
                 $resultado->tributacao_id = $p->tributacao_id;
                 $retorno->retorno[]       = $resultado;
             }
             
             
             return response()->json($retorno->retorno);     
        } catch (\Exception $e) {
            $retorno            = new \stdClass();
            $retorno->retorno   = array();
            $retorno->tem_erro  = true;
            $retorno->erro      = $e->getMessage();
            return response()->json($retorno);
        }        
    }
    
    public function listaProdutoTributacao($tributacao_id){    
        $lista = TributacaoProduto::where("tributacao_id", $tributacao_id )->get();
        $retorno = new \stdClass();
        $retorno->retorno = array();
        foreach($lista as $p){
            $resultado                = new \stdClass();
            $resultado->id            = $p->id;
            $resultado->produto_id    = $p->produto->id;
            $resultado->nome          = $p->produto->nome;
            $resultado->tributacao_id = $p->tributacao_id;
            $retorno->retorno[]       = $resultado;
        }
        
        return response()->json($retorno->retorno);        
    }

    public function inserirEstado(Request $request){
        $req = $request->except(["_token","_method"]);
        try {
            $req['pICMS']	   = $req['pICMS'] != null ? getFloat($req['pICMS']) : NULL;
            $req['pFCP']	   = $req['pFCP'] != null ? getFloat($req['pFCP']) : NULL;
            TributacaoEstado::Create($req);
            $lista = TributacaoEstado::listaPorTributacao($req["tributacao_id"] );
            return response()->json($lista);
        } catch (\Exception $e) {
            $retorno            = new \stdClass();
            $retorno->retorno   = array();
            $retorno->tem_erro  = true;
            $retorno->erro      = $e->getMessage();
            return response()->json($retorno);
        }
    }
    
    public function inserirIva(Request $request){
        $req                        = $request->except(["_token","_method"]);
        try {
            $req['pMVAST']	         = $req['pMVAST'] != null ? getFloat($req['pMVAST']) : NULL;
            //$req['pMVASTImportado']= $req['pMVASTImportado'] != null ? getFloat($req['pMVASTImportado']) : NULL;
            $req['pRedBCST']         = $req['pRedBCST'] ? getFloat($req['pRedBCST']) : null;
            $req['pIcmsInter']	     = $req['pIcmsInter'] != null ? getFloat($req['pIcmsInter']) : NULL;
            $req['pIcmsIntra']	     = $req['pIcmsIntra'] != null ? getFloat($req['pIcmsIntra']) : NULL;
            $req['pFCPST']	         = $req['pFCPST'] != null ? getFloat($req['pFCPST']) : NULL;
            $req['pDifal']	         = $req['pDifal'] != null ? getFloat($req['pDifal']) : NULL;
            TributacaoIva::Create($req);
            $lista = TributacaoIva::where("tributacao_id",$req["tributacao_id"] )->get();
            return response()->json($lista);
        } catch (\Exception $e) {
            $retorno            = new \stdClass();
            $retorno->retorno   = array();
            $retorno->tem_erro  = true;
            $retorno->erro      = $e->getMessage();
            return response()->json($retorno);
        }
    }
    
    public function listaTributacaoEstado($tributacao_id){
        $lista = TributacaoEstado::listaPorTributacao($tributacao_id);            
        return response()->json($lista);
    }
    
    public function listaTributacaoIva($tributacao_id){
        $lista = TributacaoIva::where("tributacao_id",$tributacao_id)->get();
        return response()->json($lista);
    }
    
    public function store(TributacaoRequest $request){   
        $retorno                    = new \stdClass();
        $id                         = $request->id;      
        $req                        = $request->except(["_token","_method","id","padrao"]);   
        
        try {
            $req["pICMS"] 		       =  ($req["pICMS"] 		   ?? null ) != null ? getFloat($req["pICMS"] 			 ) : null;
            $req["pRedBC"] 		       =  ($req["pRedBC"] 		   ?? null ) != null ? getFloat($req["pRedBC"] 			 ) : null;
            $req["pICMSST"] 	       =  ($req["pICMSST"] 		   ?? null ) != null ? getFloat($req["pICMSST"] 		 ) : null;
            $req["pMVAST"] 		       =  ($req["pMVAST"] 		   ?? null ) != null ? getFloat($req["pMVAST"] 			 ) : null;
            $req["pRedBCST"] 		   =  ($req["pRedBCST"] 	   ?? null ) != null ? getFloat($req["pRedBCST"] 		 ) : null;
            $req["vICMSSubstituto"]    =  ($req["vICMSSubstituto"] ?? null ) != null ? getFloat($req["vICMSSubstituto"]  ) : null;
            $req["pFCP"] 			   =  ($req["pFCP"] 		   ?? null ) != null ? getFloat($req["pFCP"] 			 ) : null;
            $req["pFCPST"] 		       =  ($req["pFCPST"] 		   ?? null ) != null ? getFloat($req["pFCPST"] 			 ) : null;
            $req["pFCPSTRet"] 		   =  ($req["pFCPSTRet"] 	   ?? null ) != null ? getFloat($req["pFCPSTRet"] 		 ) : null;
            $req["pDif"] 			   =  ($req["pDif"] 		   ?? null ) != null ? getFloat($req["pDif"] 			 ) : null;
            $req["pPIS"] 			   =  ($req["pPIS"] 		   ?? null ) != null ? getFloat($req["pPIS"] 			 ) : null;
            $req["vAliqProd_pis"] 	   =  ($req["vAliqProd_pis"]   ?? null ) != null ? getFloat($req["vAliqProd_pis"] 	 ) : null;
            $req["pPISST"] 		       =  ($req["pPISST"] 		   ?? null ) != null ? getFloat($req["pPISST"] 			 ) : null;
            $req["vAliqProd_pisst"]    =  ($req["vAliqProd_pisst"] ?? null ) != null ? getFloat($req["vAliqProd_pisst"]  ) : null;
            $req["pCOFINS"] 		   =  ($req["pCOFINS"] 		   ?? null ) != null ? getFloat($req["pCOFINS"] 		 ) : null;
            $req["vAliqProd_cofins"]   =  ($req["vAliqProd_cofins"]?? null ) != null ? getFloat($req["vAliqProd_cofins"] ) : null;
            $req["pCOFINSST"] 		   =  ($req["pCOFINSST"] 	   ?? null ) != null ? getFloat($req["pCOFINSST"] 		 ) : null;
            $req["vAliqProd_cofinsst"] =  ($req["vAliqProd_cofinsst"]?? null ) != null ? getFloat($req["vAliqProd_cofinsst"]) : null;
            $req["preco_unit_Pauta_ST"]=  ($req["preco_unit_Pauta_ST"]?? null ) != null ? getFloat($req["preco_unit_Pauta_ST"]) : null;
            $req["motDesICMS"]         =  ($req["motDesICMS"]?? null ) != null ? getFloat($req["motDesICMS"]) : null;
            $req["pBCOp"]              =  ($req["pBCOp"]?? null ) != null ? getFloat($req["pBCOp"]) : null;
            
            //IPI
            $req["CNPJProd"]      	   =  ($req["CNPJProd"]  ?? null) != null ? tira_mascara($req["CNPJProd"]) :null      	 ;
            $req["pIPI"] 			   =  ($req["pIPI"] 	 ?? null ) != null ? getFloat($req["pIPI"] 			 ) : null;
            $req["vUnidIPI"] 		   =  ($req["vUnidIPI"]  ?? null ) != null ? getFloat($req["vUnidIPI"] 		 ) : null;
            $req["tipo_calc_ipi"]      =  $req["tipo_calc_ipi"] ?? 1;
           
            $req["vbc_somente_produto"]=  $req["vbc_somente_produto"] ?? "N" ;
            $req["vbc_frete"]          =  $req["vbc_frete"] ?? "N" ;
            $req["vbc_ipi"]            =  $req["vbc_ipi"] ?? "N" ;
            $req["vbc_outros"]         =  $req["vbc_outros"] ?? "N" ;
            $req["vbc_seguro"]         =  $req["vbc_seguro"] ?? "N" ;
            $req["vbc_desconto"]       =  $req["vbc_desconto"] ?? "N" ;
            
            $req["ipi_somente_produto"]=  $req["ipi_somente_produto"] ?? "N" ;
            $req["ipi_frete"]          =  $req["ipi_frete"] ?? "N" ;
            $req["ipi_outros"]         =  $req["ipi_outros"] ?? "N" ;
            $req["ipi_seguro"]         =  $req["ipi_seguro"] ?? "N" ;
            $req["ipi_desconto"]       =  $req["ipi_desconto"] ?? "N" ;
            
            $req["pis_somente_produto"]=  $req["pis_somente_produto"] ?? "N" ;
            $req["pis_frete"]          =  $req["pis_frete"] ?? "N" ;
            $req["pis_ipi"]            =  $req["pis_ipi"] ?? "N" ;
            $req["pis_outros"]         =  $req["pis_outros"] ?? "N" ;
            $req["pis_seguro"]         =  $req["pis_seguro"] ?? "N" ;
            $req["pis_desconto"]       =  $req["pis_desconto"] ?? "N" ;
            
            $req["cofins_somente_produto"]=  $req["cofins_somente_produto"] ?? "N" ;
            $req["cofins_frete"]       =  $req["cofins_frete"] ?? "N" ;
            $req["cofins_ipi"]         =  $req["cofins_ipi"] ?? "N" ;
            $req["cofins_outros"]      =  $req["cofins_outros"] ?? "N" ;
            $req["cofins_seguro"]      =  $req["cofins_seguro"] ?? "N" ;
            $req["cofins_desconto"]    =  $req["cofins_desconto"] ?? "N" ;
           // $req["cfop_contribuinte"]      = tira_mascara($req["cfop_contribuinte"]);
           // $req["cfop_nao_contribuinte"]  = tira_mascara($req["cfop_nao_contribuinte"]);
           
            $req["cst900_icms"]        =  $req["cst900_icms"] ?? "N" ;
            $req["cst900_redbc"]       =  $req["cst900_redbc"] ?? "N" ;
            $req["cst900_credisn"]     =  $req["cst900_credisn"] ?? "N" ;
            $req["cst900_st"]          =  $req["cst900_st"] ?? "N" ;
            $req["cst900_redbcst"]     =  $req["cst900_redbcst"] ?? "N" ;
      
            $req["cfop"]  = tira_mascara($req["cfop"]);
           
            if($id){
                Tributacao::where("id", $id)->update($req);
            }else{
                $trib           = Tributacao::where("natureza_operacao_id", $req["natureza_operacao_id"])->first();
                $req["padrao"]  = $trib ? "N" : "S"; 
                Tributacao::Create($req);
            }            
         
            $retorno->tem_erro = false;
            $retorno->erro = "";
            return response()->json($retorno);
            
        } catch (\Exception $e) {
            $retorno->tem_erro = false;
            $retorno->erro = $e->getMessage();            
            return response()->json($retorno);
        }
    }

    public function excluirProdutoTributacao( $id){
        try {
            $produto = TributacaoProduto::find($id);
            $produto->delete();
            $lista = TributacaoProduto::where("tributacao_id", $produto->tributacao_id)->get();
            $retorno = new \stdClass();
            $retorno->retorno = array();
            foreach($lista as $p){
                $resultado                = new \stdClass();
                $resultado->id            = $p->id;
                $resultado->produto_id    = $p->produto->id;
                $resultado->nome          = $p->produto->nome;
                $resultado->tributacao_id = $p->tributacao_id;
                $retorno->retorno[]       = $resultado;
            }
            return response()->json($retorno);
        } catch (\Exception $e) {
            $retorno = new \stdClass();
            $retorno->retorno = array();
            $retorno->tem_erro  = true;
            $retorno->erro      = $e->getMessage();
            return response()->json($retorno);
        }
        
    }
    
    public function excluirEstadoTributacao( $id){
        try {
            $estado = TributacaoEstado::find($id);
            $estado->delete();
            $lista = TributacaoEstado::listaPorTributacao($estado->tributacao_id);
            return response()->json($lista);
        } catch (\Exception $e) {
            $retorno = new \stdClass();
            $retorno->retorno = array();
            $retorno->tem_erro  = true;
            $retorno->erro      = $e->getMessage();
            return response()->json($retorno);
        }
        
    }
    
    public function excluirIvaTributacao( $id){
        try {
            $estado = TributacaoIva::find($id);
            $estado->delete();
            $lista = TributacaoIva::where("tributacao_id",$id)->get();
            return response()->json($lista);
        } catch (\Exception $e) {
            $retorno = new \stdClass();
            $retorno->retorno = array();
            $retorno->tem_erro  = true;
            $retorno->erro      = $e->getMessage();
            return response()->json($retorno);
        }
        
    }
    public function show($id){
        $tributacao             = Tributacao::find($id);      
        return response()->json($tributacao);
    }

    
    public function edit($id){
        $dados["natureza"]     = NaturezaOperacao::find($id);
        return view("Admin.Configuracao.NaturezaOperacao.Create", $dados);
    }

    
    public function update(Request $request, $id)
    {
        $req                =   $request->except(["_token","_method"]);
        
        $req["cfop"]        = tira_mascara($req["cfop"]);
        $req["pICMS"]       = ($req["pICMS"]  ?? null) != null ? getFloat($req["pICMS"]) : null ;
        $req["pFCP"]        = ($req["pFCP"]  ?? null) != null ? getFloat($req["pFCP"]) : null ;
        $req["pMVAST"]      = ($req["pMVAST"]  ?? null) != null ? getFloat($req["pMVAST"]) : null ;
        $req["pRedBCST"]    = ($req["pRedBCST"]  ?? null) != null ? getFloat($req["pRedBCST"]) : null ;
        $req["vBCST"]       = ($req["vBCST"]  ?? null) != null ? getFloat($req["vBCST"]) : null ;
        $req["pICMSST"]     = ($req["pICMSST"]  ?? null) != null ? getFloat($req["pICMSST"]) : null ;
        $req["pFCPST"]      = ($req["pFCPST"]  ?? null) != null ? getFloat($req["pFCPST"]) : null ;
        $req["pRedBC"]      = ($req["pRedBC"]  ?? null) != null ? getFloat($req["pRedBC"]) : null ;
        $req["pDif"]        = ($req["pDif"] ?? null) ? getFloat($req["pDif"]) : null ;
        $req["vICMSSubstituto"]  = ($req["vICMSSubstituto"]  ?? null) != null ? getFloat($req["vICMSSubstituto"]) : null ;
        $req["pFCPSTRet"]        = ($req["pFCPSTRet"]  ?? null) != null ? getFloat($req["pFCPSTRet"]) : null ;
        
        
        $req["CNPJProd"]      	=  ($req["CNPJProd"]  ?? null) != null ? tira_mascara($req["CNPJProd"]) :null      	 ;
        $req["pIPI"]          	=  ($req["pIPI"]  ?? null) != null ?   getFloat($req["pIPI"] ) : null        	 ;
        $req["vUnidIPI"]      	=  ($req["vUnidIPI"]  ?? null) != null ? getFloat($req["vUnidIPI"] ) : null      	 ;
        $req["qUnidIPI"]      	=  ($req["qUnidIPI"]  ?? null) != null ? getFloat($req["qUnidIPI"] ) : null      	 ;
        $req["tipo_calc_ipi"]   =  $req["tipo_calc_ipi"] ?? 1;
        
        $req["pPIS"]            =  ($req["pPIS"]  ?? null) != null   ? getFloat($req["pPIS"] ) : null           ;
        $req["vAliqProd_pis"]   =  ($req["vAliqProd_pis"]  ?? null) != null ? getFloat($req["vAliqProd_pis"] ) : null    ;
        
        $req["pPISST"]         	=  ($req["pPISST"]  ?? null) != null    ? getFloat($req["pPISST"] ) : null      	 ;
        $req["vAliqProd_pisst"] =  ($req["vAliqProd_pisst"]  ?? null) != null ? getFloat($req["vAliqProd_pisst"] ) : null 	 ;
        
        
        $req["pCofins"]         = ($req["pCofins"]  ?? null) != null  ? getFloat( $req["pCofins"]  ) : null        ;
        $req["vAliqProd_cofins"]= ($req["vAliqProd_cofins"]  ?? null) != null ? getFloat($req["vAliqProd_cofins"] ) : null ;
        $req["vAliqProd_cofinsst"]= ($req["vAliqProd_cofinsst"]  ?? null) != null ? getFloat($req["vAliqProd_cofinsst"] ) : null ;
        
        $req["pCofinsst"]       =  ($req["pCofinsst"]  ?? null) != null ? getFloat($req["pCofinsst"]  ) : null        	;
        
        
        $req["pIPI"]            = ($req["pIPI"] ?? null) != null ? getFloat($req["pIPI"]) : null;
        $req["qUnidIPI"]        = ($req["qUnidIPI"] ?? null) != null ? getFloat($req["qUnidIPI"]) : null;
        $req["vUnidIPI"]        = ($req["vUnidIPI"] ?? null) != null ? getFloat($req["vUnidIPI"]) : null;
        $req["pPIS"]            = ($req["pPIS"] ?? null) != null ? getFloat($req["pPIS"]) : null;
        $req["vAliqProd_pis"]   = ($req["vAliqProd_pis"]!=null) ? getFloat($req["vAliqProd_pis"]) : null;
        $req["vAliqProd_cofins"]= ($req["vAliqProd_cofins"] ?? null) != null ? getFloat($req["vAliqProd_cofins"]) : null;
        $req["pCofins"]         = ($req["pCofins"] ?? null) != null ? getFloat($req["pCofins"]) : null;
        
        $req["vbc_frete"]          =  $req["vbc_frete"] ?? "N" ;
        $req["vbc_ipi"]            =  $req["vbc_ipi"] ?? "N" ;
        $req["vbc_outros"]         =  $req["vbc_outros"] ?? "N" ;
        $req["vbc_seguro"]         =  $req["vbc_seguro"] ?? "N" ;
        $req["vbc_desconto"]       =  $req["vbc_desconto"] ?? "N" ;
        
        $req["ipi_frete"]          =  $req["ipi_frete"] ?? "N" ;
        $req["ipi_outros"]         =  $req["ipi_outros"] ?? "N" ;
        $req["ipi_seguro"]         =  $req["ipi_seguro"] ?? "N" ;
        $req["ipi_desconto"]       =  $req["ipi_desconto"] ?? "N" ;
        
        $req["pis_frete"]          =  $req["pis_frete"] ?? "N" ;
        $req["pis_ipi"]            =  $req["pis_ipi"] ?? "N" ;
        $req["pis_outros"]         =  $req["pis_outros"] ?? "N" ;
        $req["pis_seguro"]         =  $req["pis_seguro"] ?? "N" ;
        $req["pis_desconto"]       =  $req["pis_desconto"] ?? "N" ;
        
        $req["cofins_frete"]       =  $req["cofins_frete"] ?? "N" ;
        $req["cofins_ipi"]         =  $req["cofins_ipi"] ?? "N" ;
        $req["cofins_outros"]      =  $req["cofins_outros"] ?? "N" ;
        $req["cofins_seguro"]      =  $req["cofins_seguro"] ?? "N" ;
        $req["cofins_desconto"]    =  $req["cofins_desconto"] ?? "N" ;
        
        $req["cst900_icms"]        =  $req["cst900_icms"] ?? "N" ;
        $req["cst900_redbc"]       =  $req["cst900_redbc"] ?? "N" ;
        $req["cst900_credisn"]     =  $req["cst900_credisn"] ?? "N" ;
        $req["cst900_st"]          =  $req["cst900_st"] ?? "N" ;
        $req["cst900_redbcst"]     =  $req["cst900_redbcst"] ?? "N" ;
     
       i($req);
  
        NaturezaOperacao::where("id", $id)->update($req);
        return redirect()->route("admin.naturezaoperacao.index")->with('msg_sucesso', "item alterado com sucesso.");;
    }

    public function tornarPadrao($id){
        $retorno = new \stdClass();
        try{ 
            $h = Tributacao::find($id);
            //Tornando todo mundo não padrao
            Tributacao::where("natureza_operacao_id", $h->natureza_operacao_id)->update(["padrao" => "N"]);
            //Excluindo todas tributações do produto
            //TributacaoProduto::where("tributacao_id",$id )->delete();
            $h->padrao = "S";            
            $h->save();                 
            
            $retorno->tem_erro = false;
            $retorno->erro = "";
            return response()->json($retorno);
        }catch (\Exception $e){
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return response()->json($retorno);
        }
    }
    
    public function destroy($id){
        $retorno = new \stdClass();
        try{
            $h = Tributacao::find($id);
            TributacaoProduto::where("tributacao_id",$id )->delete();
            $h->delete();
            
            $retorno->tem_erro = false;
            $retorno->erro = "";
            return response()->json($retorno);
        }catch (\Exception $e){
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return response()->json($retorno);
        }
    }
}
