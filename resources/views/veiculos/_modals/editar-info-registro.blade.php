<div class="modal fade" id="modalEditarRegistro" tabindex="-1" aria-labelledby="modalEditarRegistroLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalEditarInfoBasicaLabel">
                    <i class="mdi mdi-car-info me-1"></i> Atualizar Informações Básicas
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('veiculos.updateCrv', $veiculo->id) }}" method="POST" id="formDoc">
    @csrf
    @method('PUT')
    
    <div class="modal-body">
        <div class="row">

            

            <div class="col-md-12 mb-3">
                <label for="kilometragem" class="form-label text-muted">Némuro CRV</label>
                <input type="text" 
                    class="form-control" 
                    name="crv"
                    value="{{ $veiculo->crv }}" 
                     required>
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
    
    if (form.id === 'formDoc' || form.closest('#formDoc')) {
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