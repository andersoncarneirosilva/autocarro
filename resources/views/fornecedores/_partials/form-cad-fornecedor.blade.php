<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle me-1"></i> Informações Gerais</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">CNPJ</label>
                                <input type="text" class="form-control" name="cnpj">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Razão Social</label>
                                <input type="text" class="form-control" name="razao_social">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Nome Fantasia</label>
                                <input type="text" class="form-control" name="nome_fantasia">
                            </div>
                        </div>
                    </div> 

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Representante</label>
                                <input type="tel" class="form-control" name="representante" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Telefone</label>
                                <input type="tel" class="form-control" name="telefone" onkeyup="handlePhone(event)" />
                            </div>
                        </div>
                    </div> <!-- end row -->


                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-earth me-1"></i> Informações Fiscais</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">IPI</label>
                                <input type="tel" class="form-control" name="ipi"/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">ICMS</label>
                                <input type="tel" class="form-control" name="icms"/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">MC</label>
                                <input type="tel" class="form-control" name="margem"/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">MARCADOR</label>
                                <input type="tel" class="form-control" name="marcador"/>
                            </div>
                        </div>
                    </div>

                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-earth me-1"></i> PEDIDO/ENTREGA</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Valor do pedido</label>
                                <input type="tel" class="form-control" name="valor_pedido_minimo" />
                            </div>
                            
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Prazo de faturamento</label>
                                <input type="tel" class="form-control" name="prazo_faturamento"/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="useremail" class="form-label">Tipo de frete</label>
                                <select class="form-select" name="tipo_frete">
                                    <option value="">Selecione o frete</option>
                                    <option value="CIF">CIF</option>
                                    <option value="FOBss">FOB</option>
                                  </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Transportadora</label>
                                <select class="form-select" name="transportadora">
                                    <option value="">Selecione a transportadora</option>
                                    @foreach ($trans as $tran)
                                    <option value="{{ $tran->razao_social }}">{{ $tran->razao_social }}</option>    
                                    @endforeach
                                  </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                        </div>
                        <div class="col-lg-6 text-end">
                        <button type="submit" class="btn btn-success btn-sm">Cadastrar</button>
                        </div>
                    </div>

            </div> <!-- end card body -->
        </div> <!-- end card -->
    </div>
    
</div>
