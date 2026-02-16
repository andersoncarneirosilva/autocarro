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
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Nome: <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="nome" id="nome_cliente" value="{{ $cliente->nome ?? old('nome') }}" required>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Fone/Whatsapp: <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="fone" id="fone" value="{{ $cliente->fone ?? old('fone') }}" onkeyup="handlePhone(event)" required/>
            </div>
        </div>

        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email_cliente" value="{{ $cliente->email ?? old('email') }}">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Data de nascimento:</label>
                <input type="date" class="form-control" name="data_nascimento" value="{{ (isset($cliente->data_nascimento)) ? $cliente->data_nascimento->format('Y-m-d') : old('data_nascimento') }}">
            </div>
        </div>

        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Gênero</label>
                <select class="form-control" name="genero">
                    <option value="">Selecione...</option>
                    <option value="Masculino" {{ (old('genero', $cliente->genero) == 'Masculino') ? 'selected' : '' }}>Masculino</option>
                    <option value="Feminino" {{ (old('genero', $cliente->genero) == 'Feminino') ? 'selected' : '' }}>Feminino</option>
                    <option value="Outro" {{ (old('genero', $cliente->genero) == 'Outro') ? 'selected' : '' }}>Outro</option>
                </select>
            </div>
        </div>
    </div>

    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-earth me-1"></i> Endereço</h5>
    <div class="row g-3">
        <div class="col-md-3 col-lg-2">
            <label for="cep" class="form-label">CEP:</label>
            <input type="text" class="form-control" name="cep" id="cep" onblur="pesquisacep(this.value);" value="{{ $cliente->cep ?? old('cep') }}" required>
        </div>
    
        <div class="col-md-6 col-lg-4">
            <label for="rua" class="form-label">Logradouro:</label>
            <input type="text" name="endereco" id="rua" class="form-control" value="{{ $cliente->endereco ?? old('endereco') }}" required>
        </div>
    
        <div class="col-md-3 col-lg-2">
            <label for="numero" class="form-label">Número:</label>
            <input type="text" name="numero" id="numero" class="form-control" value="{{ $cliente->numero ?? old('numero') }}" required>
        </div>
    
        <div class="col-md-6 col-lg-4">
            <label for="bairro" class="form-label">Bairro:</label>
            <input type="text" name="bairro" id="bairro" class="form-control" value="{{ $cliente->bairro ?? old('bairro') }}" required>
        </div>
    
        <div class="col-md-4 col-lg-3">
            <label for="cidade" class="form-label">Cidade:</label>
            <input type="text" name="cidade" id="cidade" class="form-control" value="{{ $cliente->cidade ?? old('cidade') }}" required>
        </div>
    
        <div class="col-md-2 col-lg-3">
            <label for="uf" class="form-label">Estado:</label>
            <input type="text" name="estado" id="uf" class="form-control" maxlength="2" value="{{ $cliente->estado ?? old('estado') }}" required>
        </div>
    
        <div class="col-md-6 col-lg-6">
            <label for="complemento" class="form-label">Complemento:</label>
            <input type="text" name="complemento" id="complemento" class="form-control" value="{{ $cliente->complemento ?? old('complemento') }}">
        </div>
    </div>

    <br>                    
    
    <div class="row">
        <div class="col-lg-12 text-end">
            <a href="{{ route('clientes.index')}}" class="btn btn-secondary btn-sm">Cancelar</a>
            <button type="submit" class="btn btn-success btn-sm">
                <i class="feather feather-save me-1"></i> Atualizar
            </button>
        </div>
    </div>
</div>
        </div>
        
    </div>
    
</div>