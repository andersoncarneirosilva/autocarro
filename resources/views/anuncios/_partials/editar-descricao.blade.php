<div class="modal fade" id="modalDescricao" tabindex="-1" aria-labelledby="modalDescricaoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="modalDescricaoLabel">
                    <i class="mdi mdi-text-box-search-outline me-1"></i> Editar Descrição do Anúncio
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('anuncios.updateDescricao', $veiculo->id) }}" method="POST">
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

                <div class="modal-footer">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="mdi mdi-check me-1"></i> Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>