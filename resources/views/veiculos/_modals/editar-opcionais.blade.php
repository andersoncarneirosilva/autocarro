<div class="modal fade" id="modalOpcionais" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title"><i class="mdi mdi-check-all me-1"></i> Editar Opcionais</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('veiculos.updateOpcionais', $veiculo->id) }}" method="POST" id="formOpc">
                @csrf
                @method('PUT')
                
                <div class="modal-body">
    <div style="max-height: 400px; overflow-y: auto; overflow-x: hidden; padding-right: 10px;">
        <div class="row g-2"> @php
                $todosOpcionais = [
                    "Air Bag", "Air Bag Cortina", "Air Bag Duplo", "Alarme", "Alerta colisão frontal", "Ar Condicionado", "Ar Condicionado Digital", "Ar Quente",
                    "Banco com Aquecimento", "Banco de Couro", "Banco Elétrico", "Banco Recaro", "Banco Regulável Altura", "Cabine Dupla", "Cabine Estendida",
                    "Cabine Simples", "Câmbio CVT", "Câmera de Ré", "Capota Marítima", "Chave Reserva",
                    "Controle de Estabilidade", "Controle de Tração", "Desembaçador Traseiro", "Direção Elétrica", "Direção Escamoteável", "Direção Hidráulica", "Direção Multifuncional",
                    "Engate para Reboque", "Estribo", "Farol Acendimento Aut.", "Farol Auxiliar", "Farol de LED", "Farol Regulagem Elétrica", "Freio de Mão Eletrônico",
                    "Freios ABS", "Freios com EBD", "GPS", "Interface", "Legalizado", "Limpador Traseiro", "Lona Maritima", "Manual do proprietário", "Media Nav", "Monitor Pressão de Pneus",
                    "Multimídia", "Parachoques na cor", "Park Assist", "Partida Elétrica", "Película Solar", "Piloto adaptativo", "Piloto Automatico",
                    "Porta Malas Elétrico", "Protetor de Caçamba", "Protetor de Carter", "Quebra Mato", "Rack de teto", "Rádio com espelhamento celular", "Rádio u-connect", "Rastreador",
                    "Rebaixado", "Retrovisor Elétrico", "Retrovisor Rebatimento Aut.", "Rodas de Liga Leve", "Santo Antônio", "Sensor de Chuva", "Sensor de Estacionamento",
                    "Som no Volante", "Som Original", "Som Rádio",
                    "Som Rádio CD", "Som Rádio DVD", "Som Rádio MP3", "Spoiler", "Start Stop", "Suspensão Regulável", "Teto Panoramico", "Teto Solar", "Tração 4x2", "Tração 4x4",
                    "Tração AWD", "Travas Elétricas", "Turbo", "Vidros Elétricos", "Vidros Verdes", "Xenon"
                ];
                
                $colunas = array_chunk($todosOpcionais, ceil(count($todosOpcionais) / 3));
            @endphp

            @foreach($colunas as $opcionaisColuna)
                <div class="col-md-4">
                    @foreach($opcionaisColuna as $item)
                        @php
                            $slug = Str::slug($item, '_');
                        @endphp
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="opcionais[]" 
                                value="{{ $item }}" 
                                id="opc_{{ $slug }}"
                                {{ 
    in_array(
        $item, 
        is_array($veiculo->opcionais) 
            ? $veiculo->opcionais 
            : (json_decode($veiculo->opcionais, true) ?? explode(',', $veiculo->opcionais) ?? [])
    ) ? 'checked' : '' 
}}>
                            <label class="form-check-label small text-uppercase" for="opc_{{ $slug }}" style="cursor: pointer;">
                                {{ $item }}
                            </label>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Fechar
                        </button>
                    
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