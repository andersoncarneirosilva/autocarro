<script>
    // Função para consulta de CEP (ViaCEP)
    function pesquisacep(valor) {
        var cep = valor.replace(/\D/g, '');
        if (cep != "") {
            // CORREÇÃO: Removida a flag 'B' inválida
            var validacep = /^[0-9]{8}$/; 
            
            if(validacep.test(cep)) {
                document.getElementById('rua').value = "...";
                document.getElementById('bairro').value = "...";
                document.getElementById('cidade').value = "...";
                document.getElementById('uf').value = "...";

                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(dados => {
                        if (!("erro" in dados)) {
                            document.getElementById('rua').value = dados.logradouro.toUpperCase();
                            document.getElementById('bairro').value = dados.bairro.toUpperCase();
                            document.getElementById('cidade').value = dados.localidade.toUpperCase();
                            document.getElementById('uf').value = dados.uf.toUpperCase();
                            document.getElementById('numero').focus();
                        } else {
                            alert("CEP não encontrado.");
                            limpa_formulário_cep();
                        }
                    })
                    .catch(() => alert("Erro ao consultar o CEP."));
            }
        }
    }

    function limpa_formulário_cep() {
        document.getElementById('rua').value = "";
        document.getElementById('bairro').value = "";
        document.getElementById('cidade').value = "";
        document.getElementById('uf').value = "";
    }

    // Função para Máscara de Telefone
    function handlePhone(event) {
        let input = event.target;
        input.value = phoneMask(input.value);
    }

    function phoneMask(value) {
    if (!value) return "";
    
    // 1. Remove tudo o que não for número
    value = value.replace(/\D/g, '');
    
    // 2. Limita a 11 dígitos (DDD + 9 dígitos)
    if (value.length > 11) {
        value = value.slice(0, 11);
    }

    // 3. Aplica a formatação dinamicamente
    if (value.length > 10) {
        // Formato Celular: (00) 00000-0000
        value = value.replace(/^(\d{2})(\d{5})(\d{4})/, "($1) $2-$3");
    } else if (value.length > 5) {
        // Formato Fixo: (00) 0000-0000
        value = value.replace(/^(\d{2})(\d{4})(\d{0,4})/, "($1) $2-$3");
    } else if (value.length > 2) {
        // Formato apenas com DDD: (00) 000...
        value = value.replace(/^(\d{2})(\d{0,5})/, "($1) $2");
    } else {
        // Apenas os primeiros dígitos
        value = value.replace(/^(\d*)/, "$1");
    }
    
    return value;
}

    document.addEventListener('DOMContentLoaded', function () {
        // Máscara CPF
        document.getElementById('cpf').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 11) value = value.slice(0, 11);
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            e.target.value = value;
        });

        // Máscara CEP
        document.getElementById('cep').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 8) value = value.slice(0, 8);
            value = value.replace(/^(\d{5})(\d)/, '$1-$2');
            e.target.value = value;
        });

        // Forçar Maiúsculas
        document.addEventListener('input', function (e) {
            const idsParaMaiusculo = ['nome_cliente', 'rua', 'bairro', 'cidade', 'uf', 'complemento'];
            if (idsParaMaiusculo.includes(e.target.id)) {
                e.target.value = e.target.value.toUpperCase();
            }
        });

        // Validação no Submit (Ajustado para funcionar com o seu form)
        // Certifique-se de que o <form> tenha id="form-cadastro" ou use o seletor correto
        const form = document.querySelector('form'); 
        if(form) {
            form.addEventListener('submit', function (e) {
                const cpfInput = document.getElementById('cpf').value;
                if (!validarCPF(cpfInput)) {
                    e.preventDefault();
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'CPF Inválido!',
                            text: 'O CPF informado não é válido.',
                            timer: 5000,
                            timerProgressBar: true,
                        });
                    } else {
                        alert("CPF Inválido!");
                    }
                }
            });
        }
    });

    function validarCPF(cpf) {
        cpf = cpf.replace(/[^\d]+/g, '');
        if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) return false;
        let soma = 0, resto;
        for (let i = 1; i <= 9; i++) soma = soma + parseInt(cpf.substring(i-1, i)) * (11 - i);
        resto = (soma * 10) % 11;
        if ((resto == 10) || (resto == 11)) resto = 0;
        if (resto != parseInt(cpf.substring(9, 10))) return false;
        soma = 0;
        for (let i = 1; i <= 10; i++) soma = soma + parseInt(cpf.substring(i-1, i)) * (12 - i);
        resto = (soma * 10) % 11;
        if ((resto == 10) || (resto == 11)) resto = 0;
        if (resto != parseInt(cpf.substring(10, 11))) return false;
        return true;
    }
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
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">RG: <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="rg" id="rg" maxlength="10" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">CPF: <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="cpf" id="cpf" maxlength="14" required>
                            </div>
                        </div>
                    </div>

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
                        <div class="col-md-4 col-lg-3">
                            <label for="cidade" class="form-label">Cidade: <span style="color: red;">*</span></label>
                            <div class="input-group">
                                <input type="text" name="cidade" id="cidade" class="form-control" required>
                            </div>
                        </div>
                    
                        <!-- Estado -->
                        <div class="col-md-2 col-lg-3">
                            <label for="uf" class="form-label">Estado: <span style="color: red;">*</span></label>
                            <div class="input-group">
                                <input type="text" name="estado" id="uf" class="form-control" maxlength="2" required>
                            </div>
                        </div>
                    
                        <!-- Complemento -->
                        <div class="col-md-6 col-lg-6">
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