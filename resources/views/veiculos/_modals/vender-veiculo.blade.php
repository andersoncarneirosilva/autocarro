<div class="modal fade" id="modalVenderVeiculo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Finalizar Venda - {{ $veiculo->placa }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('veiculos.vender', $veiculo->id) }}" method="POST" id="formVenda">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Vendedor Responsável</label>
                            <select name="vendedor_id" class="form-select" required>
                                <option value="">Selecione...</option>
                                @foreach($vendedores as $vendedor)
                                    <option value="{{ $vendedor->id }}" {{ $veiculo->vendedor_id == $vendedor->id ? 'selected' : '' }}>
                                        {{ $vendedor->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Cliente (Comprador)</label>
                            <select name="cliente_id" class="form-select" required>
                                <option value="">Selecione um cliente...</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Valor Final de Venda (R$)</label>
                            <input type="text" name="valor_venda" id="v_valor" class="form-control money calc-venda" 
                                value="{{ number_format($veiculo->valor_oferta > 0 ? $veiculo->valor_oferta : $veiculo->valor, 2, ',', '.') }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Valor de Entrada (R$)</label>
                            <input type="text" name="entrada" id="v_entrada" class="form-control money calc-venda" placeholder="0,00">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Data da Venda</label>
                            <input type="date" name="data_venda" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <hr class="my-3 text-muted">
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p class="small text-uppercase fw-bold text-muted mb-0">Opções de Parcelamento</p>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="exibir_parcelamento" id="v_exibir_parcelamento" value="1">
                            <label class="form-check-label" for="v_exibir_parcelamento">Ativar Exibição</label>
                        </div>
                    </div>

                    <div id="v_secao_parcelamento" style="display: none;">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Parcelas</label>
                                <select class="form-select calc-venda" name="qtd_parcelas" id="v_qtd_parcelas">
                                    @for ($i = 1; $i <= 60; $i++)
                                        <option value="{{ $i }}">{{ $i == 1 ? 'À vista' : $i.'x' }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Taxa (% a.m.)</label>
                                <input type="number" step="0.01" class="form-control calc-venda" name="taxa_juros" id="v_taxa_juros" value="0.00">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label text-muted">Valor Parcela</label>
                                <input type="text" class="form-control bg-light money" name="valor_parcela" id="v_valor_parcela" readonly>
                            </div>
                            
                            <div class="col-12 text-end">
                                <small class="text-muted">
                                    Total a prazo: <span id="v_info_total" class="fw-bold text-dark">R$ 0,00</span>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success px-4">Confirmar Venda</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const inputExibir = document.getElementById('v_exibir_parcelamento');
    const secaoParcelamento = document.getElementById('v_secao_parcelamento');

    // Toggle Seção Parcelamento (Igual ao Editar Preços)
    inputExibir.addEventListener('change', function() {
        secaoParcelamento.style.display = this.checked ? 'block' : 'none';
    });

    function parseMoney(v) {
        return parseFloat(v.toString().replace(/\./g, '').replace(',', '.')) || 0;
    }

    function formatMoney(v) {
        return v.toLocaleString('pt-br', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function calcularParcelaVenda() {
        const valorVenda = parseMoney(document.getElementById('v_valor').value);
        const valorEntrada = parseMoney(document.getElementById('v_entrada').value);
        const qtdParcelas = parseInt(document.getElementById('v_qtd_parcelas').value);
        const taxaMensal = parseFloat(document.getElementById('v_taxa_juros').value) / 100;
        
        const saldoDevedor = valorVenda - valorEntrada;
        
        const campoParcela = document.getElementById('v_valor_parcela');
        const infoTotal = document.getElementById('v_info_total');

        if (saldoDevedor <= 0) {
            campoParcela.value = "0,00";
            infoTotal.innerText = "R$ 0,00";
            return;
        }

        // Fórmula de Parcelamento (Price)
        let valorParcela = (taxaMensal > 0 && qtdParcelas > 1) 
            ? saldoDevedor * (taxaMensal / (1 - Math.pow(1 + taxaMensal, -qtdParcelas)))
            : saldoDevedor / qtdParcelas;

        const totalPrazo = (valorParcela * qtdParcelas) + valorEntrada;
        
        campoParcela.value = formatMoney(valorParcela);
        if(infoTotal) infoTotal.innerText = "R$ " + formatMoney(totalPrazo);
    }

    // Aplicar máscara money e listeners de cálculo
    document.querySelectorAll('#modalVenderVeiculo .money').forEach(input => {
        input.addEventListener('input', function(e) {
            let v = e.target.value.replace(/\D/g, '');
            v = (v / 100).toFixed(2).replace(".", ",").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            e.target.value = v;
        });
    });

    document.querySelectorAll('.calc-venda').forEach(el => {
        el.addEventListener('input', calcularParcelaVenda);
    });
});
</script>