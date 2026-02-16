<div class="modal fade" id="modalEditarAgenda" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title text-dark fw-bold">
                    <i class="mdi mdi-calendar-edit me-1"></i> Detalhes do Agendamento
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="form_editar_agenda" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-3">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label fw-semibold">Nome do Cliente</label>
                            <input type="text" name="cliente_nome" id="edit_agenda_cliente" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Telefone</label>
                            <input type="text" name="cliente_telefone" id="edit_agenda_telefone" class="form-control tel-mask">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Profissional</label>
                            <select name="funcionario_id" id="edit_agenda_funcionario" class="form-select" required>
                                @foreach($profissional as $func)
                                    <option value="{{ $func->id }}">{{ $func->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Início</label>
                            <input type="datetime-local" name="data_hora_inicio" id="edit_agenda_inicio" class="form-control" required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold">Status do Atendimento</label>
                            <select name="status" id="edit_agenda_status" class="form-select">
                                <option value="pendente">Pendente</option>
                                <option value="confirmado">Confirmado</option>
                                <option value="concluido">Concluído</option>
                                <option value="cancelado">Cancelado</option>
                            </select>
                        </div>

                        <div class="col-md-12 mb-2">
                            <label class="form-label fw-semibold">Observações</label>
                            <textarea name="pedido_especial" id="edit_agenda_obs" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light border-0 d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-danger" id="btn_excluir_agenda">
                        <i class="mdi mdi-delete"></i> Excluir
                    </button>
                    <div>
                        <button type="button" class="btn btn-light fw-semibold" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary px-3 fw-semibold">Salvar Alterações</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>