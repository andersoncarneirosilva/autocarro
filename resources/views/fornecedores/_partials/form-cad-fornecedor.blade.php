<div class="row">
    <div class="col-lg-12 mx-auto">
        <div class="card shadow">
            <div class="card-body">
                <h5 class="mb-4 text-uppercase bg-light p-3 rounded"><i class="mdi mdi-account-circle me-1"></i> Informações Pessoais</h5>


                <!-- Razão social e nome fantasia -->
                <div class="row mb-3">
                    
                    <div class="col-md-4">
                        <label for="nome_fantasia" class="form-label">CNPJ</label>
                        <input type="text" id="cnpj" name="cnpj" class="form-control" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-outline-secondary w-100" onclick="buscarCNPJ()">Buscar</button>
                    </div>
                    <div class="col-md-6">
                        <label for="razao_social" class="form-label">Razão Social</label>
                        <input type="text" id="razao_social" name="razao_social" class="form-control" required>
                    </div>
                </div>

                <!-- Email e telefone -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" id="email" name="email" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" id="telefone" name="telefone" class="form-control">
                    </div>
                </div>

                <!-- Endereço: logradouro e número -->
                <div class="row mb-3">
                    <div class="col-md-8">
                        <label for="logradouro" class="form-label">Logradouro</label>
                        <input type="text" id="logradouro" name="logradouro" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label for="numero" class="form-label">Número</label>
                        <input type="text" id="numero" name="numero" class="form-control">
                    </div>
                </div>

                <!-- Bairro e CEP -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="bairro" class="form-label">Bairro</label>
                        <input type="text" id="bairro" name="bairro" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="cep" class="form-label">CEP</label>
                        <input type="text" id="cep" name="cep" class="form-control">
                    </div>
                </div>

                <!-- Cidade e Estado -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="cidade" class="form-label">Cidade</label>
                        <input type="text" id="cidade" name="cidade" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="estado" class="form-label">Estado</label>
                        <input type="text" id="estado" name="estado" class="form-control">
                    </div>
                </div>

                <!-- Botões -->
                <div class="text-end">
                    <a href="{{ route('clientes.index')}}" class="btn btn-secondary btn-sm">Cancelar</a>
                    <button type="submit" class="btn btn-success btn-sm">Cadastrar</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
function buscarCNPJ() {
    const cnpj = document.getElementById('cnpj').value.replace(/\D/g, '');
    if (cnpj.length !== 14) {
        alert("CNPJ inválido");
        return;
    }

    fetch(`/consulta-cnpj/${cnpj}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'ERROR') {
                alert(data.message || "Erro ao consultar CNPJ");
                return;
            }

            document.getElementById('razao_social').value = data.nome || '';
            document.getElementById('email').value = data.email || '';
            document.getElementById('telefone').value = data.telefone || '';
            document.getElementById('logradouro').value = data.logradouro || '';
            document.getElementById('numero').value = data.numero || '';
            document.getElementById('bairro').value = data.bairro || '';
            document.getElementById('cidade').value = data.municipio || '';
            document.getElementById('estado').value = data.uf || '';
            document.getElementById('cep').value = data.cep || '';
        })
        .catch(error => {
            console.error("Erro na consulta:", error);
            alert("Erro ao consultar o CNPJ.");
        });
}

</script>