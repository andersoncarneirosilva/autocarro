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
                    <h5 class="mb-4 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle me-1"></i> ATPVE pessoais</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Nome: <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="nome" id="nome_cliente" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">CPF: <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="cpf" id="cpf" maxlength="14" required>
                            </div>
                        </div> <!-- end col -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Email:</label>
                                <input type="text" class="form-control" name="email" id="email" />
                            </div>
                        </div>
                    </div> <!-- end row -->


                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-earth me-1"></i> Endereço</h5>
                    <div class="row">
                        <div class="col-md">
                            <div class="mb-2">
                                <label for="social-fb" class="form-label">CEP: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="cep" id="cep" onblur="pesquisacep(this.value);" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-2">
                                <label for="social-fb" class="form-label">Logradouro: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="endereco" id="rua" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-2">
                                <label for="social-insta" class="form-label">Número: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="numero" id="numero" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Bairro: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="bairro" id="bairro" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Cidade: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="cidade" id="cidade" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Estado: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="estado" id="uf" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Complemento:</label>
                                <div class="input-group">
                                    <input type="text" name="complemento" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Valor: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="valor" class="form-control"/>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row -->
                   
                    <br>                    

                    <div class="row">
                        <div class="col-lg-6">
                        </div>
                        <div class="col-lg-6 text-end">
                            <a href="{{ route('estoque.index')}}" class="btn btn-secondary btn-sm">Cancelar</a>
                            <button type="submit" class="btn btn-success btn-sm">Cadastrar</button>
                        </div>
                    </div>
            </div> <!-- end card body -->
        </div> <!-- end card -->
        
    </div>
    
</div>



