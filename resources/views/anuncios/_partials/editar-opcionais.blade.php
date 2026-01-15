<div class="modal fade" id="modalOpcionais" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title"><i class="mdi mdi-check-all me-1"></i> Editar Opcionais</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('anuncios.updateOpcionais', $veiculo->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="modal-body">
                    @php 
                        $selecionados = json_decode($veiculo->opcionais) ?? []; 
                        
                        $categoriasOpcionais = [
                            "Segurança" => [
                                "Air Bag", "Air Bag Duplo", "Alarme", "Blindado", "Sensor de Estacionamento"
                            ],
                            "Conforto e Interior" => [
                                "Banco de Couro", "Banco Recaro", "Paddle Shift / Borboleta", "Teto Solar"
                            ],
                            "Exterior e Estética" => [
                                "Engate para Reboque", "Farol Auxiliar", "Farol de LED", "Rodas de Liga Leve", 
                                "Santo Antônio", "Spoiler", "Xenon", "Película Solar"
                            ],

                        ];
                    @endphp

                    @foreach($categoriasOpcionais as $categoria => $itens)
                        <div class="mb-4">
                            <h6 class="text-primary border-bottom pb-2 mb-2">
                                <strong>{{ $categoria }}</strong>
                            </h6>
                            <div class="row">
                                @foreach($itens as $item)
                                    @php $idInputOpt = Str::slug($item) . '-opt'; @endphp
                                    <div class="col-md-3 col-sm-6 mb-1">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="opcionais[]" 
                                                   value="{{ $item }}" id="{{ $idInputOpt }}"
                                                   {{ in_array($item, $selecionados) ? 'checked' : '' }}>
                                            <label class="form-check-label small" for="{{ $idInputOpt }}">
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
                        <i class="mdi mdi-check me-1"></i> Atualizar Opcionais
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>