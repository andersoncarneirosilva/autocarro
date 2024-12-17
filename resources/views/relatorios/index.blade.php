@extends('layouts.app')

@section('title', 'Procurações')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('servicos.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Serviços</li>
                </ol>
            </div>
            <h3 class="page-title">Serviços</h3>
        </div>
    </div>
</div>
<br>

<div class="card">
    <div class="card-body">
        <div class="row">
            {{-- @if ($errors->any())
                <ul class="errors">
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">{{ $error }}</div>
                    @endforeach
                </ul>
            @endif --}}
            <div class="col-sm-12">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Serviços cadastradas</h4>
                    <div class="dropdown">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#serviceModal">Cadastrar</button>
                        {{-- <button class="btn btn-secondary btn-sm" id="deleteAllSelectedRecord" disabled><i
                                class="fa-solid fa-trash"></i></button> --}}
                    </div>
                </div>
                <div class="table-responsive-sm">
                    <table class="table table-hover table-centered mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>Whatsapp</th>
                                <th>Endereço</th>
                                <th>Cidade</th>
                                <th>Cadastrado em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($clientes as $cli)
                                <tr>
                                    <td>{{ $cli->id }}</td>
                                    <td>{{ $cli->nome }}</td>
                                    <td>{{ $cli->cpf }}</td>
                                    <td>{{ $cli->fone }}</td>
                                    <td>{{ $cli->endereco }}</td>
                                    <td>{{ $cli->cidade }}</td>
                                    <td>{{ Carbon\Carbon::parse($cli->created_at)->format('d/m') }}</td>
                                    <td class="table-action">

                                        <a href="#" class="action-icon" data-id="{{ $cli->id }}" onclick="openEditTextModal(event)">
                                            <i class="mdi mdi-clipboard-edit-outline" title="Editar"></i>

                                        <a href="{{ route('clientes.destroy', $cli->id) }}"
                                            class="action-icon mdi mdi-delete text-danger" data-confirm-delete="true" title="Excluir"></a>
                                            
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                        <a href="{{ route('relatorios.clientes.pdf') }}">Exportar para PDF</a>
                </div>
                    {{-- @elseif($servs->total() == 0)
                        <div class="alert alert-warning bg-transparent text-warning" role="alert">
                            NENHUM RESULTADO ENCONTRADO!
                        </div>
                    @endif --}}
            </div>
        </div>
    </div>
    {{-- <div class="row">
        {{ $servs->appends([
            'search' => request()->get('search', '')
        ])->links('components.pagination') }}
    </div> --}}
    <!-- Single Select -->
<!-- Modal -->
<div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="serviceModalLabel">Detalhes do Serviço</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('servicos.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="serviceName" class="form-label">Serviço</label>
                        <input type="text" class="form-control" id="nome_servico" name="nome_servico">
                    </div>
                    <div class="mb-3">
                        <label for="serviceValue" class="form-label">Valor do Serviço</label>
                        <input type="text" class="form-control money" id="val_servico" name="valor_servico" placeholder="R$ 0,00">
                    </div>

                    

                    <div class="mb-3">
                        <label for="collectionValue" class="form-label">Valor de Arrecadação</label>
                        <input type="text" class="form-control money" id="val_arrec" name="arrecadacao_servico" placeholder="R$ 0,00">
                    </div>
                    <div class="mb-3">
                        <label for="laborCost" class="form-label">Mão de Obra</label>
                        <input type="text" class="form-control money" id="val_mao" name="maodeobra_servico" placeholder="R$ 0,00">
                    </div>
                    <div class="row">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                        </div>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</div>



    @endsection
