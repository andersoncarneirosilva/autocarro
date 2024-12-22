<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('cpf').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove caracteres não numéricos
            if (value.length > 11) value = value.slice(0, 11); // Limita ao tamanho máximo do CPF
            value = value.replace(/(\d{3})(\d)/, '$1.$2'); // Adiciona o primeiro ponto
            value = value.replace(/(\d{3})(\d)/, '$1.$2'); // Adiciona o segundo ponto
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2'); // Adiciona o hífen
            e.target.value = value;
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('cep').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove caracteres não numéricos
            if (value.length > 8) value = value.slice(0, 8); // Limita ao tamanho do CEP

            // Adiciona o ponto e o hífen no formato 00.000-000
            value = value.replace(/(\d{2})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,3})$/, '$1-$2');

            e.target.value = value;
        });
    });
</script>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                    <h5 class="mb-4 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle me-1"></i> Informações pessoais</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nome</label>
                                <input type="text" class="form-control" name="nome" value="{{ $cliente->nome ?? old('nome') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">CPF</label>
                                <input type="text" class="form-control" name="cpf" id="cpf" value="{{ $cliente->cpf ?? old('cpf') }}">
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Fone/Whatsapp</label>
                                <input type="text" class="form-control" name="fone" id="fone" value="{{ $cliente->fone ?? old('fone') }}" onkeyup="handlePhone(event)"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control" name="email" value="{{ $cliente->email ?? old('email') }}">
                            </div>
                        </div>
                    </div> <!-- end row -->


                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-earth me-1"></i> Endereço</h5>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="social-fb" class="form-label">CEP</label>
                                <div class="input-group">
                                    <input type="text"  name="cep" class="form-control"id="cep" onblur="pesquisacep(this.value);" value="{{ $cliente->cep ?? old('cep') }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="social-fb" class="form-label">Logradouro</label>
                                <div class="input-group">
                                    <input type="text" name="endereco" id="rua" class="form-control" value="{{ $cliente->endereco ?? old('endereco') }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Bairro</label>
                                <div class="input-group">
                                    <input type="text" name="bairro" id="bairro" class="form-control" value="{{ $cliente->bairro ?? old('bairro') }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Cidade</label>
                                <div class="input-group">
                                    <input type="text" name="cidade" id="cidade" class="form-control" value="{{ $cliente->cidade ?? old('cidade') }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Estado</label>
                                <div class="input-group">
                                    <input type="text" name="estado" id="uf" class="form-control" value="{{ $cliente->estado ?? old('estado') }}"/>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row -->


                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-account-box me-1"></i> Documento veícular</h5>
                    <div class="row">
                        <div class="col">
                            <label class="form-label">Arquivo</label>
                            <div class="input-group">
                                
                                <input class="form-control" type="file" name="arquivo_doc_veiculo">
                            </div>
                        </div>
                    </div> <!-- end row -->
                    <br>                    
                    
                    <div class="row">
                        <div class="col-lg-6">
                        </div>
                        <div class="col-lg-6 text-end">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" onclick="form.reset();" class="btn btn-warning btn-sm">Limpar</button>
                        <button type="submit" class="btn btn-success btn-sm">Cadastrar</button>
                        </div>
                    </div>
            </div> <!-- end card body -->
        </div> <!-- end card -->
        
    </div>
    
</div>
