<div class="modal fade" id="modalGerarDocs" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title text-primary">
                    <i class="mdi mdi-file-cog-outline me-1"></i> Gerar Documentação
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('documentos.gerar.procuracao', $veiculo->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
        <div class="alert alert-info border-0 mb-3" style="font-size: 13px;">
            <i class="mdi mdi-information-outline me-1"></i> 
            Selecione os dados para o veículo <strong>{{ $veiculo->placa }}</strong>.
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Proprietário (Cliente)</label>
            <select class="form-select font-13" name="cliente_id" required>
                <option value="">Selecione um cliente...</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ ($veiculo->cliente_id == $cliente->id) ? 'selected' : '' }}>
                        {{ $cliente->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Tipo de Documento</label>
            <select class="form-select font-13" name="tipo_documento" id="tipo_documento" required onchange="toggleValorCampo()">
                <option value="">Selecione...</option>
                <option value="comunicação">Comunicação de venda</option>
                <option value="procuracao">Procuração</option>
                <option value="atpve">Solicitação ATPV-e</option>
            </select>
        </div>

        <div class="mb-3" id="div_valor_venda" style="display: none;">
            <label class="form-label fw-bold">Valor da Venda (R$)</label>
            <input type="text" name="valor_venda" class="form-control font-13 money" placeholder="0,00">
            <small class="text-muted">Obrigatório para ATPV-e</small>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary rounded-pill px-4" id="btnGerarProc">
    <i class="mdi mdi-check me-1"></i> Confirmar e Gerar
</button>
    </div>
</form>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Unificamos as funções em um único listener
    const formDocs = document.querySelector('#modalGerarDocs form');
    const btnConfirmar = document.getElementById('btnGerarProc');

    if (formDocs && btnConfirmar) {
        formDocs.addEventListener('submit', function(e) {
            // Verificamos se o formulário é válido (HTML5 validation)
            if (!formDocs.checkValidity()) {
                return;
            }

            // Usamos um pequeno timeout para garantir que o navegador 
            // inicie o processo de envio antes de desabilitar o botão
            setTimeout(() => {
                btnConfirmar.disabled = true;
                btnConfirmar.innerHTML = `
                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                    Gerando...
                `;
            }, 50);
        });
    }
});

// Função de alternar campos (mantida)
function toggleValorCampo() {
    var tipo = document.getElementById('tipo_documento').value;
    var divValor = document.getElementById('div_valor_venda');
    var inputValor = divValor.querySelector('input');
    
    if (tipo === 'atpve') {
        divValor.style.display = 'block';
        inputValor.required = true;
    } else {
        divValor.style.display = 'none';
        inputValor.required = false;
        inputValor.value = ''; // Limpa o valor se mudar para procuração
    }
}
</script>
        </div>
    </div>
</div>