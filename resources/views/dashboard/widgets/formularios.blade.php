<div class="row">
    <!-- Primeira coluna -->
    <div class="col-md-6">
        <div class="card">
            <h5 class="card-title">Gerar procuração</h5>
            <div class="card-body">
                <form action="{{ route('procrapida.store') }}" method="POST" enctype="multipart/form-data" id="formProc">
                    @csrf
                    <div class="mb-3">
                        <label>Endereço: <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" name="endereco" required>
                    </div>
                    <div class="mb-3">
                        <label>Documento: <span style="color: red;">*</span></label>
                        <input class="form-control" type="file" name="arquivo_doc" id="arquivo_doc" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                    <br><br>
                    @if(session('success'))
                        <div class="alert alert-success bg-transparent text-success" role="alert">
                            {{ session('success') }}
                            @if(session('links'))
                                <p>{!! session('links')['linkVisualizar'] !!}</p>
                                <p>{!! session('links')['linkBaixar'] !!}</p>
                            @endif
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <!-- Segunda coluna -->
    <div class="col-md-6">
        <div class="card">
            <h5 class="card-title">Gerar ATPVE</h5>
            <div class="card-body">
                <form action="{{ route('gerar.atpve') }}" method="POST" enctype="multipart/form-data" id="formProc">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="social-fb" class="form-label">CEP: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="cep" id="cep" onblur="pesquisacep(this.value);" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="social-fb" class="form-label">Logradouro: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="endereco" id="rua" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Número: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="numero" id="numero" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Bairro: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="bairro" id="bairro" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Cidade: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="cidade" id="cidade" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Estado: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="estado" id="uf" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Complemento: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="complemento" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Valor: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="valor" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Documento: <span style="color: red;">*</span></label>
                        <input class="form-control" type="file" name="arquivo_doc" id="arquivo_doc" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                    <br><br>
                    @if(session('success-atpve'))
                        <div class="alert alert-success bg-transparent text-success" role="alert">
                            {{ session('success-atpve') }}
                            @if(session('links'))
                                <p>{!! session('links')['linkVisualizar'] !!}</p>
                                <p>{!! session('links')['linkBaixar'] !!}</p>
                            @endif
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
