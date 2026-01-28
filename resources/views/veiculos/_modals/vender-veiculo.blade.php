<div class="modal fade" id="modalVenderVeiculo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Finalizar Venda - {{ $veiculo->placa }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('veiculos.vender', $veiculo->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Vendedor Responsável</label>
                        <select name="vendedor_id" class="form-select" required>
                            <option value="">Selecione...</option>
                            @foreach($vendedores as $vendedor)
                                <option value="{{ $vendedor->id }}" {{ $veiculo->vendedor_id == $vendedor->id ? 'selected' : '' }}>
                                    {{ $vendedor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cliente (Comprador)</label>
                        <select name="cliente_id" class="form-select" required>
                            <option value="">Selecione um cliente...</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Valor Final de Venda</label>
                            <input type="text" name="valor_venda" class="form-control money" 
                                value="{{ number_format($veiculo->valor_oferta > 0 ? $veiculo->valor_oferta : $veiculo->valor, 2, ',', '.') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Data da Venda</label>
                            <input type="date" name="data_venda" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Confirmar Venda</button>
                </div>
            </form>
        </div>
    </div>
</div>