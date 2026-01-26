<div class="modal fade" id="modalEditarInfoBasica" tabindex="-1" aria-labelledby="modalEditarInfoBasicaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalEditarInfoBasicaLabel">
                    <i class="mdi mdi-car-info me-1"></i> Atualizar Informações Básicas
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('veiculos.updateInfoBasica', $veiculo->id) }}" method="POST" id="formDoc">
    @csrf
    @method('PUT')
    
    <div class="modal-body">
        <div class="row">

            <div class="col-md-12 mb-3">
                <label for="categoria_especial" class="form-label text-muted">Categoria Especial</label>
                <select class="form-select" name="especiais" id="especiais">
                    <option value="" selected>Nenhuma (Padrão)</option>
                    <option value="Clássico" {{ $veiculo->especiais == 'Clássico' ? 'selected' : '' }}>Clássico</option>
                    <option value="Esportivo" {{ $veiculo->especiais == 'Esportivo' ? 'selected' : '' }}>Esportivo</option>
                    <option value="Modificado" {{ $veiculo->especiais == 'Modificado' ? 'selected' : '' }}>Modificado</option>
                </select>
                <small class="text-muted font-11">Opcional para veículos diferenciados.</small>
            </div>

            <div class="col-md-12 mb-3">
                <label for="cambio" class="form-label text-muted">Câmbio</label>
                <select class="form-select" name="cambio" id="cambio" required>
                    <option value="" disabled {{ !isset($veiculo->cambio) ? 'selected' : '' }}>Selecione o câmbio</option>
                    <option value="Manual" {{ $veiculo->cambio == 'Manual' ? 'selected' : '' }}>Manual</option>
                    <option value="Automático" {{ $veiculo->cambio == 'Automático' ? 'selected' : '' }}>Automático</option>
                    <option value="CVT" {{ $veiculo->cambio == 'CVT' ? 'selected' : '' }}>CVT</option>
                </select>
            </div>

            <div class="col-md-12 mb-3">
                <label for="portas" class="form-label text-muted">
                    Portas @if(strtoupper($veiculo->tipo) == 'MOTOCICLETA') <small>(Não aplicável)</small> @endif
                </label>
                
                <select class="form-select" name="portas" id="portas" 
                    {{ strtoupper($veiculo->tipo) == 'MOTOCICLETA' ? 'disabled' : '' }}>
                    
                    <option value="" disabled {{ !isset($veiculo->portas) || strtoupper($veiculo->tipo) == 'MOTOCICLETA' ? 'selected' : '' }}>
                        {{ strtoupper($veiculo->tipo) == 'MOTOCICLETA' ? 'N/A' : 'Selecione a quantidade' }}
                    </option>
                    
                    <option value="2" {{ $veiculo->portas == 2 ? 'selected' : '' }}>2 Portas</option>
                    <option value="3" {{ $veiculo->portas == 3 ? 'selected' : '' }}>3 Portas</option>
                    <option value="4" {{ $veiculo->portas == 4 ? 'selected' : '' }}>4 Portas</option>
                    <option value="5" {{ $veiculo->portas == 5 ? 'selected' : '' }}>5 Portas</option>
                </select>

                @if(strtoupper($veiculo->tipo) == 'MOTOCICLETA')
                    <input type="hidden" name="portas" value="0">
                @endif
            </div>

            <div class="col-md-12 mb-3">
                <label for="kilometragem" class="form-label text-muted">Kilometragem (KM)</label>
                <input type="number" 
                    class="form-control" 
                    name="kilometragem" 
                    id="kilometragem" 
                    min="0" 
                    oninput="this.value = Math.abs(this.value)"
                    value="{{ $veiculo->kilometragem }}" 
                    placeholder="Ex: 50000" required>
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