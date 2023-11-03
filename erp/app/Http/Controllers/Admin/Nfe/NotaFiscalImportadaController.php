<?php

namespace App\Http\Controllers\Admin\Nfe;

use App\Http\Controllers\Controller;
use App\Http\Requests\NfeRequest;
use App\Http\Requests\NovaNfeRequest;
use App\Models\Categoria;
use App\Models\Cfop;
use App\Models\Cliente;
use App\Models\Compra;
use App\Models\CstCofins;
use App\Models\CstIcms;
use App\Models\CstIpi;
use App\Models\CstPis;
use App\Models\Emitente;
use App\Models\Fornecedor;
use App\Models\ItemCompra;
use App\Models\NaturezaOperacao;
use App\Models\Nfce;
use App\Models\Nfe;
use App\Models\NfeAutorizado;
use App\Models\NfeDestinatario;
use App\Models\NfeDuplicata;
use App\Models\NfeDuplicataTemp;
use App\Models\NfeItem;
use App\Models\NfeItemTemp;
use App\Models\NfePagamento;
use App\Models\NfeReferenciado;
use App\Models\NfeTemp;
use App\Models\Produto;
use App\Models\Transportadora;
use App\Models\Tributacao;
use App\Models\Venda;
use App\Service\ConstanteService;
use App\Service\ItemNotafiscalService;
use App\Service\NfeDestinatarioService;
use App\Service\NotaFiscalOperacaoService;
use App\Service\NotaFiscalService;
use App\Service\VendaService;
use Illuminate\Http\Request;

class NotaFiscalImportadaController extends Controller
{    
    
    public function index(){ 
        $filtro = new \stdClass();
        $filtro->data1      = hoje();
        $filtro->data2      = hoje();
        $filtro->status_id  = null;
        $filtro->venda_id   = null;
     
        $dados["lista"]     = Nfe::filtro($filtro); 
        $dados["status"]    = ConstanteService::listaStatusNfe();
        $dados["filtro"]    = $filtro;
        $dados["opcoesNfeJs"]       = true;
        return view("Admin.Nfe.Index", $dados);        
    }
    
    public function filtro(){
        $filtro             = new \stdClass();
        $filtro->data1      = $_GET["data1"] ?? null;
        $filtro->data2      = $_GET["data2"] ?? null;
        $filtro->status_id  = $_GET["status_id"] ?? null;
        $filtro->venda_id   = $_GET["venda_id"] ?? null;
        
        $dados["lista"]     = Nfe::filtro($filtro);
        $dados["status"]    = ConstanteService::listaStatusNfe();
        $dados["filtro"]    = $filtro;
        $dados["opcoesNfeJs"]       = true;
        return view("Admin.Nfe.Index", $dados);
    }
    
    
    public function inserirAutorizado(Request $request){
        $req = $request->except(["_token","_method"]);
        NfeAutorizado::Create($req);
        $lista = NfeAutorizado::where("nfe_id", $req["nfe_id"])->get();
        echo json_encode($lista);
        
    }
    
    public function excluirAutorizado($id){
        $autorizado = NfeAutorizado::where("id", $id)->first();
        $autorizado->delete();
        $lista = NfeAutorizado::where("nfe_id", $autorizado->nfe_id)->get();
        echo json_encode($lista);
        
    }
    
    public function inserirReferenciado(Request $request){
        $req = $request->except(["_token","_method"]);
        NfeReferenciado::Create($req);
        $lista = NfeReferenciado::where("nfe_id", $req["nfe_id"])->get();
        echo json_encode($lista);
        
    }
    
    public function excluirReferenciado($id){
        $referenciado = NfeReferenciado::where("id", $id)->first();
        $referenciado->delete();
        $lista = NfeReferenciado::where("nfe_id", $referenciado->nfe_id)->get();
        echo json_encode($lista);
        
    }
    public function edit($id){
        
        $empresa                    = auth()->user()->empresa;
        $dados["notafiscal"]        = Nfe::find($id);
        $dados["transportadoras"]   = Transportadora::get();
        $dados["destinatario"]      = NfeDestinatario::where("nfe_id", $id)->first();
        $dados["itens"]             = NfeItem::where("nfe_id", $id)->get();
        $dados["duplicatas"]        = NfeDuplicata::listaPorNfe($id);
        $dados["autorizados"]       = NfeAutorizado::where("nfe_id", $id)->get();
        $dados["referenciados"]     = NfeReferenciado::where("nfe_id", $id)->get();
        $dados["pagamentos"]        = NfePagamento::lista($id);
        //$dados["nfetransporte"]     = NfeTransporte::where("nfe_id", $id)->first();
        
        //Dados da Venda
        $dados["tributacoes"]       = Tributacao::get();
        $dados["parametro"]         = $empresa->parametro;
        $dados["categorias"]        = Categoria::orderBy('categoria', 'asc')->get();
        $dados["unidades"]          = ConstanteService::unidadesMedida();
        $dados["cfops"]             = ConstanteService::unidadesMedida();
        $dados["produtoJs"]         = true;
        $dados["transportadoraJs"]  = true;
        
        //Tributacao
        $dados["lista_cstIcms"]     = CstIcms::get();
        $dados["lista_cst_ipi"]     = CstIpi::get();
        $dados["lista_cfop"]        = Cfop::get();
        $dados["lista_cstPis"]      = CstPis::where("tipo", "S")->get();
        $dados["lista_cstCofins"]   = CstCofins::where("tipo", "S")->get();
        $dados["lista_modalidade"]  = ConstanteService::listaModalidade();
        $dados["lista_modalidade_st"]  = ConstanteService::listaModalidadeSt();
        $dados["lista_motivo"]      = ConstanteService::motivoDesoneracao();
        
        return view("Admin.Nfe.Edit", $dados);
    }
    
    public function atualizarDadosPagamentos(Request $request){
        $nfe_id             = $request->nfe_id;
        $retorno            = new \stdClass();
        try {
            $req                = $request->except(["_token","_method"]);
            $nota               = new \stdClass() ;
            $nota->vFrete		= $req["vFreteTot"] ? getFloat($req["vFreteTot"]) : null;
            $nota->vSeg		    = $req["vSegTot"] ? getFloat($req["vSegTot"]) : null;
            $nota->vOutro		= $req["vOutroTot"] ? getFloat($req["vOutroTot"]) : null;
            $nota->desconto_nota= $req["desconto_nota"] ? getFloat($req["desconto_nota"]) : null;
            $nota->vDesc        = $req["desconto_nota"] ? getFloat($req["desconto_nota"]) : null;
            Nfe::where("id", $nfe_id)->update(objToArray($nota));
            ItemNotafiscalService::refazTodosCalculos($nfe_id);           
            $retorno->tem_erro = false;
            $retorno->erro = "";
            return response()->json($retorno);
            
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return response()->json($retorno);
        }
               
    }
    
   
    public function lerArquivo(){
        $dados["naturezas"]     = NaturezaOperacao::all();
        $dados["clientes"]      = Cliente::all();
        return view("Admin.Nfe.Importada.lerArquivo",$dados);
    }
    
    public function importarNfe(Request $request){
        if ($request->hasFile('arquivo')){
            $xml         = simplexml_load_file($request->arquivo);             
            if(isset($xml->NFe)){
                $xml_nfe = $xml->NFe->infNFe;
            }elseif($xml->infNFe){
                $xml_nfe = $xml->infNFe;
            }            
            
            $chaveNfe           =  $xml_nfe->attributes()->Id;
            $chave              = substr($chaveNfe, 3, 44);            
            $identificacao      = $xml_nfe->ide;
            $fornecedorNfe      = $xml_nfe->emit;
            $produtos           = $xml_nfe->det ;
            $totais             = $xml_nfe->total ;
            $transportadoraNfe  = $xml_nfe->transp;
            $duplicataNfe       = $xml_nfe->cobr->dup;
            $total              = ($totais->ICMSTot) ?? null;
            //Salvando a Identificacao
            $nfe            = new \stdClass();
            $nfe->status_id = config('constantes.status.Novo');
            $nfe->cUF       = $identificacao->cUF;
            $nfe->chave     = $chave;
            $nfe->cNF       = $identificacao->cNF;
            $nfe->natOp     = $identificacao->natOp;
            $nfe->modelo	= $identificacao->mod 			;
            $nfe->serie 	= $identificacao->serie 		;
            $nfe->nNF 		= $identificacao->nNF 			;
            $nfe->dhEmi 	= $identificacao->dhEmi 		;
            $nfe->dhSaiEnt 	= $identificacao->dhSaiEnt 		;
            $nfe->tpNF 		= $identificacao->tpNF 			;
            $nfe->idDest 	= $identificacao->idDest 		;
            $nfe->cMunFG 	= $identificacao->cMunFG 		;
            $nfe->tpImp 	= $identificacao->tpImp 		;
            $nfe->tpEmis 	= $identificacao->tpEmis 		;
            $nfe->cDV 		= $identificacao->cDV 			;
            $nfe->tpAmb 	= $identificacao->tpAmb 		;
            $nfe->finNFe 	= $identificacao->finNFe 		;
            $nfe->indFinal 	= $identificacao->indFinal 		;
            $nfe->indPres 	= $identificacao->indPres 		;
            $nfe->indIntermed = $identificacao->indIntermed 	;
            $nfe->procEmi 	= $identificacao->procEmi 		;
            $nfe->verProc 	= $identificacao->verProc 		;
            $nfe->dhCont 	= ($identificacao->dhCont) ?? null 		;
            $nfe->xJust 	= ($identificacao->xJust) ?? null 		;
            $nfe->vProd     = ($total->vProd) ?? null 	;
            $nfe->vFrete    = ($total->vFrete) ?? null 	;
            $nfe->vSeg      = ($total->vSeg) ?? null 	;
            $nfe->vDesc     = ($total->vDesc) ?? null 	;
            $nfe->vNF       = ($total->vNF) ?? null 	;
            $nfe->vOrig     = ($total->vOrig) ?? null 	;
            $nfe->vLiq      = ($total->vLiq) ?? null 	;            
            $nota         = NfeTemp::where("chave", $nfe->chave)->first();
            if(!$nota){
                $nota = NfeTemp::Create(objToArray($nfe));
            }          
            
            //Itens
            foreach($produtos as $item) {
                $produto            = new \stdClass();
                $produto->nfe_id    =   $nota->id;
                $produto->cProd     =   $item->prod->cProd;
                $produto->xProd		=	str_replace("'", "", $item->prod->xProd);
                $produto->cEAN		=	($item->prod->cEAN) ?? null;
                $produto->cBarra	=	($item->prod->cBarra) ?? null;
                $produto->xProd		=	$item->prod->xProd;
                $produto->NCM		=	$item->prod->NCM;
                $produto->CEST		=	$item->prod->CEST;
                $produto->cBenef	=	($item->prod->cBenef) ?? null;
                $produto->EXTIPI	=	($item->prod->EXTIPI) ?? null;
                $produto->CFOP		=	$item->prod->CFOP;
                $produto->uCom		=	$item->prod->uCom;
                $produto->qCom		=	$item->prod->qCom;
                $produto->vUnCom	=	$item->prod->vUnCom;
                $produto->vProd		=	$item->prod->vProd;
                $produto->cEANTrib	=	($item->prod->cEANTrib) ?? null;
                $produto->cBarraTrib=	($item->prod->cBarraTrib) ?? null;
                $produto->uTrib		=	$item->prod->uTrib;
                $produto->qTrib		=	$item->prod->qTrib;
                $produto->vUnTrib	=	$item->prod->vUnTrib;
                $produto->vFrete	=	($item->prod->vFrete) ? $item->prod->vFrete : 0;
                $produto->vSeg		=	($item->prod->vSeg) ? $item->prod->vSeg : 0;
                $produto->vDesc		=	($item->prod->vDesc) ? $item->prod->vDesc : 0;
                $produto->vOutro	=	($item->prod->vOutro) ? $item->prod->vOutro : 0;
                $produto->indTot	=	($item->prod->indTot) ?? null;
                $produto->xPed		=	($item->prod->xPed) ?? null;
                $produto->nItemPed	=	($item->prod->nItemPed) ?? null;
                $produto->nFCI		=	($item->prod->nFCI) ?? null;                
                //verifica se o produto já foi cadastrado
                $temProduto = NfeItemTemp::where(["nfe_id" =>$nota->id, "cProd" =>$produto->cProd])->first();
                if(!$temProduto){
                    NfeItemTemp::Create(objToArray($produto));
                }
             }
            exit;
            
            $fornecedor  = $xml->NFe->infNFe->emit;
            $produtos    = $xml->NFe->infNFe->det ;
            $totais      = $xml->NFe->infNFe->total ;
            $transportadora = isset($xml->NFe->infNFe->transp) ? $xml->NFe->infNFe->transp : null;
            
            // $cidade = Cidade::where('codigo',$xml->NFe->infNFe->emit->enderEmit->cMun)->first();
            $dadosEmitente = [
                'cpf'           => $xml->NFe->infNFe->emit->CPF,
                'cnpj'          => $xml->NFe->infNFe->emit->CNPJ,
                'razaoSocial'   => $xml->NFe->infNFe->emit->xNome,
                'nomeFantasia'  => $xml->NFe->infNFe->emit->xFant,
                'logradouro'    => $xml->NFe->infNFe->emit->enderEmit->xLgr,
                'numero'        => $xml->NFe->infNFe->emit->enderEmit->nro,
                'bairro'        => $xml->NFe->infNFe->emit->enderEmit->xBairro,
                'cep'           => $xml->NFe->infNFe->emit->enderEmit->CEP,
                'fone'          => $xml->NFe->infNFe->emit->enderEmit->fone,
                'ie'            => $xml->NFe->infNFe->emit->IE,
                'uf'            => $xml->NFe->infNFe->emit->UF,
                'cidade_id'     => 1
            ];
            
            $vFrete = number_format((double) $xml->NFe->infNFe->total->ICMSTot->vFrete,2, ",", ".");
            $vDesc = $xml->NFe->infNFe->total->ICMSTot->vDesc;
            
            $idFornecedor = 0;
            $fornecedorEncontrado = Fornecedor::where('cnpj',$dadosEmitente['cnpj'])->first();
            if($fornecedorEncontrado){
                $idFornecedor       = $fornecedorEncontrado->id;
                $dadosAtualizados   = $this->verificaAtualizacao($fornecedorEncontrado, $dadosEmitente);
            }else{
                array_push($dadosAtualizados, "Fornecedor cadastrado com sucesso");
                $idFornecedor = $this->cadastrarFornecedor($dadosEmitente);
            }
            
            //Produtos
            //itens
            $seq = 0;
            $itens = [];
            $contSemRegistro = 0;
            
            
            
            $chave = substr($xml->NFe->infNFe->attributes()->Id, 3, 44);
            $dadosNf = [
                'chave'     => $chave,
                'vProd'     => $xml->NFe->infNFe->total->ICMSTot->vProd,
                'indPag'    => $xml->NFe->infNFe->ide->indPag,
                'nNf'       => $xml->NFe->infNFe->ide->nNF,
                'vFrete'    => $vFrete,
                'vDesc'     => $vDesc,
                'contSemRegistro' => $contSemRegistro,
                
            ];
            
            //Pagamento
            $fatura = [];
            if (!empty($xml->NFe->infNFe->cobr->dup)) {
                foreach($xml->NFe->infNFe->cobr->dup as $dup) {
                    $titulo = $dup->nDup;
                    $vencimento = $dup->dVenc;
                    $vencimento = explode('-', $vencimento);
                    $vencimento = $vencimento[2]."/".$vencimento[1]."/".$vencimento[0];
                    $vlr_parcela = number_format((double) $dup->vDup, 2, ",", ".");
                    
                    $parcela = [
                        'numero'        => $titulo,
                        'vencimento'    => $vencimento,
                        'valor_parcela' => $vlr_parcela
                    ];
                    array_push($fatura, $parcela);
                }
            }
            
            //upload
            $file = $request->arquivo;
            $nameArchive = $chave . ".xml" ;
            $pathXml = $file->move('storage/xml/entrada', $nameArchive);
                
                
            
            
        }else{
            session()->flash('mensagem_erro', 'XML inválido!');
            return redirect("/compraFiscal");
        }
        $dados["identificacao"] = $identicacao;
        $dados["fornecedor"]    = $fornecedor;
        $dados["itens"]         = $itens;
        $dados["dadosNf"]       = $dadosNf;
        $dados["fatura"]       = $fatura;
        
        $dados["listaCSTCSOSN"] = ConstanteService::listaCSTCSOSN();;
        $dados["listaCST_PIS_COFINS"] = ConstanteService::listaCST_PIS_COFINS();
        $dados["listaCST_IPI"]  = ConstanteService::listaCST_IPI();
        $dados["unidades"]       = ConstanteService::unidadesMedida();
        $dados["categorias"]    = Categoria::all();
        $dados["dadosAtualizados"] = $dadosAtualizados;
        
        $dados["tributacoes"]   = Tributacao::all();
        $dados["total"]         = $totais->ICMSTot;
        $dados["transportadora"]= $transportadora;
        $dados["compraFiscalJs"]= true;
        $dados["pathXml"]       = $nameArchive;
        $dados["idFornecedor"]  = $idFornecedor;
        
        $dados["config"] = null;
        
        return view("Admin.Compra.Nfe.VisualizarNota", $dados);
        
    }
    
    public function salvar(NfeRequest $request){
        $retorno = new \stdClass();
        $id_nfe = $request->id_nfe;
        $req    = $request->except(["_token","_method","id_nfe","vProd"]);      
        try {            
            $nota   = (object) $req ; 
            
            $nota->qVol		            = ($req["vol_qtde"]) ? $req["vol_qtde"] : null ;
            $nota->esp	                = $req["vol_especie"] ?? null;
            $nota->marca		        = $req["vol_marca"] ?? null;
            $nota->nVol	                = $req["vol_numeraco"] ?? null;
            $nota->pesoL	            = $req["vol_peso_liq"] ?? null;
            $nota->pesoB	            = $req["vol_peso_bruto"] ?? null;
            $nota->nLacre		        = $req["vol_lacre"] ?? null;        
            
            //Dados da Nota
            NotaFiscalOperacaoService::salvarDadosNota($nota, $id_nfe);      
     
            //Destinatário
            $destinatario                = new \stdClass();
            $destinatario->dest_xNome    = $req["xNomeDestinatario"] ?? null;
            $destinatario->dest_indIEDest= $req["indIEDest"] ?? null;
            $destinatario->dest_IE       = $req["IEDestinatario"] ?? null;
            $destinatario->dest_ISUF     = $req["ISUFDestinatario"] ?? null;
            $destinatario->dest_IM       = $req["IMDestinatario"] ?? null;
            $destinatario->dest_email    = $req["emailDestinatario"] ?? null;
            $destinatario->dest_CNPJ     = $req["CNPJDestinatario"] ?? null;
            $destinatario->dest_CPF      = $req["CPFDestinatario"] ?? null;
            
            //Endereço Destinatário
            $destinatario->dest_idEstrangeiro= $req["idEstrangeiro"] ?? null;
            $destinatario->dest_xLgr     	= $req["xLgrDestinatario"] ?? null;
            $destinatario->dest_nro      	= $req["nroDestinatario"] ?? null;
            $destinatario->dest_xCpl     	= $req["xCplDestinatario"] ?? null;
            $destinatario->dest_xBairro  	= $req["xBairroDestinatario"] ?? null;
            $destinatario->dest_cMun     	= $req["cMunDestinatario"] ?? null;
            $destinatario->dest_xMun     	= $req["xMunDestinatario"] ?? null;
            $destinatario->dest_UF       	= $req["UFDestinatario"] ?? null;
            $destinatario->dest_CEP      	= $req["CEPDestinatario"] ?? null;
            $destinatario->dest_fone     	= $req["CEPDestinatario"] ?? null;
            
            NfeDestinatario::where("nfe_id", $id_nfe)->update(objToArray($destinatario));
            
        /*    //Atualizar transporte
            $transporte                     = new \stdClass();
            $transporte->nfe_id	            = $id_nfe;
            $transporte->modFrete	        = $req["modFrete"] ?? null;
            $transporte->transp_xNome	    = $req["transp_xNome"] ?? null;
            $transporte->transp_CNPJ	    = $req["transp_CNPJ"] ?? null;
            $transporte->transp_IE	        = $req["transp_IE"] ?? null;
            $transporte->transp_xEnder	    = $req["transp_xEnder"] ?? null;
            $transporte->transp_xMun	    = $req["transp_xMun"] ?? null;
            $transporte->transp_UF	        = $req["transp_UF"] ?? null;
            
            $transporte->transp_placa	    = $req["transp_placa"] ?? null;
            $transporte->UF_placa	        = $req["UF_placa"] ?? null;
            $transporte->RNTC	            = $req["RNTC"] ?? null;
            $transporte->transp_vagao       = $req["transp_vagao"] ?? null;
            $transporte->transp_balsa       = $req["transp_balsa"] ?? null;
            
            $transporte->qVol		        = ($req["vol_qtde"]) ? $req["vol_qtde"] : null ;
            $transporte->esp	            = $req["vol_especie"] ?? null;
            $transporte->marca		        = $req["vol_marca"] ?? null;
            $transporte->nVol	            = $req["vol_numeraco"] ?? null;
            $transporte->pesoL	            = $req["vol_peso_liq"] ?? null;
            $transporte->pesoB	            = $req["vol_peso_bruto"] ?? null;
            $transporte->nLacre		        = $req["vol_lacre"] ?? null;      
            $nfeTransp = NfeTransporte::where("nfe_id", $id_nfe)->first();
            if($nfeTransp){
                NfeTransporte::where("nfe_id", $id_nfe)->update(objToArray($transporte));
             }else{
                NfeTransporte::Create(objToArray($transporte));
            }
            */
            return redirect()->route("admin.notafiscal.edit", $id_nfe)->with("msg_sucesso", "Salvo com sucesso");
        } catch (\Exception $e) {
            $retorno->tem_erro = true;
            $retorno->erro = $e->getMessage();
            return redirect()->back()->with("msg_erro",$retorno->erro);
        }
    }
     
    
    
 }
