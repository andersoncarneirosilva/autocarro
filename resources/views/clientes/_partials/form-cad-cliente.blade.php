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
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Seleciona todos os campos de entrada no formulário
        const campos = document.querySelectorAll('#nome_cliente');

        // Adiciona um ouvinte de evento em cada campo
        campos.forEach(campo => {
            campo.addEventListener('input', (event) => {
                // Força o valor para maiúsculas
                event.target.value = event.target.value.toUpperCase();
            });
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
                                <label class="form-label">Nome: <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="nome" id="nome_cliente" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">CPF: <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="cpf" id="cpf" maxlength="14" required>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Fone/Whatsapp: <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="fone" id="fone" onkeyup="handlePhone(event)" required/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email: <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="email" id="email_cliente" required>
                            </div>
                        </div>
                    </div> <!-- end row -->


                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-earth me-1"></i> Endereço</h5>
                    <div class="row g-3">
                        <!-- CEP -->
                        <div class="col-md-3 col-lg-2">
                            <label for="cep" class="form-label">CEP: <span style="color: red;">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="cep" id="cep" onblur="pesquisacep(this.value);" required>
                            </div>
                        </div>
                    
                        <!-- Logradouro -->
                        <div class="col-md-6 col-lg-4">
                            <label for="rua" class="form-label">Logradouro: <span style="color: red;">*</span></label>
                            <div class="input-group">
                                <input type="text" name="endereco" id="rua" class="form-control" required>
                            </div>
                        </div>
                    
                        <!-- Número -->
                        <div class="col-md-3 col-lg-2">
                            <label for="numero" class="form-label">Número: <span style="color: red;">*</span></label>
                            <div class="input-group">
                                <input type="text" name="numero" id="numero" class="form-control" required>
                            </div>
                        </div>
                    
                        <!-- Bairro -->
                        <div class="col-md-6 col-lg-4">
                            <label for="bairro" class="form-label">Bairro: <span style="color: red;">*</span></label>
                            <div class="input-group">
                                <input type="text" name="bairro" id="bairro" class="form-control" required>
                            </div>
                        </div>
                    
                        <!-- Cidade -->
                        <div class="col-md-6 col-lg-3">
                            <label for="cidade" class="form-label">Cidade: <span style="color: red;">*</span></label>
                            <div class="input-group">
                                <input type="text" name="cidade" id="cidade" class="form-control" required>
                            </div>
                        </div>
                    
                        <!-- Estado -->
                        <div class="col-md-3 col-lg-2">
                            <label for="uf" class="form-label">Estado: <span style="color: red;">*</span></label>
                            <div class="input-group">
                                <input type="text" name="estado" id="uf" class="form-control" maxlength="2" required>
                            </div>
                        </div>
                    
                        <!-- Complemento -->
                        <div class="col-md-6 col-lg-4">
                            <label for="complemento" class="form-label">Complemento:</label>
                            <div class="input-group">
                                <input type="text" name="complemento" id="complemento" class="form-control">
                            </div>
                        </div>
                    </div>
                    


                    <br>                    
                    
                    <div class="row">
                        <div class="col-lg-6">
                        </div>
                        <div class="col-lg-6 text-end">
                            <a href="{{ route('clientes.index')}}" class="btn btn-secondary btn-sm">Cancelar</a>
                            <button type="submit" class="btn btn-success btn-sm">Cadastrar</button>
                        </div>
                    </div>
            </div> <!-- end card body -->
        </div> <!-- end card -->
        
    </div>
    
</div>

<script>
    // Função para validar CPF
    function validarCPF(cpf) {
        // Remove caracteres não numéricos
        cpf = cpf.replace(/[^\d]+/g, '');

        // Verifica se o CPF tem 11 dígitos ou é uma sequência repetida
        if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) {
            return false;
        }

        // Função para calcular os dígitos verificadores
        function calcularDigito(base) {
            let soma = 0;
            for (let i = 0; i < base.length; i++) {
                soma += base[i] * (base.length + 1 - i);
            }
            const resto = soma % 11;
            return resto < 2 ? 0 : 11 - resto;
        }

        // Calcula o primeiro dígito verificador
        const primeiroDigito = calcularDigito(cpf.slice(0, 9));

        // Verifica o primeiro dígito
        if (primeiroDigito !== parseInt(cpf[9], 10)) {
            return false;
        }

        // Calcula o segundo dígito verificador
        const segundoDigito = calcularDigito(cpf.slice(0, 10));

        // Verifica o segundo dígito
        return segundoDigito === parseInt(cpf[10], 10);
    }

    // Adiciona evento no envio do formulário
    document.getElementById('form-cadastro').addEventListener('submit', function (e) {
        e.preventDefault(); // Impede o envio do formulário para verificar antes
        const cpfInput = document.getElementById('cpf');

        if (validarCPF(cpfInput.value)) {
            // CPF válido, aqui você pode prosseguir com o envio do formulário
            //alert('CPF válido!');
             e.target.submit(); // Envia o formulário caso o CPF seja válido
        } else {
            // Exibe o SweetAlert com erro por 5 segundos
            Swal.fire({
                icon: 'error',
                title: 'CPF Inválido!',
                text: 'O CPF informado não é válido.',
                timer: 5000, // Exibe por 5 segundos
                showConfirmButton: true, // Remove o botão de confirmação
                timerProgressBar: true,
            });
        }
    });
</script>