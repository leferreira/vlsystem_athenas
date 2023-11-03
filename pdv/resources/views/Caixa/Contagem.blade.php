@extends("template")
@section("conteudo")
<div class="conteudo-fluido">
	<div class="base-pdv assistente">
		<div class="rows">
				<div class="col-12">
					<div class="caixa">
						<b class="h4 text-verde d-block mb-1 pt-1 text-center" id="descricao">Assistente de conferência de caixa</b>
					</div>
				</div>
<<<<<<< HEAD
				<div class="col-9 d-flex">
					<div class="caixa p-2 mb-0">
					<div class="rows">
						<div class="col-6">
							<div class="rows py-3 pt-0 border-bottom">
								<div class="col-12"><span class="h5 mb-1 fw-700 border-bottom" style="color:#1fa774">Cédulas</span></div>								
								<div class="col-3 mt-3">								
									<input type="text" name="" class="inputCedula">
									<small class="d-block text-center mt-1 h5 mb-0 fw-700">(R$2,00)</small>
								</div>
								<div class="col-3 mt-3">
									<input type="text" name="" class="inputCedula">
									<small class="d-block text-center mt-1 h5 mb-0 fw-700">(R$5,00)</small>
								</div>
								<div class="col-3 mt-3">
									<input type="text" name="" class="inputCedula">
									<small class="d-block text-center mt-1 h5 mb-0 fw-700">(R$10,00)</small>
								</div>
								<div class="col-3 mt-3">
									<input type="text" name="" class="inputCedula">
									<small class="d-block text-center mt-1 h5 mb-0 fw-700">(R$20,00)</small>
								</div>
								<div class="col-3 mt-3">
									<input type="text" name="" class="inputCedula">
									<small class="d-block text-center mt-1 h5 mb-0 fw-700">(R$50,00)</small>
								</div>
								<div class="col-3 mt-3">
									<input type="text" name="" class="inputCedula">
									<small class="d-block text-center mt-1 h5 mb-0 fw-700">(R$100,00)</small>
								</div>
								<div class="col-3 mt-3">
									<input type="text" name="" class="inputCedula">
									<small class="d-block text-center mt-1 h5 mb-0 fw-700">(R$200,00)</small>
								</div>
							</div>
						</div>
						
						<div class="col-6">
							<div class="rows pb-3 border-bottom">
								<div class="col-12"><span class="h5 mb-1 fw-700 border-bottom" style="color:#1fa774">Moedas</span></div>
								<div class="col-3  mt-3">								
									<input type="text" name="" class="inputCedula">
									<small class="d-block text-center mt-1 h5 mb-0 fw-700">(R$0,02)</small>
								</div>
								<div class="col-3 mt-3">
									<input type="text" name="" class="inputCedula">
									<small class="d-block text-center mt-1 h5 mb-0 fw-700">(R$0,05)</small>
								</div>
								<div class="col-3  mt-3">
									<input type="text" name="" class="inputCedula">
									<small class="d-block text-center mt-1 h5 mb-0 fw-700">(R$0,10)</small>
								</div>
								<div class="col-3 mt-3">
									<input type="text" name="" class="inputCedula">
									<small class="d-block text-center mt-1 h5 mb-0 fw-700">(R$0,25)</small>
								</div>
								<div class="col-3 mt-3">
									<input type="text" name="" class="inputCedula">
									<small class="d-block text-center mt-1 h5 mb-0 fw-700">(R$0,50)</small>
								</div>
								<div class="col-3 mt-3">
									<input type="text" name="" class="inputCedula">
									<small class="d-block text-center mt-1 h5 mb-0 fw-700">(R$1,00)</small>
								</div>
							</div>
						</div>
						</div>
						
						<div class="rows p-3 py-2 border-bottom">
							<div class="col-6">								
								<div class="border radius-4 p-2">								
									<div class="rows">								
										<div class="col-6 d-flex">	
											<i class="fas fa-credit-card h1 mr-1 mb-0 text-azul"></i>
											<div>
												<small>Total em débito</small>
												<h1>R$100,00</h1>
											</div>								
										</div>								
										<div class="col-6 d-flex">	
											<i class="fas fa-calculator h1 mr-1 mb-0 text-azul"></i>
											<input type="text" value="150,00" class="form-campo h3 mb-0 fw-700" style="text-align:right">
										</div>
									</div>
								</div>
							</div>
							<div class="col-6">						
								<div class="border radius-4 p-2">								
									<div class="rows">								
										<div class="col-6 d-flex">	
											<i class="fas fa-cart-plus h1 mr-1 mb-0 text-azul"></i>
											<div>
												<small>Total em crédito</small>
												<h1>R$100,00</h1>
											</div>								
										</div>								
										<div class="col-6 d-flex"> 	
											<i class="fas fa-calculator h1 mr-1 mb-0 text-azul"></i>
											<input type="text" value="150,00" class="form-campo h3 mb-0 fw-700" style="text-align:right">
										</div>
									</div>
								</div>
							</div>
							<div class="col-6 mt-2">						
								<div class="border radius-4 p-2">								
									<div class="rows">								
										<div class="col-12">	
											<div>
												<span class="h4 mb-1">Total da conferência</span>
												<input type="text" value="" class="form-campo h3 mb-0 fw-700">
											</div>								
										</div>
									</div>
								</div>
							</div>
							<div class="col-6 mt-2">						
								<div class="border radius-4 p-2">								
									<div class="rows">								
										<div class="col-12">	
											<div>
												<span class="h4 mb-1">Total da diferência</span>
												<input type="text" value="" class="form-campo h3 mb-0 fw-700">
											</div>								
										</div>
									</div>
								</div>
							</div>
=======
				<div class="col-9">
					<div class="caixa p-2">
						<div class="rows py-3 pt-0 border-bottom">
							<div class="col-12"><span class="h5 mb-1 fw-700 border-bottom" style="color:#1fa774">Cédulas</span></div>								
							<div class="col">								
								<input type="text" name="" class="inputCedula">
								<small class="d-block text-center mt-1 h5 mb-0 fw-700">(R$2,00)</small>
							</div>
							<div class="col">
								<input type="text" name="" class="inputCedula">
								<small class="d-block text-center mt-1 h5 mb-0 fw-700">(R$5,00)</small>
							</div>
							<div class="col">
								<input type="text" name="" class="inputCedula">
								<small class="d-block text-center mt-1 h5 mb-0 fw-700">(R$10,00)</small>
							</div>
							<div class="col">
								<input type="text" name="" class="inputCedula">
								<small class="d-block text-center mt-1 h5 mb-0 fw-700">(R$20,00)</small>
							</div>
							<div class="col">
								<input type="text" name="" class="inputCedula">
								<small class="d-block text-center mt-1 h5 mb-0 fw-700">(R$50,00)</small>
							</div>
							<div class="col">
								<input type="text" name="" class="inputCedula">
								<small class="d-block text-center mt-1 h5 mb-0 fw-700">(R$100,00)</small>
							</div>
							<div class="col">
								<input type="text" name="" class="inputCedula">
								<small class="d-block text-center mt-1 h5 mb-0 fw-700">(R$200,00)</small>
							</div>
						</div>
						
						<div class="rows py-3 pt-2 border-bottom">
							<div class="col-12"><span class="h5 mb-1 fw-700 border-bottom" style="color:#1fa774">Moedas</span></div>
							<div class="col">								
								<input type="text" name="" class="inputCedula">
								<small class="d-block text-center mt-1 h5 mb-0 fw-700">(R$0,02)</small>
							</div>
							<div class="col">
								<input type="text" name="" class="inputCedula">
								<small class="d-block text-center mt-1 h5 mb-0 fw-700">(R$0,05)</small>
							</div>
							<div class="col">
								<input type="text" name="" class="inputCedula">
								<small class="d-block text-center mt-1 h5 mb-0 fw-700">(R$0,10)</small>
							</div>
							<div class="col">
								<input type="text" name="" class="inputCedula">
								<small class="d-block text-center mt-1 h5 mb-0 fw-700">(R$0,25)</small>
							</div>
							<div class="col">
								<input type="text" name="" class="inputCedula">
								<small class="d-block text-center mt-1 h5 mb-0 fw-700">(R$0,50)</small>
							</div>
							<div class="col">
								<input type="text" name="" class="inputCedula">
								<small class="d-block text-center mt-1 h5 mb-0 fw-700">(R$1,00)</small>
							</div>
						</div>
						
						<div class="rows p-3 py-2 border-bottom">
							<div class="col-6">								
								<div class="border radius-4 p-2">								
									<div class="rows">								
										<div class="col-6 d-flex">	
											<i class="fas fa-credit-card h1 mr-1 mb-0 text-azul"></i>
											<div>
												<small>Total em débito</small>
												<h1>R$100,00</h1>
											</div>								
										</div>								
										<div class="col-6 d-flex">	
											<i class="fas fa-calculator h1 mr-1 mb-0 text-azul"></i>
											<input type="text" value="150,00" class="form-campo h3 mb-0 fw-700" style="text-align:right">
										</div>
									</div>
								</div>
							</div>
							<div class="col-6">						
								<div class="border radius-4 p-2">								
									<div class="rows">								
										<div class="col-6 d-flex">	
											<i class="fas fa-cart-plus h1 mr-1 mb-0 text-azul"></i>
											<div>
												<small>Total em crédito</small>
												<h1>R$100,00</h1>
											</div>								
										</div>								
										<div class="col-6 d-flex"> 	
											<i class="fas fa-calculator h1 mr-1 mb-0 text-azul"></i>
											<input type="text" value="150,00" class="form-campo h3 mb-0 fw-700" style="text-align:right">
										</div>
									</div>
								</div>
							</div>
							<div class="col-6 mt-2">						
								<div class="border radius-4 p-2">								
									<div class="rows">								
										<div class="col-12">	
											<div>
												<span class="h4 mb-1">Total da conferência</span>
												<input type="text" value="" class="form-campo h3 mb-0 fw-700">
											</div>								
										</div>
									</div>
								</div>
							</div>
							<div class="col-6 mt-2">						
								<div class="border radius-4 p-2">								
									<div class="rows">								
										<div class="col-12">	
											<div>
												<span class="h4 mb-1">Total da diferência</span>
												<input type="text" value="" class="form-campo h3 mb-0 fw-700">
											</div>								
										</div>
									</div>
								</div>
							</div>
>>>>>>> f14014b313db34822af7e840627c47c9e775d279
						</div>
						
						<div class="rows pt-1">
							<div class="col-12">
								<div class="tfooter border-0 p-1 justify-content-space-between">
									<div class="d-flex">
										<a href="" class="btn btn-azul">Iniciar contagem</a>
										<a href="" class="btn btn-azul ml-1">Guardar contagem</a>
									</div>
									<div class="d-flex">
										<a href="" class="btn btn-verde">Encerrar conferência</a>
										<a href="" class="btn btn-vermelho ml-1">Cancelar</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-3 d-flex">
<<<<<<< HEAD
					<div class="caixa mb-0">
=======
					<div class="caixa">
>>>>>>> f14014b313db34822af7e840627c47c9e775d279
						<div class="p-1">
							<div class="radius-4 border mb-1">
								<div class="d-flex" style="padding: 0.3rem 1rem!important;">
									<i class="fas  fa-dollar-sign h2 mr-1 mb-0 text-verde"></i>
									<div>
										<small>Recebido em dinheiro</small>
										<h1>R$ 100,00</h1>							
									</div>
								</div>
							</div>
							<div class="radius-4 border mb-1">
								<div class="d-flex" style="padding: 0.3rem 1rem!important;">
									<i class="fas  fa-arrow-up h2 mr-1 mb-0 text-azul"></i>
									<div>
										<small>Abertura mais reforços</small>
										<h1>R$ 100,00</h1>							
									</div>
								</div>
							</div>
							<div class="radius-4 border mb-1">
								<div class="d-flex" style="padding: 0.3rem 1rem!important;">
									<i class="fas  fa-arrow-down h2 mr-1 mb-0 text-azul"></i>
									<div>
										<small>Sangria (retiradas)</small>
										<h1>R$ 500,00</h1>							
									</div>
								</div>
							</div>
							<div class="radius-4 border mb-1">
								<div class="d-flex" style="padding: 0.3rem 1rem!important;">
									<i class="fas  fa-cash-register h2 mr-1 mb-0" style="color:#ffca00"></i>
									<div>
										<small>Total de dinheiro em caixa</small>
										<h1>R$ 1500,00</h1>							
									</div>
								</div>
							</div>
							<div class="radius-4 border mb-1">
								<div class="d-flex" style="padding: 0.3rem 1rem!important;">
									<div>
										<small><b>Total da contagem</b></small>
										<input type="text" class="form-campo h4 mb-0 mt-1">							
									</div>
								</div>
							</div>
							
							<div class="radius-4 border mb-1">
								<div class="d-flex" style="padding: 0.3rem 1rem!important;">
									<i class="iconePix"></i>
									<div>
										<small>Total em Pix</small>
										<h1>R$ 1500,00</h1>							
									</div>
								</div>
							</div>
							
							<div class="radius-4 text-center mb-1">
									<a href="" class="btn btn-azul">Contagem não iniciada</a>								
							</div>
							
							<div class="radius-4 text-center mb-1 py-1 text-uppercase" style="background:#111;color:#fff">
								<small>Valor do fechamento já calculado</small>	
								<h1 class="py-1">R$ 100,00</h1>								
							</div>
						</div>
					</div>
				</div>
		</div>
	</div>
</div>
@endsection