<div id="modalEditReminder" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('whatsapp.update-messages') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Configurar Lembrete</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Antecedência do envio</label>
                        <select name="reminder_time" class="form-select">
                            <option value="30" {{ ($settings->reminder_time ?? '') == 30 ? 'selected' : '' }}>30 minutos antes</option>
                            <option value="60" {{ ($settings->reminder_time ?? '') == 60 ? 'selected' : '' }}>1 hora antes</option>
                            <option value="120" {{ ($settings->reminder_time ?? '') == 120 ? 'selected' : '' }}>2 horas antes</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Mensagem</label>
                        <textarea id="textarea_reminder" name="reminder_template" rows="5" class="form-control">{{ $settings->reminder_template ?? '' }}</textarea>
                    </div>

                    <select class="form-select form-select-sm select-tag" data-target="textarea_reminder">
                        <option value="">+ Inserir variável</option>
                        <option value="{nome}">{nome}</option>
                        <option value="{profissional}">{profissional}</option>
                        <option value="{horario_inicio}">{horario_inicio}</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Salvar Lembrete</button>
                </div>
            </form>
        </div>
    </div>
</div>