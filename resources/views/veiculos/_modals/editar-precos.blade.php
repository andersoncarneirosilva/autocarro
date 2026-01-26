<div class="modal fade" id="modalEditarPrecos" tabindex="-1" aria-labelledby="modalEditarPrecosLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">
                    <i class="mdi mdi-currency-usd me-1"></i> Mercado e Venda
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('veiculos.updatePrecos', $veiculo->id) }}" method="POST" id="formUpdatePrecos">
                @csrf
                @method('PUT')
                
                <div class="modal-body">
                    <div id="js-error-container" class="alert alert-danger d-none py-2 mb-3">
        <ul id="js-error-list" class="mb-0 small fw-bold"></ul>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger py-2 mb-3">
            <ul class="mb-0 px-3 small fw-bold">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Valor de Venda (R$)</label>
                            <input type="text" class="form-control form-control-lg money calc-trigger" name="valor" id="valor" 
                                value="{{ old('valor', number_format($veiculo->valor, 2, ',', '.')) }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Valor Oferta / À Vista (R$)</label>
                            <input type="text" class="form-control form-control-lg money" name="valor_oferta" id="valor_oferta" 
                                value="{{ old('valor_oferta', number_format($veiculo->valor_oferta, 2, ',', '.')) }}" required>
                        </div>
                    </div>

                    <hr class="my-3 text-muted">
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p class="small text-uppercase fw-bold text-muted mb-0">Opções de Parcelamento</p>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="exibir_parcelamento" id="exibir_parcelamento" value="1" 
                                {{ old('exibir_parcelamento', $veiculo->exibir_parcelamento) ? 'checked' : '' }}>
                            <label class="form-check-label" for="exibir_parcelamento">Ativar Exibição</label>
                        </div>
                    </div>

                    <div id="secao_parcelamento" style="{{ old('exibir_parcelamento', $veiculo->exibir_parcelamento) ? '' : 'display: none;' }}">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Parcelas</label>
                                <select class="form-select calc-trigger" name="qtd_parcelas" id="qtd_parcelas">
                                    @for ($i = 1; $i <= 60; $i++)
                                        <option value="{{ $i }}" {{ old('qtd_parcelas', $veiculo->qtd_parcelas) == $i ? 'selected' : '' }}>
                                            {{ $i == 1 ? 'À vista' : $i.'x' }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Taxa (% a.m.)</label>
                                <input type="number" step="0.01" class="form-control calc-trigger" name="taxa_juros" id="taxa_juros" 
                                    value="{{ old('taxa_juros', $veiculo->taxa_juros ?? '0.00') }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Valor Parcela</label>
                                <input type="text" class="form-control bg-light money" name="valor_parcela" id="valor_parcela" 
                                    value="{{ old('valor_parcela', number_format($veiculo->valor_parcela, 2, ',', '.')) }}" readonly>
                            </div>
                            
                            <div class="col-12">
                                <div class="alert alert-sm bg-light border-0 mb-0 py-1 px-2">
                                    <small class="text-muted">
                                        Total a prazo: <span id="info_total_prazo" class="fw-bold text-dark">R$ 0,00</span> | 
                                        Juros: <span id="info_custo_juros" class="fw-bold text-danger">R$ 0,00</span>
                                    </small>
                                </div>
                            </div>
                        </div>
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
document.addEventListener('submit', function (e) {
    // Verifica se o formulário enviado é o de documentos/veículo
    const form = e.target;
    
    if (form.id === 'formUpdatePrecos' || form.closest('#formUpdatePrecos')) {
        // Se o formulário não for válido (HTML5), para aqui
        if (!form.checkValidity()) {
            return;
        }

        // Busca os botões DENTRO deste formulário específico que disparou o evento
        const submitBtn = form.querySelector('#submitButton');
        const loadingBtn = form.querySelector('#loadingButton');

        if (submitBtn && loadingBtn) {
            // Desativa e esconde o botão de envio
            submitBtn.disabled = true;
            submitBtn.style.setProperty('display', 'none', 'important');
            
            // Mostra o botão de loading
            loadingBtn.style.setProperty('display', 'inline-block', 'important');
        }
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. GATILHO PARA REABRIR MODAL EM CASO DE ERRO VINDODO LARAVEL
    @if ($errors->any())
        var myModal = new bootstrap.Modal(document.getElementById('modalEditarPrecos'));
        myModal.show();
    @endif

    // Referências
    const form = document.getElementById('formUpdatePrecos');
    const inputExibir = document.getElementById('exibir_parcelamento');
    const secaoParcelamento = document.getElementById('secao_parcelamento');

    // Toggle Seção Parcelamento
    inputExibir.addEventListener('change', function() {
        secaoParcelamento.style.display = this.checked ? 'block' : 'none';
    });

    // Funções auxiliares
    function parseMoney(v) {
        return parseFloat(v.toString().replace(/\./g, '').replace(',', '.')) || 0;
    }

    function formatMoney(v) {
        return v.toLocaleString('pt-br', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function calcularParcela() {
        const valorBase = parseMoney(document.getElementById('valor').value);
        const qtdParcelas = parseInt(document.getElementById('qtd_parcelas').value);
        const taxaMensal = parseFloat(document.getElementById('taxa_juros').value) / 100;
        
        const campoParcela = document.getElementById('valor_parcela');
        const infoTotal = document.getElementById('info_total_prazo');
        const infoJuros = document.getElementById('info_custo_juros');

        let valorParcela = (taxaMensal > 0 && qtdParcelas > 1) 
            ? valorBase * (taxaMensal / (1 - Math.pow(1 + taxaMensal, -qtdParcelas)))
            : valorBase / qtdParcelas;

        const totalPrazo = valorParcela * qtdParcelas;
        
        campoParcela.value = formatMoney(valorParcela);
        if(infoTotal) infoTotal.innerText = "R$ " + formatMoney(totalPrazo);
        if(infoJuros) infoJuros.innerText = "R$ " + formatMoney(totalPrazo - valorBase);
    }

    // Máscara e Listeners
    document.querySelectorAll('.money').forEach(input => {
        input.addEventListener('input', function(e) {
            let v = e.target.value.replace(/\D/g, '');
            v = (v / 100).toFixed(2).replace(".", ",").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            e.target.value = v;
        });
    });

    document.querySelectorAll('.calc-trigger').forEach(el => {
        el.addEventListener('input', calcularParcela);
    });

    // Validação Front-end no Submit
    // Substitua o bloco de Validação Front-end no Submit por este:
form.addEventListener('submit', function(e) {
    const vVenda = parseMoney(document.getElementById('valor').value);
    const vOferta = parseMoney(document.getElementById('valor_oferta').value);
    
    const errorContainer = document.getElementById('js-error-container');
    const errorList = document.getElementById('js-error-list');

    // 1. Limpa erros visuais do JS
    errorContainer.classList.add('d-none');
    errorList.innerHTML = '';
    
    // 2. Esconde os erros do Laravel que sobraram do último refresh
    const laravelErrors = document.querySelectorAll('.alert-danger:not(#js-error-container)');
    laravelErrors.forEach(el => el.classList.add('d-none'));

    if (vVenda < vOferta) {
        e.preventDefault(); // ISTO IMPEDE O REFRESH
        e.stopPropagation(); // Garante que nenhum outro script envie o form

        const li = document.createElement('li');
        li.innerText = 'O Valor de Venda não pode ser menor que o Valor de Oferta.';
        errorList.appendChild(li);

        errorContainer.classList.remove('d-none');
        document.getElementById('valor').focus();
        
        return false; // Reforço para não enviar
    }
});

    // Inicializa cálculo
    calcularParcela();
});
</script>