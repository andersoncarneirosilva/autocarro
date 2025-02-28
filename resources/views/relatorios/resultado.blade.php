@extends('layouts.app')

@section('title', 'teste')

@section('content')

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Relatórios</h4>
                    <div class="dropdown">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#serviceModal">Cadastrar</button>
                    </div>
                </div>
            </div>
        </div>
        
        <form id="formRel" action="{{ route('relatorio.gerar') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-3">
                    <label for="tipo-relatorio" class="form-label">Tipo de relatório</label>
                    <select class="form-select" id="tipo-relatorio" name="tipo-relatorio">
                        <option selected> -- Selecione o tipo --</option>
                        <option value="Clientes">Clientes</option>
                        <option value="Procurações">Procurações</option>
                        <option value="Veículos">Veículos</option>
                    </select>
                </div>
                <div class="col-lg-3">
                    <label for="data-inicial" class="form-label">Data Inicial</label>
                    <input class="form-control" id="data-inicial" name="data-inicial" type="date" required>
                </div>
                <div class="col-lg-3">
                    <label for="data-final" class="form-label">Data Final</label>
                    <input class="form-control" id="data-final" name="data-final" type="date" required>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-6"></div>
                <div class="col-lg-6 text-end">
                    <button type="submit" class="btn btn-primary btn-sm">Pesquisar</button>
                </div>
            </div>
        </form>
        
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <h1>Relatório de {{ $tipo }}</h1>
            <p>Período: {{ $dataInicial }} a {{ $dataFinal }}</p>
            <div class="table-responsive-sm">
                <table class="table table-hover table-centered mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Data de Criação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dados as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->nome ?? 'Detalhes do Item' }}</td>
                                <td>{{ $item->cpf }}</td>
                                <td>{{ $item->created_at }}</td>
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
