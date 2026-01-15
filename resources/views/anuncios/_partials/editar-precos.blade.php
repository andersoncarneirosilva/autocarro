<div class="modal fade" id="modalEditarPrecos" tabindex="-1" aria-labelledby="modalEditarPrecosLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="mdi mdi-currency-usd me-1"></i> Mercado e Venda
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('anuncios.updatePrecos', $veiculo->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Valor de Venda (R$)</label>
                            <input type="text" class="form-control form-control-lg money calc-trigger" name="valor" id="valor" value="{{ number_format($veiculo->valor, 2, ',', '.') }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Valor Oferta / À Vista (R$)</label>
                            <input type="text" class="form-control form-control-lg money" name="valor_oferta" id="valor_oferta" value="{{ number_format($veiculo->valor_oferta, 2, ',', '.') }}" required>
                        </div>
                    </div>

                    <hr class="my-3 text-muted">
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p class="small text-uppercase fw-bold text-muted mb-0">Opções de Parcelamento</p>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="exibir_parcelamento" id="exibir_parcelamento" value="1" {{ $veiculo->exibir_parcelamento ? 'checked' : '' }}>
                            <label class="form-check-label" for="exibir_parcelamento">Ativar Exibição</label>
                        </div>
                    </div>

                    <div id="secao_parcelamento" style="{{ $veiculo->exibir_parcelamento ? '' : 'display: none;' }}">
    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label text-muted">Parcelas</label>
            <select class="form-select calc-trigger" name="qtd_parcelas" id="qtd_parcelas">
                @for ($i = 1; $i <= 60; $i++)
                    <option value="{{ $i }}" {{ $veiculo->qtd_parcelas == $i ? 'selected' : '' }}>{{ $i == 1 ? 'À vista' : $i.'x' }}</option>
                @endfor
            </select>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label text-muted">Taxa (% a.m.)</label>
            <input type="number" step="0.01" class="form-control calc-trigger" name="taxa_juros" id="taxa_juros" value="{{ $veiculo->taxa_juros ?? '0.00' }}">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label text-muted">Valor Parcela</label>
            <input type="text" class="form-control bg-light money" name="valor_parcela" id="valor_parcela" value="{{ number_format($veiculo->valor_parcela, 2, ',', '.') }}" readonly>
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

                <div class="modal-footer">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success rounded-pill">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
// Toggle da seção de parcelamento
document.getElementById('exibir_parcelamento').addEventListener('change', function() {
    const secao = document.getElementById('secao_parcelamento');
    secao.style.display = this.checked ? 'block' : 'none';
});

// Suas funções de cálculo (parseMoney, formatMoney, calcularParcela) permanecem iguais
function parseMoney(value) {
    return parseFloat(value.toString().replace(/\./g, '').replace(',', '.')) || 0;
}

function formatMoney(value) {
    return value.toLocaleString('pt-br', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function calcularParcela() {
    const valorBase = parseMoney(document.getElementById('valor').value);
    const qtdParcelas = parseInt(document.getElementById('qtd_parcelas').value);
    const taxaMensal = parseFloat(document.getElementById('taxa_juros').value) / 100;
    const campoParcela = document.getElementById('valor_parcela');
    
    // Elementos informativos
    const infoTotal = document.getElementById('info_total_prazo');
    const infoJuros = document.getElementById('info_custo_juros');

    if (qtdParcelas <= 1) {
        campoParcela.value = formatMoney(valorBase);
        infoTotal.innerText = "R$ " + formatMoney(valorBase);
        infoJuros.innerText = "R$ 0,00";
        return;
    }

    let valorParcela = 0;

    if (taxaMensal > 0) {
        // Tabela Price (Juros Compostos)
        valorParcela = valorBase * (taxaMensal / (1 - Math.pow(1 + taxaMensal, -qtdParcelas)));
    } else {
        // Divisão simples (Sem Juros)
        valorParcela = valorBase / qtdParcelas;
    }

    const totalPrazo = valorParcela * qtdParcelas;
    const custoJuros = totalPrazo - valorBase;

    campoParcela.value = formatMoney(valorParcela);
    
    // Atualiza os textos no modal
    if(infoTotal) infoTotal.innerText = "R$ " + formatMoney(totalPrazo);
    if(infoJuros) infoJuros.innerText = "R$ " + formatMoney(custoJuros);
}

// Chame a função uma vez ao carregar para preencher os dados iniciais do modal
setTimeout(calcularParcela, 500);

// Aplicar em todos os triggers
document.querySelectorAll('.calc-trigger').forEach(el => {
    el.addEventListener('input', calcularParcela);
    el.addEventListener('change', calcularParcela);
});

// Máscara original
document.querySelectorAll('.money').forEach(function(input) {
    input.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value !== "") {
            value = (value / 100).toFixed(2) + '';
            value = value.replace(".", ",");
            value = value.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            e.target.value = value;
        }
    });
});
</script>