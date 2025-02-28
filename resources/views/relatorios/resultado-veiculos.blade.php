@extends('layouts.app')

@section('title', 'Veículos')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('servicos.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Relatórios</li>
                </ol>
            </div>
            <h3 class="page-title">Relatórios</h3>
        </div>
    </div>
</div>
<br>

<div class="card">
    <div class="card-body">
        <form id="formRel" action="{{ route('relatorio.gerar') }}" method="POST">
            @csrf
            <div class="row align-items-end gy-3">
                <div class="col-sm-3">
                    <label for="tipo-relatorio" class="form-label">Tipo de relatório</label>
                    <select class="form-select" id="tipo-relatorio" name="tipo-relatorio">
                        <option selected>-- Selecione o tipo --</option>
                        <option value="Clientes">Clientes</option>
                        <option value="Procurações">Procurações</option>
                        <option value="Veículos">Veículos</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label for="data-inicial" class="form-label">Data Inicial</label>
                    <input class="form-control" id="data-inicial" name="data-inicial" type="date" required>
                </div>
                <div class="col-sm-3">
                    <label for="data-final" class="form-label">Data Final</label>
                    <input class="form-control" id="data-final" name="data-final" type="date">
                </div>
                <div class="col-sm-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary btn-sm">Pesquisar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-between align-items-center">
                <h3 class="page-title">Relatório de {{ $tipo }}</h3>
                <form action="{{ route('rel-veiculos') }}" method="POST" target="_blank">
                    @csrf
                    <input type="hidden" name="tipo" value="{{ $tipo }}">
                    <input type="hidden" name="dataInicial" value="{{ $dataInicial }}">
                    <input type="hidden" name="dataFinal" value="{{ $dataFinal }}">
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-file-pdf"></i> Gerar PDF
                    </button>
                </form>
                
                
            </div>
            <p>Período: {{ Carbon\Carbon::parse($dataInicial)->format('d/m/Y') }} a {{ Carbon\Carbon::parse($dataFinal)->format('d/m/Y') }}</p>
            <div class="table-responsive-sm">
                <table class="table table-hover table-centered mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Veículo</th>
                            <th>Placa</th>
                            <th>Ano/Modelo</th>
                            <th>Cor</th>
                            <th>Renavam</th>
                            <th>Proprietário</th>
                            <th>Cadastrado em</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dados as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->marca }}</td>
                                <td>{{ $item->placa }}</td>
                                <td>{{ $item->ano }}</td>
                                <td>{{ $item->cor }}</td>
                                <td>{{ $item->renavam }}</td>
                                <td>{{ $item->nome }}</td>
                                <td>{{ Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">Nenhum registro encontrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
</div>
@endsection
