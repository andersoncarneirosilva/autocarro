<div class="modal fade" id="modalAdicionais" tabindex="-1" aria-labelledby="modalAdicionaisLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAdicionaisLabel">
                    <i class="mdi mdi-plus-box-outline me-1"></i> Atualizar Adicionais
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('anuncios.updateAdicionais', $veiculo->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="modal-body">
                    @php 
                        // Decodifica os valores do banco (assumindo que a coluna se chama 'adicionais')
                        $selecionados = json_decode($veiculo->adicionais) ?? []; 
                        
                        $opcoesAdicionais = [
                            "Aceita Troca", 
                            "Adaptado para pessoas com deficiência", 
                            "Consórcio", 
                            "Garantia de Fábrica", 
                            "IPVA Pago", 
                            "Licenciado", 
                            "Não aceita troca", 
                            "Peça de Colecionador", 
                            "Todas Revisões feitas", 
                            "Único Dono", 
                            "Veículo de Concessionária", 
                            "Veículo Financiado"
                        ];
                    @endphp

                    <div class="row">
                        @foreach($opcoesAdicionais as $index => $label)
                            <div class="col-md-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="adicionais[]" 
                                           value="{{ $label }}" id="adi_{{ $index }}"
                                           {{ in_array($label, $selecionados) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="adi_{{ $index }}">
                                        {{ $label }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary rounded-pill">
                        <i class="mdi mdi-check me-1"></i> Salvar Adicionais
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>