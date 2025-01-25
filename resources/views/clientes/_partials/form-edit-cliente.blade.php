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
            <label for="cep" class="form-label">CEP</label>
            <div class="input-group">
                <input type="text" name="cep" class="form-control" id="cep" onblur="pesquisacep(this.value);" value="{{ $cliente->cep ?? old('cep') }}" />
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="mb-2">
            <label for="rua" class="form-label">Logradouro</label>
            <div class="input-group">
                <input type="text" name="endereco" id="rua" class="form-control" value="{{ $cliente->endereco ?? old('endereco') }}"/>
            </div>
        </div>
    </div>
    <div class="col-md-1">
        <div class="mb-2">
            <label for="numero" class="form-label">Número</label>
            <div class="input-group">
                <input type="text" name="numero" id="numero" class="form-control" value="{{ $cliente->numero ?? old('numero') }}"/>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="mb-3">
            <label for="bairro" class="form-label">Bairro</label>
            <div class="input-group">
                <input type="text" name="bairro" id="bairro" class="form-control" value="{{ $cliente->bairro ?? old('bairro') }}"/>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="mb-3">
            <label for="cidade" class="form-label">Cidade</label>
            <div class="input-group">
                <input type="text" name="cidade" id="cidade" class="form-control" value="{{ $cliente->cidade ?? old('cidade') }}"/>
            </div>
        </div>
    </div>
    <div class="col-md-1">
        <div class="mb-3">
            <label for="uf" class="form-label">Estado</label>
            <div class="input-group">
                <input type="text" name="estado" id="uf" class="form-control" value="{{ $cliente->estado ?? old('estado') }}"/>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="mb-3">
            <label for="complemento" class="form-label">Complemento</label>
            <div class="input-group">
                <input type="text" name="complemento" id="complemento" class="form-control" value="{{ $cliente->complemento ?? old('complemento') }}"/>
            </div>
        </div>
    </div>
</div> <!-- end row -->

                    <br>                    
                    
                    <div class="row">
                        <div class="col-lg-6">
                        </div>
                        <div class="col-lg-6 text-end">
                            <a href="{{ route('clientes.index')}}" class="btn btn-secondary btn-sm">Cancelar</a>
                            <button type="submit" class="btn btn-success btn-sm">Atualizar</button>
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
    document.getElementById('edit-user-form').addEventListener('submit', function (e) {
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