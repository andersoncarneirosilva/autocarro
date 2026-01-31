<div class="row mt-4">
    <div class="col-md-12 px-md-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="header-title text-primary mb-0 text-uppercase" style="letter-spacing: 1px;">
                Gastos de Preparação
            </h4>
            <div>
                <span class="badge badge-primary mr-2">Total: R$ {{ number_format($veiculo->gastos->sum('valor'), 2, ',', '.') }}</span>
                <span class="badge badge-info">{{ $veiculo->gastos->count() }} Registro(s)</span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Data</th>
                        <th>Descrição</th>
                        <th>Categoria</th>
                        <th>Fornecedor</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th class="text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($veiculo->gastos as $gasto)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($gasto->data_gasto)->format('d/m/Y') }}</td>
                            <td><strong>{{ $gasto->descricao }}</strong></td>
                            <td>
                                <span class="text-muted small text-uppercase">{{ $gasto->categoria }}</span>
                            </td>
                            <td>{{ $gasto->fornecedor ?? 'Não informado'}}</td>
                            <td>R$ {{ number_format($gasto->valor, 2, ',', '.') }}</td>
                            <td>
                                @if($gasto->pago)
                                    <span class="badge badge-outline-success">PAGO</span>
                                @else
                                    <span class="badge badge-outline-danger">PENDENTE</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <form action="{{ route('veiculos.gastos.alternar', $gasto->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $gasto->pago ? 'btn-soft-warning' : 'btn-soft-success' }}" title="Alternar Status">
                                        <i class="mdi {{ $gasto->pago ? 'mdi-undo-variant' : 'mdi-check-bold' }} font-18"></i>
                                    </button>
                                    
                                </form>
                                
                                <form action="{{ route('veiculos.gastos.destroy', $gasto->id) }}" method="POST" class="form-delete-gasto" style="display:inline;">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-light text-danger btn-delete-gasto" title="Excluir Gasto">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                Nenhum gasto de preparação registrado para este veículo.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
    $('.btn-delete-gasto').on('click', function(e) {
        e.preventDefault();
        
        let form = $(this).closest('form');

        Swal.fire({
            title: 'Tem certeza?',
            text: "Este gasto será removido permanentemente do Alcecar!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Feedback visual de carregamento
                Swal.fire({
                    title: 'Excluindo...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                form.submit();
            }
        });
    });
});
</script>