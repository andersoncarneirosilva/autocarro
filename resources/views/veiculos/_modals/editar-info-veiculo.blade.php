<div class="modal fade" id="modalEditarInfoVeiculo" tabindex="-1" aria-labelledby="modalEditarInfoVeiculoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalEditarInfoVeiculoLabel text-white">
                    <i class="mdi mdi-pencil me-2"></i>Editar Dados do Veículo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('veiculos.update-info', $veiculo->id) }}" method="POST" id="formDoc">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Placa</label>
                            <input type="text" name="placa" class="form-control mask-placa" 
                                value="{{ $veiculo->placa }}" 
                                placeholder="ABC1D23"
                                maxlength="7"
                                style="text-transform: uppercase;">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Placa Anterior</label>
                            <input type="text" name="placaAnterior" class="form-control mask-placa" 
                                value="{{ $veiculo->placaAnterior }}" 
                                placeholder="ABC1234"
                                maxlength="8"
                                style="text-transform: uppercase;">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Ano (Fab/Mod)</label>
                            <input type="text" name="ano" id="edit-ano" class="form-control mask-ano" 
                                value="{{ $veiculo->ano }}" 
                                placeholder="2020/2021"
                                maxlength="9">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">Cor</label>
                            <input type="text" name="cor" class="form-control" value="{{ $veiculo->cor }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Combustível</label>
                            <select name="combustivel" class="form-select">
                                @foreach(['GASOLINA', 'ETANOL', 'FLEX', 'DIESEL', 'GNV', 'ELETRICO', 'HIBRIDO'] as $comb)
                                    <option value="{{ $comb }}" {{ $veiculo->combustivel == $comb ? 'selected' : '' }}>{{ $comb }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Motor</label>
                            <input type="text" name="motor" class="form-control" value="{{ $veiculo->motor }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Renavam</label>
                            <input type="text" name="renavam" class="form-control" value="{{ $veiculo->renavam }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Número do CRV</label>
                            <input type="text" name="crv" class="form-control" value="{{ $veiculo->crv }}">
                        </div>

                    <input type="hidden" id="veiculo_tipo" value="{{ $veiculo->tipo }}">

                    <div class="col-md-4">
    <label class="form-label fw-bold">Marca</label>
    <select name="marca" id="marca" class="form-control" required>
        @if($veiculo->marca)
            <option value="{{ $veiculo->marca }}" selected>{{ $veiculo->marca }}</option>
        @else
            <option value="">Selecione</option>
        @endif
    </select>
</div>

<div class="col-md-4">
    <label class="form-label fw-bold">Modelo</label>
    <select name="modelo" id="modelo_carro" class="form-control" required>
        <option value="{{ $veiculo->modelo }}" selected>{{ $veiculo->modelo }}</option>
    </select>
</div>

<div class="col-md-4">
    <label class="form-label fw-bold">Versão</label>
    <select name="versao" id="versao" class="form-control" required>
        <option value="{{ $veiculo->versao }}" selected>{{ $veiculo->versao }}</option>
    </select>
</div>

<input type="hidden" name="marca_nome" id="marca_nome" value="{{ $veiculo->marca }}">
<input type="hidden" name="modelo_nome" id="modelo_nome" value="{{ $veiculo->modelo }}">
<input type="hidden" name="versao_nome" id="versao_nome" value="{{ $veiculo->versao }}">


                    </div>
                </div>
                <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Fechar
                        </button>
                        <button type="submit" class="btn btn-primary" id="submitButton">
                            <i class="fas fa-check me-1"></i> Salvar
                        </button>
                        <button class="btn btn-primary" id="loadingButton" type="button" disabled style="display: none;">
                            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                            Salvando...
                        </button>
                    </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('input', function (e) {
    // 1. Forçar Maiúsculas em TODOS os inputs de texto (exceto campos específicos se houver)
    if (e.target.tagName === 'INPUT' && e.target.type === 'text') {
        e.target.value = e.target.value.toUpperCase();
    }

    // 2. Máscara de Ano (0000/0000)
    if (e.target.classList.contains('mask-ano')) {
        let x = e.target.value.replace(/\D/g, '').match(/(\d{0,4})(\d{0,4})/);
        e.target.value = !x[2] ? x[1] : x[1] + '/' + x[2];
    }

    // 3. Máscara de Placa (Remover caracteres especiais - Maiúsculas já tratadas acima)
    if (e.target.classList.contains('mask-placa')) {
        e.target.value = e.target.value.replace(/[^A-Z0-9]/g, '');
    }
});

// Validação extra ao sair do campo de Ano (Blur)
document.getElementById('edit-ano').addEventListener('blur', function (e) {
    const valor = e.target.value;
    if (valor.length > 0 && valor.length < 9) {
        alert('Por favor, digite o ano no formato completo: 2020/2021');
        setTimeout(() => e.target.focus(), 10);
    }
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formDoc');
    const submitBtn = document.getElementById('submitButton');
    const loadingBtn = document.getElementById('loadingButton');

    if (form) {
        form.addEventListener('submit', function (e) {
            // Verifica se o formulário é válido (HTML5 validation)
            if (!form.checkValidity()) {
                return; // Se houver campos vazios, não faz nada e deixa o navegador avisar
            }

            // 1. Evita o duplo clique desativando o botão imediatamente
            submitBtn.disabled = true;

            // 2. Alterna a visibilidade dos botões
            submitBtn.style.display = 'none';
            loadingBtn.style.display = 'inline-block';

            // Opcional: Se quiser garantir que o form seja enviado mesmo com o botão disabled
            // o próprio evento de 'submit' já cuida disso no envio padrão.
        });
    }
});
</script>

<style>
    /* Aplica o efeito visual em todos os inputs de texto do formulário */
#formDoc input[type="text"] {
    text-transform: uppercase;
}
</style>



<script>
document.addEventListener('DOMContentLoaded', function() {
    // Agora pegamos o valor do input hidden
    const inputTipo = document.getElementById('veiculo_tipo');
    const selectMarca = document.getElementById('marca');
    const selectModelo = document.getElementById('modelo_carro');
    const selectVersao = document.getElementById('versao');
    const inputAno = document.getElementById('input-ano');
    const selectCombustivel = document.querySelector('select[name="combustivel"]');

    const BASE_URL = 'https://parallelum.com.br/fipe/api/v1';

    // Função para converter o tipo do Alcecar para o padrão da API
    function getTipoRota() {
        const valor = inputTipo.value.toUpperCase();
        if (valor === 'MOTOCICLETA' || valor === 'MOTO') return 'motos';
        if (valor === 'CAMINHAO' || valor === 'CAMINHÃO') return 'caminhoes';
        return 'carros'; // Para AUTOMOVEL, CAMINHONETE e outros
    }

    // --- INICIALIZAÇÃO ---
    // --- INICIALIZAÇÃO ---
    const tipoRota = getTipoRota();
    
    // Pegamos os valores que o PHP já colocou nos selects (se existirem)
    const marcaAtual = selectMarca.value; 

    fetch(`${BASE_URL}/${tipoRota}/marcas`)
        .then(response => response.json())
        .then(marcas => {
            // Se já temos uma marca do banco, não limpamos o select com "Selecione"
            // Apenas adicionamos as outras marcas abaixo da atual
            if (!marcaAtual) {
                selectMarca.innerHTML = '<option value="">Selecione a Marca</option>';
            } else {
                // Mantém a marca atual e adiciona um divisor visual
                selectMarca.innerHTML = `<option value="${marcaAtual}" selected>${marcaAtual}</option>`;
                selectMarca.innerHTML += '<option value="" disabled>---------</option>';
            }

            marcas.forEach(marca => {
                // Evita duplicar a marca que já está selecionada
                if (marca.nome.toUpperCase() !== marcaAtual.toUpperCase()) {
                    const opt = document.createElement('option');
                    opt.value = marca.codigo;
                    opt.textContent = marca.nome;
                    selectMarca.appendChild(opt);
                }
            });
        })

    // --- EVENTOS ---

    // 1. Ao mudar a MARCA
    selectMarca.addEventListener('change', function() {
        const marcaId = this.value;
        const marcaNome = this.options[this.selectedIndex].text;
        
        // Guarda o nome no input oculto
        const inputMarcaNome = document.getElementById('marca_nome');
        if(inputMarcaNome) inputMarcaNome.value = marcaNome;

        selectModelo.innerHTML = '<option value="">Carregando...</option>';
        selectVersao.innerHTML = '<option value="">Selecione o modelo</option>';
        selectModelo.disabled = true;
        selectVersao.disabled = true;

        if (marcaId) {
            fetch(`${BASE_URL}/${tipoRota}/marcas/${marcaId}/modelos`)
                .then(response => response.json())
                .then(data => {
                    selectModelo.innerHTML = '<option value="">Selecione o Modelo</option>';
                    data.modelos.forEach(modelo => {
                        const opt = document.createElement('option');
                        opt.value = modelo.codigo;
                        opt.textContent = modelo.nome;
                        selectModelo.appendChild(opt);
                    });
                    selectModelo.disabled = false;
                });
        }
    });

    // 2. Ao mudar o MODELO
    selectModelo.addEventListener('change', function() {
        const marcaId = selectMarca.value;
        const modeloId = this.value;
        const modeloNome = this.options[this.selectedIndex].text;
        
        const inputModeloNome = document.getElementById('modelo_nome');
        if(inputModeloNome) inputModeloNome.value = modeloNome;

        selectVersao.innerHTML = '<option value="">Carregando...</option>';
        selectVersao.disabled = true;

        if (modeloId) {
            fetch(`${BASE_URL}/${tipoRota}/marcas/${marcaId}/modelos/${modeloId}/anos`)
                .then(response => response.json())
                .then(anos => {
                    selectVersao.innerHTML = '<option value="">Selecione a Versão/Ano</option>';
                    anos.forEach(ano => {
                        const opt = document.createElement('option');
                        opt.value = ano.codigo;
                        opt.textContent = ano.nome;
                        selectVersao.appendChild(opt);
                    });
                    selectVersao.disabled = false;
                });
        }
    });

    // 3. Ao selecionar a VERSÃO (Ano)
    selectVersao.addEventListener('change', function() {
        const marcaId = selectMarca.value;
        const modeloId = selectModelo.value;
        const anoId = this.value;
        
        const inputVersaoNome = document.getElementById('versao_nome');
        if(inputVersaoNome) inputVersaoNome.value = this.options[this.selectedIndex].text;

        if (anoId) {
            fetch(`${BASE_URL}/${tipoRota}/marcas/${marcaId}/modelos/${modeloId}/anos/${anoId}`)
                .then(response => response.json())
                .then(veiculo => {
                    // Preenche o Ano (Ex: 2023/2023)
                    if(inputAno) inputAno.value = `${veiculo.AnoModelo}/${veiculo.AnoModelo}`;

                    // Sincroniza o Combustível
                    if(selectCombustivel) {
                        const fipeComb = veiculo.Combustivel.toUpperCase();
                        Array.from(selectCombustivel.options).forEach(opt => {
                            if (fipeComb.includes(opt.value.toUpperCase()) || opt.value.toUpperCase().includes(fipeComb)) {
                                opt.selected = true;
                            }
                        });
                    }

                    // Preenche o valor FIPE automaticamente em algum campo se quiser
                    const inputValorFipe = document.getElementById('valor_fipe_hidden'); // Opcional
                    if(inputValorFipe) inputValorFipe.value = veiculo.Valor;
                    
                    console.log("Veículo FIPE carregado:", veiculo);
                });
        }
    });
});

</script>