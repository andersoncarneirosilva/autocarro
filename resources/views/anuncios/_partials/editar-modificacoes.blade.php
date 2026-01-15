<div class="modal fade" id="modalModificacoes" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title"><i class="mdi mdi-auto-fix me-1"></i> Editar Modificações</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('anuncios.updateModificacoes', $veiculo->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="modal-body">
                    @php 
                        $selecionados = json_decode($veiculo->modificacoes) ?? []; 
                        
                        $categoriasMod = [
        "Motor e Performance" => [
            "Remap", "Injeção Programável", "Gas Pedal", "Preparação Turbo", 
            "Preparação Aspirado", "Preparação Nitro", "Motor Forjado", 
            "Motor Trocado", "Upgrade de Intercooler", "Cold Air Intake", 
            "Boost Pipe", "Charge Pipe"
        ],
        "Exaustão e Alimentação" => [
            "Downpipe", "Difusor", "Coletor Dimensionado", "Escape Dimensionado", 
            "Cash Tank", "Surge Tank"
        ],
        "Transmissão e Chassi" => [
            "Câmbio Forjado", "Câmbio Trocado", "Upgrade de Freios", "Roda Forjada"
        ],
        "Suspensão" => [
            "Rebaixado", "Suspensão a Ar", "Suspensão a Rosca", "Suspensão Esportiva"
        ],
        "Estética e Outros" => [
            "Body Kit", "Interior Personalizado", "Xenon (Colocado)", "Legalizado"
        ]
    ];
                    @endphp

                    @foreach($categoriasMod as $categoria => $itens)
                        <div class="mb-2">
                            <h6 class="text-primary border-bottom pb-2 mb-2">
                                <strong>{{ $categoria }}</strong>
                            </h6>
                            <div class="row">
                                @foreach($itens as $item)
                                    @php $idInput = Str::slug($item); @endphp
                                    <div class="col-md-3 col-sm-6 mb-1">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="modificacoes[]" 
                                                   value="{{ $item }}" id="mod_{{ $idInput }}"
                                                   {{ in_array($item, $selecionados) ? 'checked' : '' }}>
                                            <label class="form-check-label small" for="mod_{{ $idInput }}">
                                                {{ $item }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="mdi mdi-check me-1"></i> Atualizar Modificações
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>