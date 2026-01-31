<div class="modal fade" id="modalEditarInfoVeiculo" tabindex="-1" aria-labelledby="modalEditarInfoVeiculoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalEditarInfoVeiculoLabel">
                    <i class="mdi mdi-pencil-box-outline me-2"></i>Editar Dados do Veículo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('veiculos.update-info', $veiculo->id) }}" method="POST" id="formDoc">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    
                    <div class="mb-3">
                        <h6 class="text-primary text-uppercase fw-bold font-12 mb-3 border-bottom pb-1">
                            <i class="mdi mdi-car-search me-1"></i> Identificação e Modelo
                        </h6>
                        <div class="row g-2">
                            <div class="col-md-4">
                                <label class="form-label font-12 fw-bold text-muted">Marca</label>
                                <select name="marca" id="marca" class="form-select border-primary" required>
                                    <option value="">Selecione a Marca</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label font-12 fw-bold text-muted">Modelo</label>
                                <select name="modelo" id="modelo_carro" class="form-select" required>
                                    <option value="{{ $veiculo->modelo }}" selected>{{ $veiculo->modelo }}</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label font-12 fw-bold text-muted">Versão</label>
                                <select name="versao" id="versao" class="form-select" required>
                                    <option value="{{ $veiculo->versao }}" selected>{{ $veiculo->versao }}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 mt-4">
                        <h6 class="text-primary text-uppercase fw-bold font-12 mb-3 border-bottom pb-1">
                            <i class="mdi mdi-speedometer me-1"></i> Especificações e Uso
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="cambio" class="form-label font-12 fw-bold text-muted">Câmbio</label>
                                <select class="form-select" name="cambio" id="cambio" required>
                                    <option value="" disabled {{ !isset($veiculo->cambio) ? 'selected' : '' }}>Selecione</option>
                                    <option value="Manual" {{ $veiculo->cambio == 'Manual' ? 'selected' : '' }}>Manual</option>
                                    <option value="Automático" {{ $veiculo->cambio == 'Automático' ? 'selected' : '' }}>Automático</option>
                                    <option value="CVT" {{ $veiculo->cambio == 'CVT' ? 'selected' : '' }}>CVT</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="kilometragem" class="form-label font-12 fw-bold text-muted">Quilometragem</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="kilometragem" value="{{ $veiculo->kilometragem }}" required>
                                    <span class="input-group-text font-11">KM</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="portas" class="form-label font-12 fw-bold text-muted">Portas</label>
                                <select class="form-select" name="portas" id="portas" {{ strtoupper($veiculo->tipo) == 'MOTOCICLETA' ? 'disabled' : '' }}>
                                    <option value="2" {{ $veiculo->portas == 2 ? 'selected' : '' }}>2 Portas</option>
                                    <option value="3" {{ $veiculo->portas == 3 ? 'selected' : '' }}>3 Portas</option>
                                    <option value="4" {{ $veiculo->portas == 4 ? 'selected' : '' }}>4 Portas</option>
                                    <option value="5" {{ $veiculo->portas == 5 ? 'selected' : '' }}>5 Portas</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="especiais" class="form-label font-12 fw-bold text-muted">Categoria</label>
                                <select class="form-select" name="especiais" id="especiais">
                                    <option value="" selected>Padrão</option>
                                    <option value="Clássico" {{ $veiculo->especiais == 'Clássico' ? 'selected' : '' }}>Clássico</option>
                                    <option value="Esportivo" {{ $veiculo->especiais == 'Esportivo' ? 'selected' : '' }}>Esportivo</option>
                                    <option value="Modificado" {{ $veiculo->especiais == 'Modificado' ? 'selected' : '' }}>Modificado</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="veiculo_tipo" value="{{ $veiculo->tipo }}">
                    <input type="hidden" id="db_fipe_marca_id" value="{{ $veiculo->fipe_marca_id }}">
                    <input type="hidden" id="db_fipe_modelo_id" value="{{ $veiculo->fipe_modelo_id }}">
                    <input type="hidden" id="db_fipe_versao_id" value="{{ $veiculo->fipe_versao_id }}">
                    <input type="hidden" name="marca_nome" id="marca_nome" value="{{ $veiculo->marca }}">
                    <input type="hidden" name="modelo_nome" id="modelo_nome" value="{{ $veiculo->modelo }}">
                    <input type="hidden" name="versao_nome" id="versao_nome" value="{{ $veiculo->versao }}">
                    @if(strtoupper($veiculo->tipo) == 'MOTOCICLETA')
                        <input type="hidden" name="portas" value="0">
                    @endif
                </div>

                <div class="modal-footer bg-light border-top-0">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="submitButton">
                        <i class="mdi mdi-content-save me-1"></i> Salvar Alterações
                    </button>
                    <button class="btn btn-primary btn-sm" id="loadingButton" type="button" disabled style="display: none;">
                        <span class="spinner-border spinner-border-sm me-1" role="status"></span> Salvando...
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .font-12 { font-size: 12px; }
    .font-11 { font-size: 11px; }
    .form-label { margin-bottom: 0.3rem; }
    .border-bottom { border-bottom: 1px solid #f1f3fa !important; }
</style>

<script>
document.addEventListener('input', function (e) {
    // 1. Forçar Maiúsculas em TODOS os inputs de texto (exceto campos específicos se houver)
    if (e.target.tagName === 'INPUT' && e.target.type === 'text') {
        e.target.value = e.target.value.toUpperCase();
    }

    // 2. Máscara de Ano (0000/0000)
    if (e.target.classList.contains('mask-ano')) {
        let x = e.target.value.replace(/\D/g, '').match(/(\d{0,4})(\d{0,4})/);
        e.target.value = !x[2] ? x[1] : x[1] + '/' + x[2];
    }

    // 3. Máscara de Placa (Remover caracteres especiais - Maiúsculas já tratadas acima)
    if (e.target.classList.contains('mask-placa')) {
        e.target.value = e.target.value.replace(/[^A-Z0-9]/g, '');
    }
});

</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formDoc');
    const submitBtn = document.getElementById('submitButton');
    const loadingBtn = document.getElementById('loadingButton');

    if (form) {
        form.addEventListener('submit', function (e) {
            // Verifica se o formulário é válido (HTML5 validation)
            if (!form.checkValidity()) {
                return; // Se houver campos vazios, não faz nada e deixa o navegador avisar
            }

            // 1. Evita o duplo clique desativando o botão imediatamente
            submitBtn.disabled = true;

            // 2. Alterna a visibilidade dos botões
            submitBtn.style.display = 'none';
            loadingBtn.style.display = 'inline-block';

            // Opcional: Se quiser garantir que o form seja enviado mesmo com o botão disabled
            // o próprio evento de 'submit' já cuida disso no envio padrão.
        });
    }
});
</script>

<style>
    /* Aplica o efeito visual em todos os inputs de texto do formulário */
#formDoc input[type="text"] {
    text-transform: uppercase;
}
</style>


