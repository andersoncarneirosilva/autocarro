<div class="modal fade" id="modalEditarInfoVeiculo" tabindex="-1" aria-labelledby="modalEditarInfoVeiculoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalEditarInfoVeiculoLabel text-white">
                    <i class="mdi mdi-pencil me-2"></i>Editar Dados do Veículo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('anuncios.update-info', $veiculo->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Placa</label>
                            <input type="text" name="placa" class="form-control mask-placa" 
                                value="{{ $veiculo->placa }}" 
                                placeholder="ABC1D23"
                                maxlength="7"
                                style="text-transform: uppercase;">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Placa Anterior</label>
                            <input type="text" name="placaAnterior" class="form-control mask-placa" 
                                value="{{ $veiculo->placaAnterior }}" 
                                placeholder="ABC1234"
                                maxlength="8"
                                style="text-transform: uppercase;">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Ano (Fab/Mod)</label>
                            <input type="text" name="ano" id="edit-ano" class="form-control mask-ano" 
                                value="{{ $veiculo->ano }}" 
                                placeholder="2020/2021"
                                maxlength="9">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">Cor</label>
                            <input type="text" name="cor" class="form-control" value="{{ $veiculo->cor }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Combustível</label>
                            <select name="combustivel" class="form-select">
                                @foreach(['GASOLINA', 'ETANOL', 'FLEX', 'DIESEL', 'GNV', 'ELETRICO', 'HIBRIDO'] as $comb)
                                    <option value="{{ $comb }}" {{ $veiculo->combustivel == $comb ? 'selected' : '' }}>{{ $comb }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Motor</label>
                            <input type="text" name="motor" class="form-control" value="{{ $veiculo->motor }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Renavam</label>
                            <input type="text" name="renavam" class="form-control" value="{{ $veiculo->renavam }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Número do CRV</label>
                            <input type="text" name="crv" class="form-control" value="{{ $veiculo->crv }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted">Marca (Real)</label>
                            <input type="text" name="marca_real" class="form-control bg-light" value="{{ $veiculo->marca_real }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted">Modelo (Real)</label>
                            <input type="text" name="modelo_real" class="form-control bg-light" value="{{ $veiculo->modelo_real }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary" style="background-color: #ff4a17; border: none;">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('input', function (e) {
    // --- Máscara de Ano (0000/0000) ---
    if (e.target.classList.contains('mask-ano')) {
        let x = e.target.value.replace(/\D/g, '').match(/(\d{0,4})(\d{0,4})/);
        e.target.value = !x[2] ? x[1] : x[1] + '/' + x[2];
    }

    // --- Máscara de Placa (Forçar Maiúsculas e remover caracteres especiais) ---
    if (e.target.classList.contains('mask-placa')) {
        e.target.value = e.target.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
    }
});

// Validação extra ao sair do campo de Ano (Blur)
document.getElementById('edit-ano').addEventListener('blur', function (e) {
    const valor = e.target.value;
    if (valor.length > 0 && valor.length < 9) {
        alert('Por favor, digite o ano no formato completo: 2020/2021');
        setTimeout(() => e.target.focus(), 10);
    }
});
</script>