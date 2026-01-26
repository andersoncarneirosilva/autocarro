<div class="modal fade" id="modalDescricao" tabindex="-1" aria-labelledby="modalDescricaoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="modalDescricaoLabel">
                    <i class="mdi mdi-text-box-search-outline me-1"></i> Editar Descrição do Anúncio
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('veiculos.updateDescricao', $veiculo->id) }}" method="POST" id="formOpc">
                @csrf
                @method('PUT')
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="observacoes" class="form-label">Texto da Descrição</label>
                        <textarea class="form-control" 
                                  id="observacoes" 
                                  name="observacoes" 
                                  rows="10" 
                                  placeholder="Descreva detalhes do veículo, histórico de revisões, estado dos pneus, etc...">{{ old('observacoes', $veiculo->observacoes) }}</textarea>
                        <div class="form-text">
                            Dica: Uma boa descrição ajuda a vender mais rápido. Foque nos diferenciais!
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    
                    <button type="submit" class="btn btn-primary" id="submitButton">
                        <i class="mdi mdi-check me-1"></i> Salvar
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
    
    if (form.id === 'formOpc' || form.closest('#formOpc')) {
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