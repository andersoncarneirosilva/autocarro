{{-- MODAL EXEMPLO: EDIÇÃO DE CONFIRMAÇÃO (Repetir para os outros) --}}
<div id="modalEditConfirmation" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h4 class="modal-title">Editar Confirmação</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('whatsapp.update-messages') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Mensagem de Confirmação</label>
                        <textarea 
    id="textarea_confirmation" 
    name="confirmation_template" 
    rows="5" 
    class="form-control"
>{{ $settings->confirmation_template ?? "✅ Agendamento Confirmado!\nOlá {nome}, tudo bem?\nTe espero na {empresa}\nNo dia: {data} às {horario_inicio}" }}</textarea>
                    </div>
                    <div class="mb-3">
                        <select class="form-select form-select-sm select-tag" data-target="textarea_confirmation">
                            <option value="">+ Inserir variável</option>
                            <option value="{nome}">Nome do Cliente</option>
                            <option value="{data}">Data</option>
                            <option value="{horario_inicio}">Horário</option>
                        </select>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>