<div class="modal fade" id="modalNovaReceita" tabindex="-1" aria-labelledby="modalNovaReceitaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold" id="modalNovaReceitaLabel">
                    <i class="mdi mdi-cash-plus me-2"></i>Nova Receita Manual
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('financeiro.store') }}" method="POST">
                @csrf
                <input type="hidden" name="tipo" value="receita">
                
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Descrição da Venda</label>
                            <input type="text" name="descricao" class="form-control" placeholder="Ex: Venda de Kit Shampoo Pós-Química" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Valor (R$)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-start-0">R$</span>
                                <input type="text" name="valor" class="form-control money" placeholder="0,00" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Data do Recebimento</label>
                            <input type="date" name="data_pagamento" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Profissional (Opcional)</label>
                            <select name="profissional_id" class="form-select">
                                <option value="">Nenhum (Venda Direta do Salão)</option>
                                @foreach($profissionais as $prof)
                                    <option value="{{ $prof->id }}">{{ $prof->nome }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Selecione para calcular comissão de venda.</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Forma de Pagamento</label>
                            <select name="forma_pagamento" class="form-select" required>
                                <option value="Dinheiro">Dinheiro</option>
                                <option value="Pix">Pix</option>
                                <option value="Cartão de Débito">Cartão de Débito</option>
                                <option value="Cartão de Crédito">Cartão de Crédito</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Comissão (R$)</label>
                            <input type="number" step="0.01" name="comissao_valor" class="form-control" placeholder="0,00">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Observações</label>
                            <textarea name="observacoes" class="form-control" rows="2" placeholder="Detalhes adicionais..."></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success px-4">
                        <i class="mdi mdi-check me-1"></i>Salvar Receita
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
    $('.money').mask('#.##0,00', {reverse: true});
});
</script>