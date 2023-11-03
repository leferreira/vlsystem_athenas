@extends("pdv/template")
@section("conteudo")
    <div class="Home" @keyup.enter="adicionarNoCarrinho">
        <div class="conteudo">
            <div class="rows">
                <div class="col-12 mb-3">
                    <div class="migalha">
                        <a href="" class="mp1 ativo"> <small><span>1</span>Nova venda</small></a>
                        <a href="" class="mp1"><small><span>2</span> Pagamento</small></a>
                        <a href="" class="mp1"><small><span>3</span> Finalizar venda</small></a>
                    </div>
                    <div class="rows">
                        <div class="col-6 mb-3">
                            <select placeholder="Produto" id="select-produtos" class="form-campo">
                                <option></option>
                            </select>
                        </div>
                        <div class="col-2 mb-3">
                            <input type="text" placeholder="Quantidade" class="form-campo" v-model="quantidadeAdicionar">
                        </div>
                        <div class="col-2 mb-3">
                            <input type="text" placeholder="Valor" class="form-campo" disabled v-model="produtoAdicionar.preco_venda">
                        </div>
                        <div class="col-2 mb-3">
                            <input type="text" placeholder="Total" class="form-campo" disabled v-model="produtoAdicionar.preco_total">
                        </div>

                        <div class="col-12 mb-3">
                            <div class="caixa home">
                                <table width="100%" cellpadding="0" cellspacing="0" class="tabela clear" id="">
                                    <thead>
                                    <tr>
                                        <th align="left">Produto</th>
                                        <th align="center">Quantidade</th>
                                        <th align="center">Valor</th>
                                        <th align="center">Total</th>
                                        <th align="center">Ação</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr v-for="(c, index) in produtosNoCarrinho">
                                        <td>@{{ c.descricao }}</td>
                                        <td align="center" width="30">
                                            <input v-model="carrinho[index].quantidade" type="number" value="1" class="form-campo text-center">
                                        </td>
                                        <td align="center">@{{ c.preco_venda }}</td>
                                        <td align="center">@{{ c.preco_total }}</td>
                                        <td align="center">
                                            <a href="#" class="btn excluir" title="Excluir" @click="removerCarrinho($event, index)">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            <a href="#" class="btn editar" title="Desconto">
                                                <i class="fas fa-dollar-sign"></i>
                                            </a>
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <div class="caixa preco">
                                <div class="rows">
                                    <div class="col-8">
                                        <div class="grid-preco">
                                            <div>
                                                <small>Desconto</small>
                                                <h4>0,00</h4>
                                            </div>
                                            <div>
                                                <small>Recebido</small>
                                                <h4>0,00</h4>
                                            </div>
                                            <div>
                                                <small>Troca</small>
                                                <h4>0,00</h4>
                                            </div>
                                            <div class="total">
                                                <small>Total</small>
                                                <h4>@{{valorTotalItens}}</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 d-flex text-end align-vertical-center">
                                        <a href="#" @click="salvarNaSessao" class="btn btn-azul btn-grande  ml-3">
                                            Continuar <i class="fas fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <a href="javascript:;" onclick="abrirModal('#janela1')" class="link-azul novoAdd" title="Novo produto"><i
                class="fas fa-plus-circle"></i></a>
    </div>


    <div class="window form" id="janela1">
        <div class="titulo mb-4">Novo produto</div>
        <div class="p-4 pt-0">
            <form action="">
                <div class="rows">
                    <div class="col-6 mb-3">
                        <input type="text" name="" placeholder="* Código do produto" class="form-campo">
                    </div>
                    <div class="col-6 mb-3">
                        <input type="text" name="" placeholder="* Descrição do produto" class="form-campo">
                    </div>
                    <div class="col-6 mb-3">
                        <input type="text" name="" placeholder="* Valor do produto" class="form-campo">
                    </div>
                    <div class="col-6 mb-3">
                        <select class="form-campo">
                            <option selected>* Unidade de medida</option>
                            <option>Unidade de medida</option>
                            <option>Unidade de medida</option>

                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <input type="text" name="" placeholder="* Origem do produto" class="form-campo">
                    </div>
                    <div class="col-6 mb-3">
                        <select class="form-campo">
                            <option selected>* NCM</option>
                            <option>NCM</option>
                            <option>NCM</option>
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <select class="form-campo">
                            <option selected>* Transação do produto do PDV</option>
                            <option>NCM</option>
                            <option>NCM</option>
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <select class="form-campo">
                            <option selected> Transação do padrão de saída</option>
                            <option>NCM</option>
                            <option>NCM</option>
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <input type="text" name="" placeholder="Código GTIN/EAN(opciona)" class="form-campo">
                    </div>
                    <div class="col-6 mb-3">
                        <select class="form-campo">
                            <option selected> Vódigo CEST (opciona)</option>
                            <option>NCM</option>
                            <option>NCM</option>
                        </select>
                    </div>
                </div>
        </div>
        <div class="tfooter end">
            <button type="" class="btn btn-claro fechar">Fechar</button>
            <button type="submit" class="btn btn-azul">Salvar</button>
        </div>
        </form>
    </div>

    <div id="fundo_preto"></div>
@endsection
