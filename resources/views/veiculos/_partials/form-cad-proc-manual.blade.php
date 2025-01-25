

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Veículos</a></li>
                    <li class="breadcrumb-item active">Novo veículo</li>
                </ol>
            </div>
            <h3 class="page-title">Novo veículo</h3>
        </div>
    </div>
</div>
<br>

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
{{-- <script>
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
</script> --}}
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                    <h5 class="mb-4 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle me-1"></i> Informações pessoais</h5>
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
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Endereço: <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="endereco" required>
                            </div>
                        </div>
                    </div> <!-- end row -->

                    
                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-earth me-1"></i> Informações do veículo</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Marca: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="marca" id="marca" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Placa: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="placa" id="placa" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Chassi: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="chassi" id="chassi" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Cor: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="cor" id="cor" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Ano/Modelo: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="ano_modelo" id="ano_modelo" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Renavam: <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="renavam" id="renavam" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Tipo de Doc: <span style="color: red;">*</span></label>
                                <select class="form-select mb-3" name="tipo_doc" required>
                                    <option selected value="">Selecione o tipo</option>
                                    <option value="Digital">Digital</option>
                                    <option value="***">Físico</option>
                                </select> 
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="social-insta" class="form-label">Tipo de veículo: <span style="color: red;">*</span></label>
                                <select class="form-select mb-3" name="tipo" required>
                                    <option selected value="">Selecione o tipo</option>
                                    <option value="Carro">Carro</option>
                                    <option value="Moto">Moto</option>
                                    <option value="Caminhonete">Caminhonete</option>
                                </select> 
                            </div>
                        </div>

                                                                                   
 
                    </div>       
                    
                    <div class="row">
                        <div class="col-lg-6">
                        </div>
                        <div class="col-lg-6 text-end">
                            <a href="{{ route('veiculos.index')}}" class="btn btn-secondary btn-sm">Voltar</a>
                            <button type="submit" class="btn btn-success btn-sm">Cadastrar</button>
                        </div>
                    </div>
            </div> <!-- end card body -->
        </div> <!-- end card -->
        
    </div>
    
</div>

