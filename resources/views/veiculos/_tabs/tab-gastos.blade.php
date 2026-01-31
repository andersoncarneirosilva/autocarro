<div class="row mt-2">
    <div class="col-md-12 px-md-3">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h4 class="header-title text-primary mb-0 text-uppercase" style="letter-spacing: 1px;">
                Gastos de Preparação
            </h4>
            
            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-plus me-1"></i> Novo Lançamento <i class="mdi mdi-chevron-down"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end shadow">
                    <a class="dropdown-item py-2" href="#" data-bs-toggle="modal" data-bs-target="#modalCadastrarGasto">
                        <i class="mdi mdi-wrench text-muted me-2"></i> Gasto de Preparação
                    </a>
                    <a class="dropdown-item py-2" href="#" data-bs-toggle="modal" data-bs-target="#modalCadastrarMulta">
                        <i class="mdi mdi-alert-decagram text-danger me-2"></i> Multa de Trânsito
                    </a>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Data</th>
                        <th>Descrição</th>
                        <th>Categoria</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th class="text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalGastos = 0; @endphp
                    @forelse($veiculo->gastos as $gasto)
                        @php $totalGastos += $gasto->valor; @endphp
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($gasto->data_gasto)->format('d/m/Y') }}</td>
                            <td><strong>{{ $gasto->descricao }}</strong></td>
                            <td>
                                <span class="text-muted small text-uppercase">{{ $gasto->categoria }}</span>
                            </td>
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
                            <td colspan="6" class="text-center py-4 text-muted">
                                Nenhum gasto de preparação registrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                
                @if($veiculo->gastos->count() > 0)
                <tfoot class="bg-light">
                    <tr>
                        <td colspan="3" class="text-right fw-bold text-dark">TOTAL EM GASTOS:</td>
                        <td class="fw-bold text-danger" style="font-size: 1.1rem;">
                            R$ {{ number_format($totalGastos, 2, ',', '.') }}
                        </td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
                @endif
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