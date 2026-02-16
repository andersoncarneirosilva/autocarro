<div class="modal fade" id="modalNovaDespesa" tabindex="-1" aria-labelledby="modalNovaDespesaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold" id="modalNovaDespesaLabel">
                    <i class="mdi mdi-cash-minus me-2"></i>Nova Despesa / Pagamento
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('financeiro.store') }}" method="POST">
                @csrf
                <input type="hidden" name="tipo" value="despesa">
                
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Descrição da Despesa</label>
                            <input type="text" name="descricao" class="form-control" placeholder="Ex: Aluguel, Compra de Tinturas, Conta de Luz" required>
                        </div>
                        

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Valor (R$)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-start-0">R$</span>
                                <input type="text" name="valor" class="form-control money" placeholder="0,00" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Data do Vencimento</label>
                            <input type="date" name="data_pagamento" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Categoria de Gasto</label>
                            <select name="observacoes" class="form-select" required>
                                <option value="Ocupação (Aluguel/Luz/Água)">Ocupação (Aluguel/Luz/Água)</option>
                                <option value="Produtos e Insumos">Produtos e Insumos</option>
                                <option value="Marketing e Anúncios">Marketing e Anúncios</option>
                                <option value="Folha de Pagamento">Folha de Pagamento</option>
                                <option value="Manutenção e Equipamentos">Manutenção e Equipamentos</option>
                                <option value="Outros">Outros</option>
                            </select>
                            <small class="text-muted">Isso ajuda a gerar o gráfico de para onde vai o dinheiro.</small>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Forma de Pagamento</label>
                            <select name="forma_pagamento" class="form-select" required>
                                <option value="Boleto">Boleto</option>
                                <option value="Pix">Pix</option>
                                <option value="Cartão de Crédito">Cartão de Crédito</option>
                                <option value="Dinheiro">Dinheiro</option>
                                <option value="Transferência">Transferência</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Notas Adicionais</label>
                            <textarea name="detalhes_extras" class="form-control" rows="2" placeholder="Ex: Referente ao mês de Janeiro..."></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="mdi mdi-check me-1"></i>Salvar Despesa
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