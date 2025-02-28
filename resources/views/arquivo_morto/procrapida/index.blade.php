@extends('layouts.app')

@section('title', 'Procurações')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Procurações</li>
                </ol>
            </div>
            <h3 class="page-title">Procurações</h3>
        </div>
    </div>
</div>
<br>
{{-- <div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('clientes.index') }}" method="GET">
                    <div class="filter-select-container">
                        <select class="select2 form-control select2" name="cliente[]" id="idCliente" data-toggle="select2">
                            <option value="" selected>Cliente</option>
                            @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->nome }}">{{ $cliente->nome }}</option>
                            @endforeach
                        </select>
                        
                            <input type="text" class="form-control" id="" data-toggle="date-picker" data-single-date-picker="true" placeholder="Date and Time">
                         
                    </div>
            </div>

            <div class="col-md-6 text-end">
                <button type="submit" class="filter-btn btn-light">Filtrar</button>
            </div>
            </form>
        </div>
    </div>
</div> --}}
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
                    <h4 class="header-title">Procurações cadastradas</h4>
                    <div class="dropdown">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#standard-modal">Cadastrar</button>
                        <a href="{{ route('relatorio-procuracoes')}}" target="_blank" class="btn btn-danger btn-sm">Relatório</a>
                        {{-- <button class="btn btn-secondary btn-sm" id="deleteAllSelectedRecord" disabled><i
                                class="fa-solid fa-trash"></i></button> --}}
                    </div>
                </div>
                @if ($docs->total() != 0)
                <div class="table-responsive-sm">
                    <table class="table table-hover table-centered mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>Veículo</th>
                                <th>Placa</th>
                                <th>Ano/Modelo</th>
                                <th>Renavam</th>
                                <th>Gerado em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($docs as $doc)
                                <tr>
                                    <td>{{ $doc->nome }}</td>
                                    <td>{{ $doc->cpf }}</td>
                                    <td>{{ $doc->marca }}</td>
                                    <td>{{ $doc->placa }}</td>
                                    <td>{{ $doc->ano }}</td>
                                    <td>{{ $doc->renavam }}</td>
                                    <td>{{ Carbon\Carbon::parse($doc->created_at)->format('d/m/Y') }}</td>
                                    <td class="table-action">
                                                <a href="{{ $doc->arquivo_doc }}" class="action-icon" target="blank">
                                                    <i class="mdi mdi-printer"></i>
                                                </a>
                                                
                                        <a href="{{ route('procuracoes.destroy', $doc->id) }}"
                                            class="action-icon mdi mdi-delete text-danger" data-confirm-delete="true"></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                    @elseif($docs->total() == 0)
                        <div class="alert alert-danger bg-transparent text-danger" role="alert">
                            NENHUM RESULTADO ENCONTRADO!
                        </div>
                    @endif
            </div>
        </div>
    </div>
    <div class="row">
        {{ $docs->appends([
            'search' => request()->get('search', '')
        ])->links('components.pagination') }}
    </div>
</div>



<div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Cadastro rápido</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <form action="{{ route('procrapida.store') }}" method="POST" enctype="multipart/form-data" id="formProc">
                @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label>Endereço: <span style="color: red;">*</span></label>
                            <div class="col-lg">
                                <input type="text" class="form-control"  name="endereco">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Documento: <span style="color: red;">*</span></label>
                            <div class="col-lg">
                                <input class="form-control" type="file" name="arquivo_doc" id="arquivo_doc">
                            </div>
                        </div>
                    </div>
                </div>

                <br>
                <div class="row">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </div>
                </div>
            </div>
            </form>
            
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


@endsection
