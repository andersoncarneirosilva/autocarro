<div class="modal fade" id="modalConcluirAtendimento" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="mdi mdi-check-all me-1"></i> Concluir Atendimento</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formConcluirAtendimento">
                @csrf
                <input type="hidden" id="concluir_agenda_id" name="agenda_id">
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <h4 id="concluir_cliente_nome" class="mb-1 text-dark"></h4>
                        <p id="concluir_servico_info" class="text-muted small mb-0"></p>
                        <h3 class="text-success mt-2" id="concluir_valor_total"></h3>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Forma de Pagamento</label>
                        <select class="form-select" name="forma_pagamento" required>
                            <option value="Dinheiro">Dinheiro</option>
                            <option value="Cartão de Crédito">Cartão de Crédito</option>
                            <option value="Cartão de Débito">Cartão de Débito</option>
                            <option value="Pix">Pix</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success px-4">Finalizar e Baixar</button>
                </div>
            </form>
        </div>
    </div>
</div>