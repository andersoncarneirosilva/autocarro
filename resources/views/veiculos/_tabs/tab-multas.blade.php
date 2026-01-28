<div class="row">
        <div class="col-md-12 px-md-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="header-title text-primary mb-0 text-uppercase" style="letter-spacing: 1px;">
                    Histórico de Multas
                </h4>
                <span class="badge badge-info">{{ $multas->count() }} Registro(s)</span>
            </div>

            <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Cód. Infração</th>
                        <th>Descrição</th>
                        <th>Órgão Emissor</th>
                        <th>Data Infração</th>
                        <th>Vencimento</th>
                        <th>Valor</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($multas as $multa)
                        <tr>
                            <td><strong>{{ $multa->codigo_infracao }}</strong></td>
                            <td>{{ $multa->descricao }}</td>
                            <td>{{ $multa->orgao_emissor ?? 'Não informado'}}</td>
                            <td>{{ \Carbon\Carbon::parse($multa->data_infracao)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($multa->data_vencimento)->format('d/m/Y') }}</td>
                            <td>R$ {{ number_format($multa->valor, 2, ',', '.') }}</td>
                            <td>
                                @php
                                $statusClasses = [
                                    'pago' => 'badge-outline-success',
                                    'pendente' => 'badge-outline-danger',
                                    'recurso' => 'badge-outline-warning'
                                ];
                            @endphp
                            <span class="badge {{ $statusClasses[$multa->status] ?? 'badge-outline-secondary' }}">
                                {{ strtoupper($multa->status) }}
                            </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                Nenhuma multa registrada para este veículo.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


        </div>
    </div>
