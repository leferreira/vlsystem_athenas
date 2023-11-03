<?php
use App\Service\ConstanteService;
?>
<div class="window form alt" id="telaIva">

	<div class="p-2 px-4">
			<span class="d-block h3 border-bottom fw-700">Cadastro IVA-ST por Estado</span>
<div class="p-0">
	<form id="frmCadIva" method="post">
		<div class="rows">
				<div class="col-4 mb-3">
						<label class="text-label">Estado Destino</label>	
						<select class="form-campo" name="uf_destino" id="uf_destino" >	
						<option value="TD" >TD - Todos Estados </option>						
							@foreach($estados as $e)
								<option value="{{$e->uf}}" >{{$e->uf}} - {{$e->estado}} </option>
							@endforeach							
						</select>
				</div>
				<div class="col-4 mb-3" >
						<label class="text-label">Modalidade BC ICMSST</label>	
						<select class="form-campo" name="modBCST" id="modBCST" >							
							@foreach(ConstanteService::listaModalidadeSt() as $chave=>$valor)
								<option value="{{$chave}}" {{($nfeItem->modBC ?? null) == $chave ? "selected" : null }}>{{$chave}} -  {{$valor}}</option>
							@endforeach
						</select>							
				</div>
				<div class="col-4 mb-3" >
						<label class="text-label">CST Icms</label>
						<select class="form-campo" name="cstIcms" id="cstIcms"  >							
							@foreach($lista_cstIcms as $c)
								<option value="{{$c->cst}}" {{($natureza->cstICMS ?? null) == $c->cst ? "selected" : null }}>{{$c->descricao}}</option>
							@endforeach								
						</select>
							
					</div>
						
				<div class="col-2 mb-3">
                        <label class="text-label">MVAST (%)</label>
                        <input type="text" name="pMVAST"  value="{{ $nfeItem->pMVAST ?? old('pMVAST')}}"  class="form-campo  mascara-float">
                </div>
                            
				<div class="col-2 mb-3" >
						<label class="text-label">RedBC ICMSST (%)</label>	
						<input type="text" name="pRedBCST"   id="pRedBCST" value="{{$nfeItem->pRedBCST ?? old('pRedBCST') }}" class="form-campo mascara-float ">
				</div>				
									
				
				<div class="col-2 mb-3" >
						<label class="text-label">Aliq. ICMS Inter (%) </label>	
						<input type="text" name="pIcmsInter"   id="pIcmsInter" value="{{$nfeItem->pIcmsInter ?? old('pIcmsInter') }}" class="form-campo mascara-float">
				</div>
				
				<div class="col-3 mb-3" >
						<label class="text-label">Aliq. ICMS Intra (%) </label>	
						<input type="text" name="pIcmsIntra"   id="pIcmsIntra" value="{{$nfeItem->pIcmsIntra ?? old('pIcmsIntra') }}" class="form-campo mascara-float">
				</div>
				
				<div class="col-3 mb-3" >
						<label class="text-label">Aliq. interna Difal </label>	
						<input type="text" name="pDifal"   id="pDifal" value="{{$nfeItem->pICMS ?? old('pICMS') }}" class="form-campo mascara-float">
				</div>
				
				<div class="col-4 mb-3" >
						<label class="text-label">Aliq. FCP ST Ret.(%)</label>	
						<input type="text" name="pFCPSTRet" id="pFCPSTRet" value="{{$nfeItem->pFCPSTRet ?? old('pFCPSTRet') }}"  class="form-campo mascara-float">
				</div>
				
				<div class="col-4 mb-3" >
						<label class="text-label">Aliq. FC PST </label>	
						<input type="text" name="pFCPST"   id="pFCPSTIva" value="{{$nfeItem->pFCPST ?? old('pFCPST') }}" class="form-campo mascara-float">
				</div>
				
					
														
				 <div class="col-2 mb-3">
				 	<label class="text-label">.</label>	
				 	<input type="hidden" name="natureza_operacao_id"  id="natureza_operacao_id"  value="{{$natureza->id ?? null}}"> 
				 	<input type="hidden" name="tributacao_id" id="tributacao_id_iva" >
				 	<input type="hidden" name="uf_origem" id="uf_origem" value="{{$emitente->uf}}">
				 	<input type="button" value="Ins" id="btnInserirIvaTributacao" class="btn btn-azul border-bottom width-100">						 	
        		 </div>
					
         </div>
    </form>     
         <div class="rows mt-4">
			<div class="col-12 scroll-modal">
                <div class=" tabela-responsiva pb-4 prod table border-top mt-0 border-left border-bottom border-right" style="background: #f3f3f3;">
                    <table cellpadding="0" cellspacing="0" width="100%" >
                            <thead>
                             <tr>
                                    <th align="center">#</th>
                                    <th class="text-left">UF Origem</th>
                                    <th class="text-left">UF Dest.</th>
                                    <th class="text-left">CST</th>
                                    <th class="text-left">Aliq. Intra</th>
                                    <th class="text-left">Alíq. Inter</th>
                                    <th class="text-left">pMVAST</th>
                                    <th class="text-left">pRedBCST</th>
                                    <th class="text-left">pFCPST</th>
                                    <th class="text-left">modBCST</th>
                                    <th class="text-left">Alíq. Difal</th>
                                    <th align="center">Opções</th>
                                </tr>
                            </thead>
                            <tbody class="datatable-body" id="lista_iva_tributacao">   
                            
							</tbody>
                          </table>
								
                   </div>

                </div>
                </div>
                
	</div>		
         </div>
		 <div class="tfooter end">
			<a href="" class="btn btn-neutro fechar">Fechar</a> 
		 </div>
	</div>
