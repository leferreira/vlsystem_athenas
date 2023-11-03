
    <div class="rows pb-4 px-3 mt-4">
		<div class="col-12">		
             <fieldset class="p-2">
				<legend class="h5 mb-0 text-left">XMLs Referenciado </legend>
			 
            <div class="caixa px-2">
            <div class="rows">
            	<div class="col-4 mb-3" id="ver_combo_notar_refereciada">
                <label class="text-label">Tipo de nota referenciada</label>	
                <select class="form-campo" name="tipo_nota_referenciada" id="tipo_nota_referenciada" onchange="ver_tipo_nota_referenciada()">
                    <option value="">Selecione</option>
                    <option value="1" >Nfe ou Nfce (Mod 55 ou 65)</option>
                    <option value="2" >Cupom Fiscal(ECF - modelo 2D)</option>
                    <option value="3" >Nota Fiscal (talão - modelo 01)</option>
                    <option value="4" >Nota Fiscal de Consumidor (talão - modelo 02)</option>
                    <option value="5" >Nota Fiscal de Produtor (talão - modelo 01)</option>
                    <option value="6" >Nota Fiscal de Produtor (talão - modelo 04)</option>
                    <option value="7" >CTe (modelo 57)</option>
                </select>
                </div>
                <div class="col-6 mb-3" style="display:none" id="divChave">
                    <label class="text-label" id="lblChave">Chave de acesso</label>	
                    <input type="text" class="form-campo" name="ref_NFe" id="ref_NFe" value="{{ $notafiscal->ref_NFe ?? null }}"  autocomplete="off"/>
                </div>
              
                <div class="col-2 mb-3" style="display:none"  id="divDataEmissao">
                    <label class="text-label" id="lblMesAno">Ano e mês  (AAMM)</label>
                    <input type="text" class="form-campo" name="ref_ano_mes" id="ref_ano_mes" value="{{ $notafiscal->ref_ano_mes ?? null }}" autocomplete="off"/>
                </div>
                <div class="col-2 mb-3" style="display:none"  id="divNumeroNota">
                    <label class="text-label" id="lblNumero">Número </label>
                    <input type="text" class="form-campo" name="ref_num_nf" id="ref_num_nf" value="{{ $notafiscal->ref_num_nf ?? null }}" autocomplete="off"/>
                </div>
                 <div class="col-2 mb-3" style="display:none"  id="divSerieNota">
                    <label class="text-label" id="lblSerie">Série </label>
                    <input type="text" class="form-campo" name="ref_serie" id="ref_serie" value="{{ $notafiscal->ref_serie ?? null }}" autocomplete="off"/>
                </div>
        
        
                    <div class="col-2 mt-1 pt-1"> 
                    	<input type="button" onclick="inserirAutorizado()" value="Inserir" class="btn btn-azul width-100" />                              
                    </div> 
            </div>
            
            <div class="tabela-responsiva">
                    <table cellpadding="0" cellspacing="0" class="table-bordered">
                            <thead>
                                    <tr>
                                        <th align="center">ID</th>
                                        <th align="center">Referência</th>
                                        <th align="center">Mes/Ano</th>
                                        <th align="center">Número</th>
                                        <th align="center">Série</th>
                                        <th align="center">Excluir</th>
                                  </tr>
                            </thead>
                           <tbody id="lista_referenciado">
                               <?php foreach($referenciados as $item){ ?>
                                <tr>
                                    <td align="center"><?php echo $item->id ?></td>
                                    <td align="center"><?php echo $item->ref_NFe ?></td>
                                    <td align="center"><?php echo $item->ref_ano_mes ?></td>
                                    <td align="center"><?php echo $item->ref_num_nf ?></td>
                                    <td align="center"><?php echo $item->ref_serie ?></td>
                                    <td align="center"><a href="javascript:;" onclick="excluirReferenciado(<?php echo $item->id ?>)" class="btn btn-vermelho btn-pequeno d-inline-block" title="Excluir"><i class="fas fa-trash"></i></a></td>
                                </tr>
                               <?php } ?>
							    
                       </tbody>
                    </table>
                  
            </div>

		
            </div>
			
     
		</fieldset>
			</div>
        </div>