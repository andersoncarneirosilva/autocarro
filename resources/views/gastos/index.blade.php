@extends('layouts.app')

@section('content')

{{-- Modais Unificados --}}
@include('gastos._modals.cadastro-gasto')
{{-- @include('gastos._modals.cadastro-multa') --}}

@include('components.toast')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Custos e Preparação</li>
                </ol>
            </div>
            <h3 class="page-title">Gestão de Custos</h3>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body p-2">

        <div class="row align-items-center mb-4">
            <div class="col-md-4">
                <h4 class="header-title mb-1 text-dark fw-bold">Histórico de Lançamentos</h4>
                <p class="text-muted font-13 mb-0">Custos de oficina e infrações unificados.</p>
            </div>
            
            <div class="col-md-8">
                <div class="d-flex flex-wrap align-items-center justify-content-sm-end gap-3">
                    <div class="search-box">
                        <form action="{{ route('gastos.index') }}" method="GET" class="d-flex flex-wrap align-items-center">
                            <div class="input-group" style="width: 300px;">
                                <input type="text" name="search" class="form-control" placeholder="Placa, descrição ou categoria..." value="{{ request('search') }}">
                                <button class="btn btn-secondary" type="submit">
                                    <i class="mdi mdi-magnify"></i>
                                </button>
                            </div>
                        </form>
                    </div>

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
            </div>
        </div>

        @if ($gastos->total() != 0)
        <div class="table-custom-container">
            <table class="table table-custom table-nowrap table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Veículo / Placa</th>
                        <th>Descrição / Detalhes</th>
                        <th>Data</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    @foreach ($gastos as $gasto)
                    <tr>
                        <td class="d-flex align-items-center">
                            <div class="me-3">
                                {{-- Cor do círculo muda se for multa --}}
                                <div class="rounded-circle d-flex align-items-center justify-content-center {{ $gasto->categoria == 'Multa' ? 'bg-danger' : 'bg-primary' }} text-white shadow-sm" 
                                    style="width: 40px; height: 40px; font-weight: bold; font-size: 0.9rem; text-transform: uppercase;">
                                    {{ substr($gasto->veiculo->placa, -3) }}
                                </div>
                            </div>
                            <div>
                                <span class="fw-bold d-block text-dark">{{ $gasto->veiculo->marca }} {{ $gasto->veiculo->modelo }}</span>
                                <small class="badge bg-light text-dark border">{{ $gasto->veiculo->placa }}</small>
                            </div>
                        </td>
                        <td>
                            <span class="fw-bold d-block text-truncate" style="max-width: 250px;">
                                @if($gasto->categoria == 'Multa')  @endif
                                {{ $gasto->descricao }}
                            </span>
                            <small class="text-muted text-uppercase">
                                {{ $gasto->categoria }} 
                                @if($gasto->codigo_infracao) • Cód: {{ $gasto->codigo_infracao }} @endif
                            </small>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($gasto->data_gasto)->format('d/m/Y') }}</td>
                        <td>
                            <span class="fw-bold text-dark">
                                R$ {{ number_format($gasto->valor, 2, ',', '.') }}
                            </span>
                        </td>
                        <td>
                            @if($gasto->pago)
                                <span class="badge badge-outline-success">PAGO</span>
                            @else
                                <span class="badge badge-outline-danger">PENDENTE</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-2">
                                {{-- Alternar Pagamento --}}
                                <form action="{{ route('veiculos.gastos.alternar', $gasto->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $gasto->pago ? 'btn-soft-warning' : 'btn-soft-success' }}" 
                                            title="{{ $gasto->pago ? 'Estornar Pagamento' : 'Confirmar Pagamento' }}">
                                        <i class="mdi {{ $gasto->pago ? 'mdi-undo-variant' : 'mdi-check-bold' }} font-18"></i>
                                    </button>
                                </form>

                                {{-- Botão Excluir com SweetAlert (conforme configuramos) --}}
                                <form action="{{ route('veiculos.gastos.destroy', $gasto->id) }}" method="POST" class="form-delete-gasto">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-soft-danger btn-delete-gasto" title="Excluir">
                                        <i class="mdi mdi-trash-can-outline font-18"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Paginação --}}
        <div class="mt-4 d-flex justify-content-between align-items-center">
            <div class="text-muted font-13">
                Total de investimentos: <b class="text-dark">R$ {{ number_format($gastos->sum('valor'), 2, ',', '.') }}</b>
            </div>
            <nav>
                {{ $gastos->appends(request()->query())->links('components.pagination') }}
            </nav>
        </div>

        @else
            <div class="alert alert-info bg-transparent text-info" role="alert">
                <i class="mdi mdi-information-outline me-2"></i>Nenhum custo ou multa registrada para o estoque.
            </div>
        @endif
    </div>
</div>

@endsection